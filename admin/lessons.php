<?php
require_once '../includes/auth.php';
require_once '../includes/ai_service.php';
requireAdmin();

$course_id = $_GET['course_id'] ?? null;
if (!$course_id) {
    header("Location: courses.php");
    exit();
}

// Fetch Course
$stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch();

$ai = new AIService();
$message = '';

// Handle Lesson Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_lesson'])) {
    $title = $_POST['title'] ?? '';
    $auto_gen = isset($_POST['auto_gen']);
    $content = $_POST['content'] ?? '';

    if ($auto_gen) {
        $content = $ai->generateLessonContent($course['title'], $title);
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO lessons (course_id, title, content) VALUES (?, ?, ?)");
        $stmt->execute([$course_id, $title, $content]);
        $message = "Lesson '$title' added successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Handle AI Exam Generation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gen_exam'])) {
    $topic = $_POST['exam_topic'] ?? $course['title'];
    $questions = $ai->generateExamQuestions($topic);

    if ($questions) {
        try {
            // First create Exam record
            $stmt = $pdo->prepare("INSERT INTO exams (course_id, title) VALUES (?, ?)");
            $stmt->execute([$course_id, "Assessment: " . $topic]);
            $exam_id = $pdo->lastInsertId();

            // Insert questions
            $q_stmt = $pdo->prepare("INSERT INTO questions (exam_id, question_text, options, correct_answer) VALUES (?, ?, ?, ?)");
            foreach ($questions as $q) {
                $q_stmt->execute([$exam_id, $q['question'], json_encode($q['options']), $q['correct_answer']]);
            }
            $message = "AI Exam generated with " . count($questions) . " questions!";
        } catch (PDOException $e) {
            $message = "Database Error: " . $e->getMessage();
        }
    } else {
        $message = "AI failed to generate questions. Please try again.";
    }
}

// Fetch Lessons
$stmt = $pdo->prepare("SELECT * FROM lessons WHERE course_id = ? ORDER BY sort_order ASC");
$stmt->execute([$course_id]);
$lessons = $stmt->fetchAll();

// Fetch Exams
$stmt = $pdo->prepare("SELECT * FROM exams WHERE course_id = ?");
$stmt->execute([$course_id]);
$exams = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Content | <?php echo $course['title']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandBlue: '#0056b3',
                        brandGreen: '#28a745',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8FAFC] flex min-h-screen text-sm">

    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-grow p-8">
        <header class="flex justify-between items-center mb-10">
            <div>
                <a href="courses.php" class="text-brandBlue font-bold flex items-center mb-2 hover:underline">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Courses
                </a>
                <h1 class="text-3xl font-bold text-gray-900"><?php echo $course['title']; ?></h1>
                <p class="text-gray-500">Manage lessons, content, and assessments.</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="document.getElementById('examModal').classList.toggle('hidden')" class="bg-white text-brandBlue border border-gray-200 px-6 py-3 rounded-xl font-bold hover:bg-gray-50 transition shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Generate AI Exam
                </button>
                <button onclick="document.getElementById('lessonModal').classList.toggle('hidden')" class="bg-brandBlue text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-brandBlue/20 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Lesson
                </button>
            </div>
        </header>

        <?php if ($message): ?>
            <div class="bg-blue-50 text-brandBlue p-4 rounded-xl mb-8 border border-blue-100 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Lessons List -->
            <div class="lg:col-span-2 space-y-4">
                <h3 class="font-bold text-gray-900 mb-6 flex items-center">
                    Course syllabus
                    <span class="ml-3 bg-gray-100 text-gray-400 px-2 py-0.5 rounded text-[10px] uppercase"><?php echo count($lessons); ?> Lessons</span>
                </h3>
                <?php foreach ($lessons as $index => $l): ?>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between group hover:border-brandBlue transition">
                        <div class="flex items-center">
                            <span class="w-8 h-8 bg-gray-50 text-gray-400 rounded-lg flex items-center justify-center font-bold mr-4 shrink-0 transition group-hover:bg-brandBlue group-hover:text-white">
                                <?php echo $index + 1; ?>
                            </span>
                            <div>
                                <h4 class="font-bold text-gray-900 group-hover:text-brandBlue transition"><?php echo $l['title']; ?></h4>
                                <p class="text-xs text-gray-400 mt-1 uppercase tracking-tighter font-semibold">Lesson Module</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition">
                            <button class="p-2 text-gray-400 hover:text-brandBlue transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                            <button class="p-2 text-gray-400 hover:text-red-500 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($lessons)): ?>
                    <div class="bg-white p-12 rounded-3xl border border-dashed border-gray-200 text-center">
                        <p class="text-gray-400 mb-4 italic">No lessons added yet. Use the AI builder to start.</p>
                        <button onclick="document.getElementById('lessonModal').classList.toggle('hidden')" class="text-brandBlue font-bold hover:underline">Add your first lesson &rarr;</button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Exams Sidebar -->
            <div class="space-y-6">
                <h3 class="font-bold text-gray-900 mb-6 flex items-center">
                    Assessments
                    <span class="ml-3 bg-brandGreen/10 text-brandGreen px-2 py-0.5 rounded text-[10px] uppercase font-bold"><?php echo count($exams); ?> Exams</span>
                </h3>
                <?php foreach ($exams as $e): ?>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-12 h-12 bg-green-50 text-brandGreen rounded-bl-3xl flex items-center justify-center opacity-50 group-hover:opacity-100 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM11 2a1 1 0 100 2h1a1 1 0 100-2h-1zm0 10a1 1 0 100 2h1a1 1 0 100-2h-1zM15 2a1 1 0 100 2h1a1 1 0 100-2h-1zm0 10a1 1 0 100 2h1a1 1 0 100-2h-1z" clip-rule="evenodd"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2"><?php echo $e['title']; ?></h4>
                        <div class="flex items-center space-x-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                            <span>Passing: <?php echo $e['passing_score']; ?>%</span>
                            <span>Questions: 
                                <?php 
                                    $q_count = $pdo->prepare("SELECT COUNT(*) FROM questions WHERE exam_id = ?");
                                    $q_count->execute([$e['id']]);
                                    echo $q_count->fetchColumn(); 
                                ?>
                            </span>
                        </div>
                        <div class="mt-6 flex space-x-2">
                            <button class="flex-grow bg-gray-50 text-gray-600 py-2 rounded-lg font-bold hover:bg-gray-100 transition">View Questions</button>
                            <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($exams)): ?>
                    <div class="bg-gray-50 p-6 rounded-2xl border border-dashed border-gray-200 text-center">
                        <p class="text-gray-400 text-xs italic">No exam created for this course.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Lesson Modal -->
        <div id="lessonModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 leading-none">Add New Lesson</h2>
                        <p class="text-xs text-brandBlue mt-2 font-bold uppercase tracking-widest">Pollinations AI Engine</p>
                    </div>
                    <button onclick="document.getElementById('lessonModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="lessons.php?course_id=<?php echo $course_id; ?>" method="POST" class="p-8 space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Lesson Title</label>
                        <input type="text" name="title" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-brandBlue/20 focus:border-brandBlue outline-none transition" placeholder="e.g. Understanding Cross-Contamination">
                    </div>
                    <div class="flex items-center space-x-3 bg-blue-50/50 p-4 rounded-2xl border border-blue-100">
                        <input type="checkbox" name="auto_gen" id="auto_gen" checked class="w-5 h-5 text-brandBlue border-gray-300 rounded focus:ring-brandBlue">
                        <label for="auto_gen" class="text-sm font-semibold text-brandBlue">Generate content automatically using AI</label>
                    </div>
                    <p class="text-[10px] text-gray-400 leading-relaxed italic">If checked, the system will research and write a full lesson plan including key principles and best practices based on UK healthcare standards.</p>
                    <button type="submit" name="add_lesson" class="w-full bg-brandBlue text-white py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-brandBlue/20">Create Lesson Content</button>
                </form>
            </div>
        </div>

        <!-- Exam Modal -->
        <div id="examModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-green-50/50">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 leading-none">AI Exam Generator</h2>
                        <p class="text-xs text-brandGreen mt-2 font-bold uppercase tracking-widest">Question Bank Creator</p>
                    </div>
                    <button onclick="document.getElementById('examModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="lessons.php?course_id=<?php echo $course_id; ?>" method="POST" class="p-8 space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Assessment Topic</label>
                        <input type="text" name="exam_topic" value="<?php echo $course['title']; ?>" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-brandGreen/20 focus:border-brandGreen outline-none transition">
                    </div>
                    <div class="bg-green-50 p-4 rounded-2xl flex items-start space-x-3 border border-green-100">
                        <svg class="w-5 h-5 text-brandGreen mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <p class="text-[11px] text-green-700 leading-relaxed font-medium">This will generate 5 high-quality, professional multiple-choice questions with correct answers automatically mapped. This ensures credibility and saves hours of manual work.</p>
                    </div>
                    <button type="submit" name="gen_exam" class="w-full bg-brandGreen text-white py-4 rounded-xl font-bold hover:bg-green-600 transition shadow-lg shadow-brandGreen/20 uppercase tracking-widest text-xs">Bootstrap Exam Bank</button>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
