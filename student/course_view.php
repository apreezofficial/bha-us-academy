<?php
require_once '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$course_id = $_GET['course_id'] ?? ($_GET['id'] ?? null);
$lesson_id = $_GET['lesson_id'] ?? null;

if (!$course_id) {
    header("Location: dashboard.php");
    exit;
}

// Fetch enrollment
$stmt = $pdo->prepare("SELECT * FROM enrollments WHERE user_id = ? AND course_id = ?");
$stmt->execute([$user_id, $course_id]);
$enrollment = $stmt->fetch();

if (!$enrollment) {
    header("Location: courses.php?error=not_enrolled");
    exit;
}

// Handle Mark as Complete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_complete'])) {
    $target_lesson_id = $_POST['lesson_id'];
    $stmt = $pdo->prepare("INSERT IGNORE INTO lesson_progress (user_id, lesson_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $target_lesson_id]);
    
    $stmt = $pdo->prepare("SELECT id FROM lessons WHERE course_id = ? AND sort_order > (SELECT sort_order FROM lessons WHERE id = ?) ORDER BY sort_order ASC LIMIT 1");
    $stmt->execute([$course_id, $target_lesson_id]);
    $next_lesson = $stmt->fetchColumn();
    
    if ($next_lesson) {
        header("Location: course_view.php?course_id=$course_id&lesson_id=$next_lesson&success=lesson_complete");
    } else {
        header("Location: course_view.php?course_id=$course_id&lesson_id=$target_lesson_id&success=course_finished");
    }
    exit;
}

// Fetch Course and Syllabus (ALL modules)
$stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch();

$stmt = $pdo->prepare("SELECT * FROM lessons WHERE course_id = ? ORDER BY sort_order ASC");
$stmt->execute([$course_id]);
$lessons = $stmt->fetchAll();

// Current Lesson
if (!$lesson_id && !empty($lessons)) {
    $lesson_id = $lessons[0]['id'];
}

$current_lesson = null;
foreach ($lessons as $l) {
    if ($l['id'] == $lesson_id) {
        $current_lesson = $l;
        break;
    }
}

// Fetch Completed Lessons
$stmt = $pdo->prepare("SELECT lesson_id FROM lesson_progress WHERE user_id = ?");
$stmt->execute([$user_id]);
$completed_lessons = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Fetch Exam
$stmt = $pdo->prepare("SELECT id FROM exams WHERE course_id = ?");
$stmt->execute([$course_id]);
$exam_id = $stmt->fetchColumn();

// Progress Calculation
$all_completed = count($lessons) > 0 && count(array_intersect($completed_lessons, array_column($lessons, 'id'))) === count($lessons);
$progress = count($lessons) > 0 ? round(count(array_intersect($completed_lessons, array_column($lessons, 'id'))) / count($lessons) * 100) : 0;

$pageTitle = "Classroom";
include '../includes/header_student.php';
?>

<div class="flex flex-col lg:flex-row gap-8">
    <!-- Main Lesson Content -->
    <div class="flex-1 min-w-0">
        <?php if ($current_lesson): ?>
            <article class="bg-card border rounded-3xl p-6 md:p-12 shadow-sm mb-8">
                <header class="mb-10">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 rounded-full bg-brandBlue/10 text-brandBlue text-[10px] font-bold uppercase tracking-widest">
                            Unit <?php echo array_search($current_lesson['id'], array_column($lessons, 'id')) + 1; ?>
                        </span>
                        <span class="text-[10px] text-muted-foreground uppercase font-bold tracking-widest opacity-60">
                            Available Content
                        </span>
                    </div>
                    <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight mb-4"><?php echo $current_lesson['title']; ?></h1>
                </header>

                <?php if ($current_lesson['video_url']): ?>
                    <div class="aspect-video bg-black rounded-2xl overflow-hidden mb-10 shadow-xl border">
                        <iframe class="w-full h-full" src="<?php echo str_replace('watch?v=', 'embed/', $current_lesson['video_url']); ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                <?php endif; ?>

                <div class="prose prose-sm md:prose-base dark:prose-invert max-w-none 
                    prose-headings:font-black prose-headings:tracking-tight 
                    prose-p:leading-relaxed prose-p:text-muted-foreground 
                    prose-strong:text-foreground">
                    <?php echo $current_lesson['content']; ?>
                </div>

                <div class="mt-12 pt-8 border-t flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold">Module Attestation</h3>
                        <p class="text-xs text-muted-foreground">Confirm comprehension of the clinical material.</p>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="lesson_id" value="<?php echo $current_lesson['id']; ?>">
                        <?php if (in_array($current_lesson['id'], $completed_lessons)): ?>
                            <button disabled class="h-12 px-8 bg-muted text-brandGreen rounded-xl font-bold flex items-center justify-center gap-3 border text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                Completed
                            </button>
                        <?php else: ?>
                            <button type="submit" name="mark_complete" class="h-12 px-10 bg-primary text-primary-foreground rounded-xl font-bold flex items-center justify-center gap-3 hover:opacity-90 shadow-lg transition-all group text-sm">
                                Mark as Complete
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><path d="m9 18 6-6-6-6"></path></svg>
                            </button>
                        <?php endif; ?>
                    </form>
                </div>
            </article>
        <?php else: ?>
            <div class="text-center py-20 bg-card border border-dashed rounded-3xl">
                <h2 class="text-2xl font-bold mb-4">No content found</h2>
                <p class="text-muted-foreground">Select a module from the curriculum menu.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Curriculum Sidebar (Inside Content) -->
    <div class="w-full lg:w-80 shrink-0 space-y-6">
        <div class="bg-card border rounded-3xl p-6 shadow-sm sticky top-24">
            <h2 class="text-sm font-bold uppercase tracking-widest mb-4 opacity-70">Course Syllabus</h2>
            <div class="space-y-2 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                <?php foreach ($lessons as $index => $l): ?>
                    <?php $is_completed = in_array($l['id'], $completed_lessons); ?>
                    <?php $is_active = $l['id'] == $lesson_id; ?>
                    <a href="course_view.php?course_id=<?php echo $course_id; ?>&lesson_id=<?php echo $l['id']; ?>" 
                       class="flex items-center gap-3 p-3 rounded-xl transition-all border <?php echo $is_active ? 'bg-primary text-primary-foreground border-primary shadow-md' : ($is_completed ? 'bg-brandGreen/5 text-brandGreen border-brandGreen/20' : 'bg-background hover:border-brandBlue text-muted-foreground'); ?>">
                        <div class="h-8 w-8 rounded-lg flex items-center justify-center shrink-0 <?php echo $is_active ? 'bg-primary-foreground text-primary' : ($is_completed ? 'bg-brandGreen text-white' : 'bg-muted'); ?>">
                            <?php if ($is_completed): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <?php else: ?>
                                <span class="font-bold text-xs"><?php echo $index + 1; ?></span>
                            <?php endif; ?>
                        </div>
                        <span class="text-sm font-bold truncate"><?php echo $l['title']; ?></span>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Progress Summary -->
            <div class="mt-6 pt-6 border-t">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-muted-foreground uppercase tracking-widest">Progress</span>
                    <span class="text-xs font-black"><?php echo $progress; ?>%</span>
                </div>
                <div class="h-1.5 w-full bg-muted rounded-full overflow-hidden">
                    <div class="h-full bg-brandBlue transition-all duration-1000" style="width: <?php echo $progress; ?>%"></div>
                </div>
            </div>

            <!-- Exam Integration -->
            <?php if ($exam_id): ?>
                <div class="mt-8 pt-6 border-t border-dashed">
                    <?php if ($all_completed): ?>
                        <a href="exam_view.php?id=<?php echo $exam_id; ?>" class="flex items-center gap-3 p-4 rounded-2xl bg-brandBlue text-white shadow-lg hover:shadow-brandBlue/20 hover:-translate-y-0.5 transition-all group">
                            <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:rotate-12 transition-transform"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-bold uppercase tracking-widest opacity-80">Certification</p>
                                <p class="text-sm font-black truncate">Final Assessment</p>
                            </div>
                        </a>
                    <?php else: ?>
                        <div class="flex items-center gap-3 p-4 rounded-2xl bg-muted/50 text-muted-foreground border border-dashed opacity-60 cursor-not-allowed">
                            <div class="h-10 w-10 rounded-xl bg-muted flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-bold uppercase tracking-widest">Locked</p>
                                <p class="text-sm font-bold">Complete All Units</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: hsl(var(--muted)); border-radius: 10px; }
</style>

<?php include '../includes/footer_student.php'; ?>
