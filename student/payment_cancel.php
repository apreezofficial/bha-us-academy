<?php
require_once '../includes/auth.php';
requireLogin();

$tx_id = $_GET['tx'] ?? null;
$pageTitle = "Payment Interrupted";
include '../includes/header_student.php';
?>

<div class="max-w-xl mx-auto py-20 text-center">
    <!-- Cancel Decoration -->
    <div class="w-40 h-40 mx-auto mb-10 bg-destructive/10 text-destructive rounded-[2.5rem] flex items-center justify-center p-8">
        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
    </div>

    <h1 class="text-4xl font-black tracking-tighter mb-4 leading-none uppercase">Payment Canceled</h1>
    <p class="text-muted-foreground font-medium mb-12">The transaction was not completed. You haven't been charged, and you can resume the process whenever you're ready.</p>

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="certificate_pay.php" class="h-14 px-10 bg-primary text-primary-foreground rounded-2xl font-black flex items-center justify-center shadow-lg hover:shadow-primary/20 hover:-translate-y-0.5 transition-all uppercase tracking-widest">Retry Checkout</a>
        <a href="dashboard.php" class="h-14 px-10 bg-muted text-foreground rounded-2xl font-black flex items-center justify-center hover:bg-muted/80 transition-all uppercase tracking-widest">Back to Console</a>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
