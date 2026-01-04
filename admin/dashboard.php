<?php
require_once '../includes/auth.php';
requireAdmin();

// Fetch some stats
$stats = [
    'users' => $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn(),
    'courses' => $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn(),
    'enrollments' => $pdo->query("SELECT COUNT(*) FROM enrollments")->fetchColumn(),
    'revenue' => $pdo->query("SELECT SUM(amount) FROM transactions WHERE status = 'completed'")->fetchColumn() ?: 0,
];

// Recent enrollments
$recent_enrollments = $pdo->query("SELECT e.*, u.name as user_name, c.title as course_title 
    FROM enrollments e 
    JOIN users u ON e.user_id = u.id 
    JOIN courses c ON e.course_id = c.id 
    ORDER BY e.started_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | BHA Academy</title>
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
<body class="bg-[#F8FAFC] flex min-h-screen">

    <?php include '../includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-grow p-8">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                <p class="text-gray-500">Welcome back, here's what's happening today.</p>
            </div>
            <div class="flex items-center space-x-4">
                <button class="bg-white p-2.5 rounded-xl border border-gray-200 text-gray-500 hover:bg-gray-50 transition relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                <img src="https://ui-avatars.com/api/?name=Admin&background=0056b3&color=fff" class="w-11 h-11 rounded-xl shadow-sm">
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                <div class="w-12 h-12 bg-blue-50 text-brandBlue rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Students</p>
                <h3 class="text-2xl font-bold text-gray-900"><?php echo number_format($stats['users']); ?></h3>
            </div>
            
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                <div class="w-12 h-12 bg-green-50 text-brandGreen rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <p class="text-gray-500 text-sm font-medium mb-1">Active Courses</p>
                <h3 class="text-2xl font-bold text-gray-900"><?php echo number_format($stats['courses']); ?></h3>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Enrollments</p>
                <h3 class="text-2xl font-bold text-gray-900"><?php echo number_format($stats['enrollments']); ?></h3>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Revenue</p>
                <h3 class="text-2xl font-bold text-gray-900">£<?php echo number_format($stats['revenue'], 2); ?></h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Enrollments -->
            <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden text-sm">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h4 class="font-bold text-gray-900">Recent Enrollments</h4>
                    <a href="#" class="text-brandBlue font-bold text-xs hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-400 font-medium">
                            <tr>
                                <th class="px-6 py-4 uppercase tracking-wider text-[10px]">Student</th>
                                <th class="px-6 py-4 uppercase tracking-wider text-[10px]">Course</th>
                                <th class="px-6 py-4 uppercase tracking-wider text-[10px]">Date</th>
                                <th class="px-6 py-4 uppercase tracking-wider text-[10px]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <?php foreach ($recent_enrollments as $enroll): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 text-brandBlue rounded-lg flex items-center justify-center font-bold mr-3 text-xs uppercase">
                                                <?php echo substr($enroll['user_name'], 0, 1); ?>
                                            </div>
                                            <span class="font-semibold"><?php echo $enroll['user_name']; ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600"><?php echo $enroll['course_title']; ?></td>
                                    <td class="px-6 py-4 text-gray-400"><?php echo date('d M, Y', strtotime($enroll['started_at'])); ?></td>
                                    <td class="px-6 py-4 text-gray-400 text-right">
                                        <span class="bg-blue-50 text-brandBlue px-2.5 py-1 rounded-full text-[10px] font-bold uppercase">Active</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($recent_enrollments)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400">No enrollments yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-6">
                <div class="bg-brandBlue text-white p-8 rounded-3xl shadow-xl shadow-brandBlue/20 relative overflow-hidden">
                    <div class="relative z-10">
                        <h4 class="text-xl font-bold mb-2 text-white">Course Builder</h4>
                        <p class="text-blue-100 text-sm mb-6 leading-relaxed">Create new modules using our AI content generator.</p>
                        <a href="courses.php?action=add" class="inline-block bg-white text-brandBlue px-6 py-3 rounded-xl font-bold text-sm hover:bg-blue-50 transition">New Course</a>
                    </div>
                    <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <h4 class="font-bold text-gray-900 mb-4">Platform Stats</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-sm">Exam Pass Rate</span>
                            <span class="font-bold text-brandGreen">94%</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full">
                            <div class="bg-brandGreen h-2 rounded-full" style="width: 94%"></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-sm">Certificate Issuance</span>
                            <span class="font-bold text-brandBlue">82%</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full">
                            <div class="bg-brandBlue h-2 rounded-full" style="width: 82%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
