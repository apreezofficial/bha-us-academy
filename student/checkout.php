<?php
require_once '../includes/auth.php';
requireLogin();

// This is a placeholder for actual Stripe integration
// In a real scenario, you'd use the Stripe PHP library:
// \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

$user_id = $_SESSION['user_id'];
$type = $_GET['type'] ?? 'certificate';
$course_id = $_GET['course_id'] ?? null;
$amount = $_GET['amount'] ?? 0;

if (!$course_id || $amount <= 0) {
    header("Location: dashboard.php");
    exit;
}

// 1. Create a pending transaction
$stmt = $pdo->prepare("INSERT INTO transactions (user_id, item_type, item_id, amount, payment_method, status) VALUES (?, ?, ?, ?, 'stripe', 'pending')");
$stmt->execute([$user_id, $type, $course_id, $amount]);
$transaction_id = $pdo->lastInsertId();

// 2. Redirect to a simulated Stripe page
// In production, this would be \Stripe\Checkout\Session::create(...)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure Payment | BHA Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center p-10">
    <div class="max-w-xl w-full bg-white p-12 rounded-[3rem] shadow-2xl border border-gray-100 text-center">
        <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-10">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
        </div>
        <h1 class="text-4xl font-black text-gray-900 mb-4">Secure Checkout</h1>
        <p class="text-gray-500 font-medium mb-10">Redirecting you to Stripe to complete your payment of <span class="text-gray-900 font-bold">£<?php echo number_format($amount, 2); ?></span>.</p>
        
        <!-- Automated Success Simulation for Demo -->
        <div class="space-y-6">
            <div class="animate-pulse bg-gray-100 h-2 rounded-full w-48 mx-auto"></div>
            <a href="payment_success.php?tx=<?php echo $transaction_id; ?>" class="inline-block bg-[#635BFF] text-white px-10 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:shadow-xl transition shadow-lg shadow-indigo-200">
                Continue to Stripe Secure Pay
            </a>
        </div>
        
        <p class="text-[10px] uppercase font-black tracking-widest text-gray-400 mt-12">Protected by Industry Standard 256-bit SSL Encryption</p>
    </div>
</body>
</html>
