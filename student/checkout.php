<?php
require_once '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$type = $_GET['type'] ?? 'certificate';
$course_id = $_GET['course_id'] ?? null;
$amount = $_GET['amount'] ?? 0;

if (!$course_id || $amount <= 0) {
    header("Location: dashboard.php");
    exit;
}

// Fetch Course Data for Stripe
$stmt = $pdo->prepare("SELECT title FROM courses WHERE id = ?");
$stmt->execute([$course_id]);
$course_title = $stmt->fetchColumn() ?: 'Professional Certification';

// 1. Create transaction record
$initial_status = ($amount <= 0) ? 'completed' : 'pending';
$stmt = $pdo->prepare("INSERT INTO transactions (user_id, item_type, item_id, amount, payment_method, status) VALUES (?, ?, ?, ?, 'system', ?)");
$stmt->execute([$user_id, $type, $course_id, $amount, $initial_status]);
$transaction_id = $pdo->lastInsertId();

// 2. Handle Free Access Immediately
if ($amount <= 0) {
    if ($type === 'certificate') {
        // Issue Certificate
        $cert_num = "BHA-" . strtoupper(bin2hex(random_bytes(4)));
        $stmt = $pdo->prepare("INSERT INTO certificates (user_id, course_id, certificate_number, issued_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)");
        $stmt->execute([$user_id, $course_id, $cert_num]);
    }
    header("Location: payment_success.php?tx=" . $transaction_id);
    exit;
}

// 3. Create Stripe Checkout Session (only for paid)
$api_url = "https://api.stripe.com/v1/checkout/sessions";
$post_data = [
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'gbp',
            'product_data' => [
                'name' => $course_title . " - Accreditation",
            ],
            'unit_amount' => $amount * 100, // Stripe expects amounts in pence
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => SITE_URL . "student/payment_success.php?tx=" . $transaction_id,
    'cancel_url' => SITE_URL . "student/payment_cancel.php?tx=" . $transaction_id,
    'client_reference_id' => $transaction_id,
    'metadata' => [
        'transaction_id' => $transaction_id,
        'user_id' => $user_id,
        'item_type' => $type,
        'item_id' => $course_id
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
curl_setopt($ch, CURLOPT_USERPWD, STRIPE_SECRET_KEY . ':');

$result = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

if ($info['http_code'] === 200) {
    $session = json_decode($result, true);
    header("Location: " . $session['url']);
    exit;
} else {
    // Handle API Error
    $error = json_decode($result, true);
    $error_msg = $error['error']['message'] ?? 'Unable to initialize secure checkout.';
    die("Stripe API Error: " . $error_msg);
}
?>
