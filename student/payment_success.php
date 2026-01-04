<?php
require_once '../includes/auth.php';
requireLogin();

$transaction_id = $_GET['tx'] ?? null;

if (!$transaction_id) {
    header("Location: dashboard.php");
    exit;
}

// 1. Update Transaction
$stmt = $pdo->prepare("UPDATE transactions SET status = 'completed' WHERE id = ? AND user_id = ?");
$stmt->execute([$transaction_id, $_SESSION['user_id']]);

// 2. Fetch Transaction Details
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE id = ?");
$stmt->execute([$transaction_id]);
$tx = $stmt->fetch();

if ($tx['item_type'] === 'certificate') {
    // Issue Certificate
    $cert_number = 'BHA-' . strtoupper(uniqid());
    $stmt = $pdo->prepare("INSERT INTO certificates (user_id, course_id, certificate_number, type, status, issued_at) VALUES (?, ?, ?, 'soft', 'issued', NOW())");
    $stmt->execute([$_SESSION['user_id'], $tx['item_id'], $cert_number]);

    // Award Referral Credit (If applicable)
    $stmt = $pdo->prepare("SELECT referred_by FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $referred_by = $stmt->fetchColumn();
    if ($referred_by) {
        $stmt = $pdo->prepare("UPDATE users SET balance = balance + 5 WHERE id = ?");
        $stmt->execute([$referred_by]);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful | BHA Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-brandBlue h-screen flex items-center justify-center p-10 text-white font-inter">
    <div class="max-w-xl w-full text-center">
        <div class="w-32 h-32 bg-white text-brandGreen rounded-[3rem] flex items-center justify-center mx-auto mb-12 shadow-3xl animate-bounce">
            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
        </div>
        <h1 class="text-6xl font-black mb-6 tracking-tighter">Transaction Complete.</h1>
        <p class="text-2xl text-blue-100 font-medium mb-12 opacity-80">Your payment has been processed successfully. Your certificate is now available in your dashboard.</p>
        <a href="certificates.php" class="inline-block bg-white text-brandBlue px-14 py-6 rounded-[2rem] font-[900] uppercase tracking-widest hover:scale-105 transition shadow-2xl">View My Certificates</a>
    </div>
</body>
</html>
