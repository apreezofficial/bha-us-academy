<?php
require_once '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];

// Fetch all exams for enrolled courses
$stmt = $pdo->prepare("
    SELECT e.*, c.title as course_title, c.image as course_image,
           (SELECT COUNT(*) FROM lessons l WHERE l.course_id = c.id) as total_lessons,
           (SELECT COUNT(*) FROM lesson_progress lp 
            JOIN lessons l ON lp.lesson_id = l.id 
            WHERE lp.user_id = ? AND l.course_id = c.id) as completed_lessons,
           er.score as latest_score, er.status as exam_status, er.created_at as exam_date
    FROM exams e
    JOIN courses c ON e.course_id = c.id
    JOIN enrollments env ON c.id = env.course_id
    LEFT JOIN exam_results er ON e.id = er.exam_id AND er.user_id = ?
    WHERE env.user_id = ?
    ORDER BY c.title ASC
");
$stmt->execute([$user_id, $user_id, $user_id]);
$assessments = $stmt->fetchAll();

$pageTitle = "Assessments";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="max-w-xl">
            <h1 class="text-4xl font-black tracking-tighter mb-4 leading-none uppercase">Assessments Console</h1>
            <p class="text-muted-foreground font-medium">Verify your clinical expertise and claim your professional certifications.</p>
        </div>
        
        <div class="flex items-center gap-2 bg-muted/30 px-4 py-2 rounded-full border border-dashed">
            <span class="text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Qualification Status</span>
            <div class="h-2 w-2 rounded-full bg-brandGreen"></div>
            <span class="text-xs font-bold leading-none">Ready for Evaluation</span>
        </div>
    </div>

    <!-- Assessments Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($assessments as $item): ?>
            <?php 
                $is_ready = $item['completed_lessons'] >= $item['total_lessons'] && $item['total_lessons'] > 0;
                $is_passed = $item['exam_status'] === 'pass';
            ?>
            <div class="group bg-card border rounded-[2rem] p-8 transition-all hover:border-brandBlue shadow-sm hover:shadow-xl relative overflow-hidden flex flex-col">
                <!-- Status Badge -->
                <div class="absolute top-6 right-8">
                    <?php if ($is_passed): ?>
                        <span class="px-3 py-1 bg-brandGreen/10 text-brandGreen text-[10px] font-black uppercase tracking-widest rounded-full border border-brandGreen/20">Certified</span>
                    <?php elseif ($is_ready): ?>
                        <span class="px-3 py-1 bg-brandBlue/10 text-brandBlue text-[10px] font-black uppercase tracking-widest rounded-full border border-brandBlue/20 animate-pulse">Unlocked</span>
                    <?php else: ?>
                        <span class="px-3 py-1 bg-muted text-muted-foreground text-[10px] font-black uppercase tracking-widest rounded-full border">Locked</span>
                    <?php endif; ?>
                </div>

                <div class="flex items-center gap-4 mb-8">
                    <div class="h-16 w-16 rounded-2xl bg-muted overflow-hidden shrink-0 border">
                        <img src="<?php echo img_url($item['course_image']); ?>" class="h-full w-full object-cover">
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-60 mb-1">Qualifying Course</p>
                        <h3 class="text-lg font-bold leading-tight truncate"><?php echo $item['course_title']; ?></h3>
                    </div>
                </div>

                <div class="flex-1 space-y-6">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-wider">
                            <span class="text-muted-foreground">Preparation</span>
                            <span class="<?php echo $is_ready ? 'text-brandGreen' : 'text-brandBlue'; ?>">
                                <?php echo $item['completed_lessons']; ?>/<?php echo $item['total_lessons']; ?> Units
                            </span>
                        </div>
                        <div class="h-1.5 w-full bg-muted rounded-full overflow-hidden">
                            <div class="h-full bg-brandBlue transition-all duration-1000" style="width: <?php echo $item['total_lessons'] > 0 ? ($item['completed_lessons']/$item['total_lessons']*100) : 0; ?>%"></div>
                        </div>
                    </div>

                    <div class="bg-muted/30 rounded-2xl p-6 border border-dashed text-center">
                        <?php if ($item['latest_score'] !== null): ?>
                            <p class="text-[10px] font-bold text-muted-foreground uppercase mb-1">Latest Performance</p>
                            <p class="text-3xl font-black <?php echo $is_passed ? 'text-brandGreen' : 'text-destructive'; ?>">
                                <?php echo round($item['latest_score']); ?>%
                            </p>
                            <p class="text-[10px] text-muted-foreground font-medium mt-1">Attempted <?php echo date('M d, Y', strtotime($item['exam_date'])); ?></p>
                        <?php else: ?>
                            <div class="py-2">
                                <p class="text-[10px] font-bold text-muted-foreground uppercase">Assessment Result</p>
                                <p class="text-sm font-bold opacity-40">No attempts recorded</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-8">
                    <?php if ($is_passed): ?>
                        <a href="certificate_pay.php?id=<?php echo $item['course_id']; ?>" class="w-full h-12 bg-brandGreen text-white rounded-xl font-bold flex items-center justify-center transition-all hover:opacity-90 shadow-lg shadow-brandGreen/20">
                            Claim Certificate
                        </a>
                    <?php elseif ($is_ready): ?>
                        <a href="exam_view.php?id=<?php echo $item['id']; ?>" class="w-full h-12 bg-brandBlue text-white rounded-xl font-bold flex items-center justify-center transition-all hover:opacity-90 shadow-lg shadow-brandBlue/20 group/btn">
                            Start Assessment
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2 group-hover:translate-x-1 transition-transform"><path d="m9 18 6-6-6-6"></path></svg>
                        </a>
                    <?php else: ?>
                        <button disabled class="w-full h-12 bg-muted text-muted-foreground rounded-xl font-bold flex items-center justify-center cursor-not-allowed opacity-60">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            Training Incomplete
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($assessments)): ?>
            <div class="col-span-full py-40 bg-card border border-dashed rounded-[3rem] text-center">
                <div class="h-20 w-20 bg-muted rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground/30"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-2">No Assessments Pending</h3>
                <p class="text-muted-foreground mb-8">Enroll in our professional courses to begin your evaluation process.</p>
                <a href="courses.php" class="inline-flex h-12 px-10 bg-primary text-primary-foreground rounded-xl font-bold items-center justify-center hover:opacity-90 transition-all">Browse Catalog</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
