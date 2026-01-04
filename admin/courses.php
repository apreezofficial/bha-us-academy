<?php
require_once '../includes/auth.php';
require_once '../includes/ai_service.php';
requireAdmin();

$ai = new AIService();
$message = '';

// Handle Course Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
    $title = $_POST['title'] ?? '';
    $price = $_POST['price'] ?? 10.00;
    $cert_price = $_POST['cert_price'] ?? 15.00;
    
    // Generate AI Description
    $prompt = "Write a short, professional, and convincing marketing description for a healthcare training course titled '$title'. The target audience is UK healthcare professionals. Keep it under 100 words.";
    $description = $ai->generate($prompt) ?: "Professional healthcare module: $title.";

    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

    try {
        $stmt = $pdo->prepare("INSERT INTO courses (title, slug, description, price, certificate_price) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $description, $price, $cert_price]);
        $message = "Course '$title' created successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Fetch all courses
$courses = $pdo->query("SELECT * FROM courses ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses | BHA Academy Admin</title>
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
                <h1 class="text-3xl font-bold text-gray-900">Manage Courses</h1>
                <p class="text-gray-500">Create and curate your professional training catalog.</p>
            </div>
            <button onclick="document.getElementById('addModal').classList.toggle('hidden')" class="bg-brandBlue text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-brandBlue/20 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                AI Course Builder
            </button>
        </header>

        <?php if ($message): ?>
            <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-8 border border-green-100 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Courses List -->
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-400 font-medium">
                        <tr>
                            <th class="px-6 py-4 uppercase tracking-wider text-[10px]">Course Details</th>
                            <th class="px-6 py-4 uppercase tracking-wider text-[10px]">Pricing</th>
                            <th class="px-6 py-4 uppercase tracking-wider text-[10px]">Lessons</th>
                            <th class="px-6 py-4 uppercase tracking-wider text-[10px]">Students</th>
                            <th class="px-6 py-4 uppercase tracking-wider text-[10px] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php foreach ($courses as $c): ?>
                            <tr class="hover:bg-gray-50 transition group">
                                <td class="px-6 py-6">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-blue-50 text-brandBlue rounded-xl flex items-center justify-center font-bold mr-4 shrink-0 transition group-hover:bg-brandBlue group-hover:text-white">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 group-hover:text-brandBlue transition"><?php echo $c['title']; ?></p>
                                            <p class="text-xs text-gray-400 mt-1 truncate max-w-xs"><?php echo $c['description']; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-900">£<?php echo number_format($c['price'], 2); ?></span>
                                        <span class="text-[10px] text-gray-400">Cert: £<?php echo number_format($c['certificate_price'], 2); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <span class="bg-blue-50 text-brandBlue px-2.5 py-1 rounded-full text-[10px] font-bold uppercase">
                                        <?php 
                                            $lesson_count = $pdo->prepare("SELECT COUNT(*) FROM lessons WHERE course_id = ?");
                                            $lesson_count->execute([$c['id']]);
                                            echo $lesson_count->fetchColumn(); 
                                        ?> Lessons
                                    </span>
                                </td>
                                <td class="px-6 py-6 font-medium text-gray-600">
                                    <?php 
                                        $stud_count = $pdo->prepare("SELECT COUNT(*) FROM enrollments WHERE course_id = ?");
                                        $stud_count->execute([$c['id']]);
                                        echo number_format($stud_count->fetchColumn()); 
                                    ?>
                                </td>
                                <td class="px-6 py-6 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <a href="lessons.php?course_id=<?php echo $c['id']; ?>" class="p-2 text-gray-400 hover:text-brandBlue transition" title="Manage Content">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <button class="p-2 text-gray-400 hover:text-red-500 transition" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($courses)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <p class="text-gray-400 font-medium">No courses found. Start building with AI!</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Modal -->
        <div id="addModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 leading-none">AI Course Builder</h2>
                        <p class="text-xs text-gray-400 mt-2 tracking-wide uppercase font-bold">Smart Module Creation</p>
                    </div>
                    <button onclick="document.getElementById('addModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="courses.php" method="POST" class="p-8 space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Module Title</label>
                        <input type="text" name="title" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-brandBlue/20 focus:border-brandBlue outline-none transition" placeholder="e.g. Infection Prevention and Control">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Course Price (£)</label>
                            <input type="number" name="price" step="0.01" required value="10.00" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-brandBlue/20 focus:border-brandBlue outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cert Price (£)</label>
                            <input type="number" name="cert_price" step="0.01" required value="15.00" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-brandBlue/20 focus:border-brandBlue outline-none transition">
                        </div>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-2xl flex items-start space-x-3">
                        <div class="bg-brandBlue text-white p-1 rounded-lg">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.047a1 1 0 01.8 1.051V5a1 1 0 01-1 1h-4.243l3.536 3.536a1 1 0 01-1.414 1.414l-4.243-4.243a1 1 0 011.414-1.414L7.757 6.757 11.3 1.047z" clip-rule="evenodd"></path></svg>
                        </div>
                        <p class="text-[11px] text-brandBlue leading-relaxed font-medium">Pollinations AI will automatically generate a professional course description and syllabus structure based on your title.</p>
                    </div>
                    <button type="submit" name="add_course" class="w-full bg-brandBlue text-white py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-brandBlue/20">Initialize Module</button>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
