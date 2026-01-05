<?php
require_once '../includes/auth.php';
requireLogin();

$tx_id = $_GET['tx'] ?? null;
$transaction = null;

if ($tx_id) {
    $stmt = $pdo->prepare("SELECT t.*, c.title as course_title 
        FROM transactions t 
        LEFT JOIN courses c ON t.item_id = c.id AND t.item_type = 'certificate'
        WHERE t.id = ? AND t.user_id = ?");
    $stmt->execute([$tx_id, $_SESSION['user_id']]);
    $transaction = $stmt->fetch();
}

// In case webhook hasn't fired yet, we show a 'processing' message if still pending
$is_pending = $transaction && $transaction['status'] === 'pending';

$pageTitle = "Success";
include '../includes/header_student.php';
?>

<div class="max-w-xl mx-auto py-20 text-center">
    <!-- Success Decoration -->
    <div class="relative w-40 h-40 mx-auto mb-10">
        <div class="absolute inset-0 bg-brandGreen/10 rounded-[3rem] animate-ping opacity-20"></div>
        <div class="relative h-full w-full bg-brandGreen text-white rounded-[2.5rem] flex items-center justify-center shadow-2xl shadow-brandGreen/20">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
    </div>

    <h1 class="text-4xl font-black tracking-tighter mb-4 leading-none uppercase">Payment Confirmed</h1>
    <p class="text-muted-foreground font-medium mb-12">Congratulations! Your professional credentials for <span class="text-foreground font-bold"><?php echo $transaction['course_title'] ?? 'your course'; ?></span> are now being generated.</p>

    <div class="bg-card border rounded-[2rem] p-8 mb-12 text-left shadow-sm">
        <h3 class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mb-6 border-b pb-4">Transaction Details</h3>
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-muted-foreground">Reference ID</span>
                <span class="text-xs font-black uppercase tracking-tighter">#TX-<?php echo str_pad($tx_id, 6, '0', STR_PAD_LEFT); ?></span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-muted-foreground">Amount Paid</span>
                <span class="text-xs font-black">£<?php echo number_format($transaction['amount'] ?? 0, 2); ?></span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-muted-foreground">Status</span>
                <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-brandGreen/10 text-brandGreen text-[10px] font-black uppercase tracking-widest">
                    <div class="h-1.5 w-1.5 rounded-full bg-brandGreen"></div>
                    Completed
                </span>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="certificates.php" class="h-14 px-10 bg-primary text-primary-foreground rounded-2xl font-black flex items-center justify-center shadow-lg hover:shadow-primary/20 hover:-translate-y-0.5 transition-all uppercase tracking-widest">View Credentials</a>
        <a href="dashboard.php" class="h-14 px-10 bg-muted text-foreground rounded-2xl font-black flex items-center justify-center hover:bg-muted/80 transition-all uppercase tracking-widest">Return to Base</a>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
