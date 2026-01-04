<?php
require_once '../includes/auth.php';
require_once '../includes/ai_service.php';
requireLogin();

$user_id = $_SESSION['user_id'];

// Fetch enrollment stats
$stmt = $pdo->prepare("SELECT COUNT(*) FROM enrollments WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_enrolled = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM enrollments WHERE user_id = ? AND status = 'completed'");
$stmt->execute([$user_id]);
$total_completed = $stmt->fetchColumn();

// Fetch average score
$stmt = $pdo->prepare("SELECT AVG(score) FROM exam_results WHERE user_id = ?");
$stmt->execute([$user_id]);
$avg_score = round($stmt->fetchColumn() ?: 0, 1);

// Fetch in-progress courses
$stmt = $pdo->prepare("SELECT c.*, e.status, e.started_at 
    FROM enrollments e 
    JOIN courses c ON e.course_id = c.id 
    WHERE e.user_id = ? AND e.status = 'active'
    ORDER BY e.started_at DESC LIMIT 3");
$stmt->execute([$user_id]);
$active_courses = $stmt->fetchAll();

// Fetch referral info
$stmt = $pdo->prepare("SELECT referral_code, balance FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user_data = $stmt->fetch();

// Fetch recent activity
$stmt = $pdo->prepare("
    (SELECT 'enrollment' as type, c.title as item, e.started_at as date 
     FROM enrollments e JOIN courses c ON e.course_id = c.id WHERE e.user_id = ?)
    UNION
    (SELECT 'exam' as type, e.title as item, er.created_at as date 
     FROM exam_results er JOIN exams e ON er.exam_id = e.id WHERE er.user_id = ?)
    ORDER BY date DESC LIMIT 5
");
$stmt->execute([$user_id, $user_id]);
$activities = $stmt->fetchAll();

$study_tip = AIService::generateText("Give a short, professional study tip for a healthcare student today.");

$pageTitle = "Overview";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-8">
    <!-- Welcome Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight mb-1">Welcome back, <?php echo explode(' ', $_SESSION['user_name'])[0]; ?>!</h1>
            <p class="text-muted-foreground">You are currently making great progress in your clinical training.</p>
        </div>
        <div class="flex items-center gap-2">
            <div class="bg-card border rounded-lg px-4 py-2 flex flex-col items-end">
                <span class="text-[10px] font-bold uppercase tracking-wider text-muted-foreground">Account Balance</span>
                <span class="text-lg font-bold text-brandGreen">£<?php echo number_format($user_data['balance'], 2); ?></span>
            </div>
            <button onclick="navigator.clipboard.writeText('<?php echo $user_data['referral_code']; ?>')" class="h-12 px-6 bg-primary text-primary-foreground rounded-lg font-medium text-sm hover:opacity-90 transition-opacity">
                Share Referral
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-card border rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-muted-foreground">Course Completion</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground leading-none"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div class="text-2xl font-bold"><?php echo $total_completed; ?> / <?php echo $total_enrolled; ?></div>
            <p class="text-[10px] text-muted-foreground mt-1 uppercase tracking-wider">Modules Finished</p>
        </div>
        <div class="bg-card border rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-muted-foreground">Academic Score</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
            </div>
            <div class="text-2xl font-bold"><?php echo $avg_score; ?>%</div>
            <p class="text-[10px] text-muted-foreground mt-1 uppercase tracking-wider">Average Performance</p>
        </div>
        <div class="bg-card border rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-muted-foreground">Active Modules</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M8 7h6"></path><path d="M8 11h8"></path></svg>
            </div>
            <div class="text-2xl font-bold"><?php echo count($active_courses); ?></div>
            <p class="text-[10px] text-muted-foreground mt-1 uppercase tracking-wider">Currently Studying</p>
        </div>
        <div class="bg-card border rounded-xl p-6 shadow-sm border-brandBlue/20">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-brandBlue">Clinical Tip</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brandBlue"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"></path><path d="M9 18h6"></path><path d="M10 22h4"></path></svg>
            </div>
            <p class="text-xs font-medium italic text-muted-foreground leading-relaxed">"<?php echo $study_tip; ?>"</p>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid gap-8 lg:grid-cols-3">
        <!-- Dashboard Content -->
        <div class="lg:col-span-2 space-y-8">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold tracking-tight">Active Learning Path</h2>
                <a href="courses.php" class="text-xs font-bold text-brandBlue uppercase tracking-widest hover:underline">Full Curriculum</a>
            </div>
            
            <div class="grid gap-4">
                <?php foreach ($active_courses as $course): ?>
                <div class="bg-card border rounded-xl p-4 flex gap-4 hover:border-brandBlue transition-colors group cursor-pointer" onclick="window.location='course_view.php?course_id=<?php echo $course['id']; ?>'">
                    <div class="h-24 w-24 rounded-lg bg-muted overflow-hidden shrink-0">
                        <img src="<?php echo img_url($course['image']); ?>" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="flex-1 flex flex-col justify-center">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded-full bg-blue-500/10 text-blue-500 text-[10px] font-bold uppercase">CPD Accredited</span>
                            <span class="text-[10px] text-muted-foreground">Started <?php echo date('M d', strtotime($course['started_at'])); ?></span>
                        </div>
                        <h4 class="font-bold text-lg mb-2 leading-none"><?php echo $course['title']; ?></h4>
                        <div class="w-full bg-muted h-1.5 rounded-full overflow-hidden">
                            <div class="bg-brandBlue h-full" style="width: 45%"></div>
                        </div>
                    </div>
                    <div class="flex items-center px-2">
                        <div class="p-2 rounded-full bg-muted group-hover:bg-brandBlue group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"></path></svg>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <?php if (empty($active_courses)): ?>
                <div class="bg-card border border-dashed rounded-xl p-12 text-center">
                    <p class="text-muted-foreground mb-4">You have no active courses at the moment.</p>
                    <a href="courses.php" class="inline-flex h-10 px-6 items-center bg-primary text-primary-foreground rounded-lg font-medium text-sm">Start Training</a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar Activity -->
        <div class="space-y-8">
            <h2 class="text-xl font-bold tracking-tight">Recent Activity</h2>
            <div class="bg-card border rounded-xl p-6 shadow-sm space-y-6 relative">
                <div class="absolute left-[31px] top-8 bottom-8 w-px bg-border"></div>
                
                <?php foreach ($activities as $act): ?>
                <div class="flex gap-4 relative">
                    <div class="h-8 w-8 rounded-full bg-background border flex items-center justify-center shrink-0 z-10">
                        <?php if ($act['type'] == 'enrollment'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brandBlue"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path></svg>
                        <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brandGreen"><path d="m9 12 2 2 4-4"></path><circle cx="12" cy="12" r="10"></circle></svg>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1">
                        <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider leading-none mb-1"><?php echo date('M d, H:i', strtotime($act['date'])); ?></p>
                        <h5 class="text-sm font-semibold leading-tight"><?php echo $act['item']; ?></h5>
                        <p class="text-[11px] text-muted-foreground"><?php echo $act['type'] == 'enrollment' ? 'New Enrollment' : 'Exam Completed'; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="bg-primary/5 rounded-xl border border-primary/10 p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-center mb-4">Academy Status</h3>
                <div class="flex justify-center gap-1.5 mb-4">
                    <div class="w-3 h-3 rounded-full bg-brandBlue"></div>
                    <div class="w-3 h-3 rounded-full bg-brandBlue"></div>
                    <div class="w-3 h-3 rounded-full bg-brandBlue"></div>
                    <div class="w-3 h-3 rounded-full bg-muted"></div>
                    <div class="w-3 h-3 rounded-full bg-muted"></div>
                </div>
                <p class="text-xs text-center text-muted-foreground font-medium">Compliance: 3/5 Core Modules</p>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
