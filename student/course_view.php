<?php
require_once '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$course_id = $_GET['course_id'] ?? ($_GET['id'] ?? null); // Handle both id and course_id
$lesson_id = $_GET['lesson_id'] ?? null;

if (!$course_id) {
    header("Location: dashboard.php");
    exit;
}

// Check enrollment
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
    
    // Redirect to next lesson if exists
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

// Fetch Course and Syllabus
$stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch();

$stmt = $pdo->prepare("SELECT * FROM lessons WHERE course_id = ? ORDER BY sort_order ASC");
$stmt->execute([$course_id]);
$lessons = $stmt->fetchAll();

// Fetch Exam
$stmt = $pdo->prepare("SELECT * FROM exams WHERE course_id = ?");
$stmt->execute([$course_id]);
$exam = $stmt->fetch();

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

// Progress Check
$all_completed = count(array_intersect($completed_lessons, array_column($lessons, 'id'))) === count($lessons);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $course['title']; ?> | Classroom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandBlue: '#0056b3',
                        brandGreen: '#28a745',
                    },
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .classroom-grid {
            display: grid;
            grid-template-columns: 400px 1fr;
        }
        .custom-prose h2 { font-size: 2.5rem; font-weight: 800; color: #111827; margin-top: 4rem; margin-bottom: 2rem; border-left: 8px solid #0056b3; padding-left: 1.5rem; letter-spacing: -0.05em; }
        .custom-prose p { font-size: 1.25rem; line-height: 2; color: #4B5563; margin-bottom: 2.5rem; }
        .custom-prose ul { list-style: none; padding: 0; margin-bottom: 3rem; }
        .custom-prose li { position: relative; padding-left: 2.5rem; margin-bottom: 1rem; font-size: 1.15rem; color: #4B5563; font-weight: 500; }
        .custom-prose li::before { content: '✓'; position: absolute; left: 0; top: 0; color: #28a745; font-weight: 900; background: #e8f5e9; width: 28px; height: 28px; display: flex; items-center; justify-content: center; border-radius: 8px; font-size: 14px; }
        
        .classroom-sidebar { height: 100vh; position: sticky; top: 0; }
        .sidebar-blur { backdrop-filter: blur(40px); background: rgba(255, 255, 255, 0.85); }
    </style>
</head>
<body class="bg-[#F3F4F6] font-outfit text-gray-900 overflow-hidden">

    <div class="classroom-grid min-h-screen">
        <!-- Sidebar Syllabus Overhauled -->
        <aside class="classroom-sidebar sidebar-blur border-r border-gray-200/50 flex flex-col z-20 shadow-2xl">
            <div class="p-10 border-b border-gray-100">
                <a href="dashboard.php" class="inline-flex items-center text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-8 hover:text-brandBlue transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Command Center
                </a>
                <h2 class="text-3xl font-[900] text-gray-900 leading-[1.1] tracking-tighter mb-6"><?php echo $course['title']; ?></h2>
                <div class="relative pt-1">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <span class="text-[10px] font-black inline-block py-1 px-2 uppercase rounded-full text-brandGreen bg-green-50">
                                <?php echo round(count(array_intersect($completed_lessons, array_column($lessons, 'id'))) / count($lessons) * 100); ?>% Progress
                            </span>
                        </div>
                    </div>
                    <div class="overflow-hidden h-2.5 mb-4 text-xs flex rounded-full bg-gray-100">
                        <div style="width:<?php echo (count(array_intersect($completed_lessons, array_column($lessons, 'id'))) / count($lessons)) * 100; ?>%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-brandGreen transition-all duration-1000"></div>
                    </div>
                </div>
            </div>

            <div class="flex-grow overflow-y-auto p-10 space-y-6">
                <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.4em] mb-4">Module Curriculum</p>
                <?php foreach ($lessons as $index => $l): ?>
                    <?php $is_completed = in_array($l['id'], $completed_lessons); ?>
                    <?php $is_active = $l['id'] == $lesson_id; ?>
                    <a href="course_view.php?course_id=<?php echo $course_id; ?>&lesson_id=<?php echo $l['id']; ?>" 
                       class="flex items-center p-6 rounded-[2.5rem] transition-all duration-500 <?php echo $is_active ? 'bg-white shadow-2xl shadow-brandBlue/10 border-l-[12px] border-brandBlue -translate-x-2' : ($is_completed ? 'opacity-70 group' : 'hover:bg-white/50'); ?>">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mr-6 shrink-0 transition-transform duration-500 <?php echo $is_active ? 'bg-brandBlue text-white scale-110' : ($is_completed ? 'bg-brandGreen text-white' : 'bg-gray-100 text-gray-400'); ?>">
                            <?php if ($is_completed): ?>
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <?php else: ?>
                                <span class="text-xl font-black"><?php echo $index + 1; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow min-w-0">
                            <h4 class="text-lg font-[800] text-gray-900 truncate tracking-tight mb-1"><?php echo $l['title']; ?></h4>
                            <p class="text-[10px] uppercase font-black tracking-widest text-gray-400">Section <?php echo $index + 1; ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>

                <?php if ($exam): ?>
                    <div class="pt-12 mt-12 border-t border-gray-100">
                        <?php if ($all_completed): ?>
                            <a href="exam_view.php?exam_id=<?php echo $exam['id']; ?>" class="flex items-center p-8 rounded-[3rem] bg-brandBlue text-white shadow-3xl shadow-brandBlue/40 hover:scale-105 transition-all duration-500 relative group overflow-hidden">
                                <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <div class="relative z-10 flex-grow">
                                    <h4 class="text-2xl font-[900] leading-none mb-1">Final Exam</h4>
                                    <p class="text-xs font-bold uppercase tracking-widest opacity-70">Certification Unlock</p>
                                </div>
                                <svg class="w-10 h-10 opacity-40 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04default_api:6A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </a>
                        <?php else: ?>
                            <div class="flex items-center p-8 rounded-[3rem] bg-gray-100 text-gray-400 grayscale cursor-not-allowed">
                                <div class="flex-grow">
                                    <h4 class="text-2xl font-[900] leading-none mb-1">Final Exam</h4>
                                    <p class="text-xs font-bold uppercase tracking-widest opacity-70">LOCKED (Finish all units)</p>
                                </div>
                                <svg class="w-10 h-10 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </aside>

        <!-- Lesson Content Overhauled -->
        <main class="flex-grow overflow-y-auto bg-white relative z-10">
            <?php if ($current_lesson): ?>
                <div class="max-w-[1000px] mx-auto py-32 px-16">
                    <div class="mb-24">
                        <div class="flex items-center space-x-6 mb-12">
                            <span class="bg-blue-50 text-brandBlue text-xs font-[900] px-6 py-2.5 rounded-2xl uppercase tracking-[0.2em] shadow-sm">Core Clinical Instruction</span>
                            <span class="w-1.5 h-1.5 bg-gray-200 rounded-full"></span>
                            <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">CPD Reference: UK-<?php echo strtoupper(substr(md5($current_lesson['title']),0,6)); ?></span>
                        </div>
                        <h1 class="text-8xl lg:text-[7rem] font-[900] text-gray-900 tracking-[-0.07em] mb-12 leading-[0.85]"><?php echo $current_lesson['title']; ?></h1>
                        <p class="text-3xl text-gray-400 font-medium leading-normal tracking-tight max-w-3xl">This module covers essential clinical protocols required for professional compliance in the UK healthcare setting.</p>
                    </div>

                    <?php if ($current_lesson['video_url']): ?>
                        <div class="aspect-video bg-gray-950 rounded-[5rem] overflow-hidden mb-24 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.3)] border-[12px] border-white ring-1 ring-gray-100">
                            <iframe class="w-full h-full scale-105" src="<?php echo str_replace('watch?v=', 'embed/', $current_lesson['video_url']); ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>

                    <div class="custom-prose mb-32">
                        <?php echo $current_lesson['content']; ?>
                    </div>

                    <!-- Bottom Navigation -->
                    <div class="mt-20 pt-20 border-t-4 border-gray-50 flex flex-col md:flex-row justify-between items-center gap-12 bg-gray-50/50 p-16 rounded-[4rem]">
                        <div class="max-w-md">
                            <h5 class="text-4xl font-[900] text-gray-900 mb-4 tracking-tighter">Module Proficiency</h5>
                            <p class="text-xl text-gray-500 font-medium leading-relaxed">By clicking 'Mark as Complete', you confirm your full understanding of the above clinical material.</p>
                        </div>
                        <form method="POST">
                            <input type="hidden" name="lesson_id" value="<?php echo $current_lesson['id']; ?>">
                            <?php if (in_array($current_lesson['id'], $completed_lessons)): ?>
                                <button disabled class="bg-white text-brandGreen px-16 py-8 rounded-[3rem] font-[900] text-2xl flex items-center shadow-xl border border-green-50">
                                    <svg class="w-8 h-8 mr-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 010 1.414l-3 3a1 1 0 01-1.414 0l-1.5-1.5a1 1 0 111.414-1.414L10 11.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    Done & Verified
                                </button>
                            <?php else: ?>
                                <button type="submit" name="mark_complete" class="bg-brandBlue text-white px-20 py-8 rounded-[3rem] font-[900] text-2xl hover:scale-110 active:scale-95 transition-all duration-500 shadow-[0_30px_60px_-15px_rgba(0,86,179,0.3)] group flex items-center uppercase tracking-widest">
                                    Mark as Complete
                                    <svg class="ml-4 w-8 h-8 group-hover:translate-x-3 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="h-full flex flex-col items-center justify-center p-20 text-center">
                    <div class="w-64 h-64 bg-gray-50 rounded-[4rem] flex items-center justify-center mb-12 shadow-sm border border-gray-100">
                        <svg class="w-32 h-32 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h2 class="text-4xl font-[900] text-gray-900 tracking-tighter mb-4 uppercase">Select a Unit</h2>
                    <p class="text-xl text-gray-400 font-medium">Use the curriculum sidebar to start your clinical journey.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>

</body>
</html>
