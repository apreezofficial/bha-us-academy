<?php
require_once '../includes/auth.php';
requireLogin();

$exam_id = $_GET['id'] ?? null;
if (!$exam_id) {
    header("Location: dashboard.php");
    exit();
}

// Fetch Exam
$stmt = $pdo->prepare("SELECT e.*, c.title as course_title, c.id as course_id 
    FROM exams e 
    JOIN courses c ON e.course_id = c.id 
    WHERE e.id = ?");
$stmt->execute([$exam_id]);
$exam = $stmt->fetch();

if (!$exam) {
    header("Location: dashboard.php");
    exit();
}

// Fetch Questions
$stmt = $pdo->prepare("SELECT * FROM questions WHERE exam_id = ?");
$stmt->execute([$exam_id]);
$questions = $stmt->fetchAll();

$score = null;
$status = null;

// Handle submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_exam'])) {
    $correct_count = 0;
    $total_count = count($questions);

    foreach ($questions as $q) {
        $user_ans = $_POST['q_' . $q['id']] ?? '';
        if ($user_ans === $q['correct_answer']) {
            $correct_count++;
        }
    }

    $score = ($correct_count / $total_count) * 100;
    $status = $score >= $exam['passing_score'] ? 'pass' : 'fail';

    // Save result
    $stmt = $pdo->prepare("INSERT INTO exam_results (user_id, exam_id, score, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $exam_id, $score, $status]);

    if ($status === 'pass') {
        // Mark course as completed in enrollment
        $stmt = $pdo->prepare("UPDATE enrollments SET status = 'completed', finished_at = CURRENT_TIMESTAMP WHERE user_id = ? AND course_id = ?");
        $stmt->execute([$_SESSION['user_id'], $exam['course_id']]);
    }
}

$pageTitle = "Assessment";
include '../includes/header_student.php';
?>

<div class="max-w-4xl mx-auto flex flex-col gap-8">
    <header>
        <h1 class="text-3xl font-bold tracking-tight mb-1"><?php echo $exam['title']; ?></h1>
        <p class="text-muted-foreground italic"><?php echo $exam['course_title']; ?> Professional Qualification</p>
        <div class="mt-6 flex flex-wrap gap-4">
            <div class="bg-card border px-4 py-2 rounded-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span class="text-[10px] font-bold uppercase tracking-widest leading-none">NO TIME LIMIT</span>
            </div>
            <div class="bg-card border px-4 py-2 rounded-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brandGreen"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span class="text-[10px] font-bold uppercase tracking-widest leading-none">PASSING SCORE: <?php echo $exam['passing_score']; ?>%</span>
            </div>
        </div>
    </header>

    <?php if ($score === null): ?>
        <form action="exam_view.php?id=<?php echo $exam_id; ?>" method="POST" class="flex flex-col gap-6">
            <?php foreach ($questions as $i => $q): ?>
                <div class="bg-card border rounded-xl p-8 relative group hover:border-brandBlue transition-colors">
                    <div class="flex gap-4 items-start mb-8">
                        <span class="h-8 w-8 rounded-lg bg-primary/5 text-brandBlue flex items-center justify-center shrink-0 text-xs font-bold"><?php echo $i + 1; ?></span>
                        <p class="text-lg font-bold leading-tight"><?php echo $q['question_text']; ?></p>
                    </div>
                    
                    <div class="grid gap-3">
                        <?php 
                            $options = json_decode($q['options'], true);
                            foreach ($options as $key => $val): 
                        ?>
                            <label class="flex items-center gap-4 p-4 rounded-lg bg-muted/30 border border-transparent hover:border-brandBlue cursor-pointer transition-all group/opt">
                                <input type="radio" name="q_<?php echo $q['id']; ?>" value="<?php echo $key; ?>" required class="h-4 w-4 text-brandBlue border-muted-foreground focus:ring-brandBlue bg-background">
                                <span class="text-sm font-medium leading-none"><?php echo $key; ?>: <?php echo $val; ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="pt-8">
                <button type="submit" name="submit_exam" class="w-full h-14 bg-primary text-primary-foreground rounded-xl font-bold text-lg hover:opacity-90 shadow-lg shadow-black/10 transition-all">Submit Professional Assessment</button>
            </div>
        </form>
    <?php else: ?>
        <div class="bg-card border rounded-[2rem] p-12 text-center shadow-sm relative overflow-hidden">
            <?php if ($status === 'pass'): ?>
                <div class="w-20 h-20 bg-brandGreen/10 text-brandGreen rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <h2 class="text-4xl font-black mb-4">Congratulations!</h2>
                <p class="text-muted-foreground mb-12 text-lg">You passed the assessment with a score of <span class="text-brandGreen font-bold"><?php echo round($score, 1); ?>%</span>.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="certificate_pay.php?id=<?php echo $exam['course_id']; ?>" class="h-12 px-10 bg-brandGreen text-white rounded-lg font-bold flex items-center justify-center hover:opacity-90 transition-opacity">Claim Certificate</a>
                    <a href="dashboard.php" class="h-12 px-10 bg-muted text-foreground rounded-lg font-bold flex items-center justify-center hover:bg-muted/80 transition-colors">Return to Console</a>
                </div>
            <?php else: ?>
                <div class="w-20 h-20 bg-destructive/10 text-destructive rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                </div>
                <h2 class="text-4xl font-black mb-4 uppercase italic">Assessment Failed</h2>
                <p class="text-muted-foreground mb-12 text-lg">You scored <span class="text-destructive font-bold"><?php echo round($score, 1); ?>%</span>. You need <?php echo $exam['passing_score']; ?>% to pass.</p>
                <a href="exam_view.php?id=<?php echo $exam_id; ?>" class="inline-flex h-12 px-12 bg-primary text-primary-foreground rounded-lg font-bold items-center justify-center hover:opacity-90 transition-opacity">Retry Assessment</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer_student.php'; ?>
