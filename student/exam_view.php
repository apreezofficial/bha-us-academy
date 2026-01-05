<?php
require_once '../includes/auth.php';
requireLogin();

$exam_id = $_GET['id'] ?? null;
if (!$exam_id) {
    header("Location: exams.php");
    exit();
}

// Fetch Exam & Course
$stmt = $pdo->prepare("SELECT e.*, c.title as course_title FROM exams e JOIN courses c ON e.course_id = c.id WHERE e.id = ?");
$stmt->execute([$exam_id]);
$exam = $stmt->fetch();

if (!$exam) {
    header("Location: exams.php");
    exit();
}

// Check if already passed
$stmt = $pdo->prepare("SELECT * FROM exam_results WHERE exam_id = ? AND user_id = ? AND status = 'passed'");
$stmt->execute([$exam_id, $_SESSION['user_id']]);
$passed = $stmt->fetch();

if ($passed) {
    header("Location: certificates.php");
    exit();
}

// Fetch Questions
$stmt = $pdo->prepare("SELECT * FROM questions WHERE exam_id = ? ORDER BY id ASC");
$stmt->execute([$exam_id]);
$questions = $stmt->fetchAll();

// Handle Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_exam'])) {
    $answers = $_POST['answers'] ?? [];
    $score = 0;
    $total_questions = count($questions);
    
    foreach ($questions as $q) {
        if (isset($answers[$q['id']]) && $answers[$q['id']] == $q['correct_option']) {
            $score++;
        }
    }
    
    $percentage = ($total_questions > 0) ? ($score / $total_questions) * 100 : 0;
    $status = ($percentage >= $exam['passing_score']) ? 'passed' : 'failed';
    
    // Save Result
    $stmt = $pdo->prepare("INSERT INTO exam_results (exam_id, user_id, score, status, created_at) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)");
    $stmt->execute([$exam_id, $_SESSION['user_id'], $percentage, $status]);
    
    if ($status === 'passed') {
        // Update Enrollment
        $stmt = $pdo->prepare("UPDATE enrollments SET status = 'completed', completed_at = CURRENT_TIMESTAMP WHERE user_id = ? AND course_id = ?");
        $stmt->execute([$_SESSION['user_id'], $exam['course_id']]);
        header("Location: payment_success.php?type=certificate&course_id=" . $exam['course_id']);
    } else {
        header("Location: exams.php?result=failed&score=" . round($percentage));
    }
    exit();
}

$pageTitle = "Assessment Console";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-10 max-w-4xl mx-auto">
    <!-- Assessment Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 text-foreground">
        <div class="max-w-xl">
            <h1 class="text-4xl font-black tracking-tighter mb-4 leading-none uppercase italic">Clinical Validation</h1>
            <p class="text-muted-foreground font-medium underline decoration-brandBlue/30 underline-offset-4"><?php echo $exam['course_title']; ?>: Final Proficiency Assessment</p>
        </div>
        
        <div class="flex items-center gap-3 bg-foreground text-background px-6 py-2.5 rounded-2xl shadow-2xl shadow-brandBlue/20">
            <span class="text-[10px] font-black uppercase tracking-widest opacity-50">Target</span>
            <span class="text-xl font-black italic tracking-tighter leading-none"><?php echo $exam['passing_score']; ?>%</span>
        </div>
    </div>

    <!-- Instructions -->
    <div class="bg-card border-2 border-dashed rounded-[2.5rem] p-10 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-brandBlue/5 rounded-full -mr-16 -mt-16 blur-3xl"></div>
        <div class="flex gap-8 items-start relative">
            <div class="h-16 w-16 rounded-[1.5rem] bg-brandBlue/10 text-brandBlue flex items-center justify-center shrink-0 border border-brandBlue/20">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-black uppercase tracking-tight mb-2 italic">Standardized Guidelines</h3>
                <ul class="text-[11px] text-muted-foreground font-bold space-y-2 uppercase tracking-tight opacity-70">
                    <li class="flex items-center gap-2"><div class="h-1 w-1 bg-brandBlue rounded-full"></div> Answer all clinical scenarios truthfully.</li>
                    <li class="flex items-center gap-2"><div class="h-1 w-1 bg-brandBlue rounded-full"></div> Submission is permanent and recorded in registry.</li>
                    <li class="flex items-center gap-2"><div class="h-1 w-1 bg-brandBlue rounded-full"></div> Requires <?php echo $exam['passing_score']; ?>% accuracy for certification.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Exam Form -->
    <form method="POST" class="space-y-10 mb-20 scroll-smooth">
        <?php foreach ($questions as $index => $q): ?>
            <div class="bg-card border-2 border-muted hover:border-brandBlue/30 rounded-[3rem] p-12 transition-all duration-500 group relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 text-4xl font-black text-muted/20 italic select-none"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></div>
                
                <h4 class="text-xl font-black tracking-tight leading-relaxed mb-10 max-w-2xl text-foreground">
                    <?php echo $q['question_text']; ?>
                </h4>

                <div class="grid grid-cols-1 gap-4">
                    <?php for ($i = 1; $i <= 4; $i++): $opt = 'option_' . $i; ?>
                        <label class="relative flex items-center p-5 rounded-2xl border-2 border-muted bg-muted/5 cursor-pointer hover:border-brandBlue/50 hover:bg-brandBlue/5 transition-all group/opt">
                            <input type="radio" name="answers[<?php echo $q['id']; ?>]" value="<?php echo $i; ?>" required class="hidden peer">
                            <div class="h-6 w-6 rounded-lg border-2 border-muted flex items-center justify-center mr-6 shrink-0 peer-checked:bg-brandBlue peer-checked:border-brandBlue bg-background transition-all">
                                <div class="h-2 w-2 rounded-sm bg-white hidden peer-checked:block"></div>
                            </div>
                            <span class="text-sm font-bold text-muted-foreground peer-checked:text-foreground transition-colors"><?php echo $q[$opt]; ?></span>
                            <div class="absolute inset-0 border-2 border-transparent peer-checked:border-brandBlue rounded-2xl pointer-events-none"></div>
                        </label>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="pt-10 flex justify-center">
            <button type="submit" name="submit_exam" class="h-20 px-20 bg-brandBlue text-white rounded-[2.5rem] font-black text-xl uppercase tracking-widest shadow-2xl shadow-brandBlue/20 hover:shadow-brandBlue/40 hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-4">
                Affirm Submission
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><path d="m9 18 6-6-6-6"></path></svg>
            </button>
        </div>
    </form>
</div>

<?php include '../includes/footer_student.php'; ?>
