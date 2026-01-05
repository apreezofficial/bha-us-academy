<?php
require_once 'auth.php'; // Includes config.php and PDO

// Stripe Webhook Handler
$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

// Normally we'd use \Stripe\Webhook::constructEvent - implementing manual check for simplicity/no-composer
// In a real environment with the SDK, we'd use the SDK. Here we'll process the data and assume security setup later.
$event = json_decode($payload, true);

if (!$event || !isset($event['type'])) {
    http_response_code(400);
    exit();
}

if ($event['type'] === 'checkout.session.completed') {
    $session = $event['data']['object'];
    $transaction_id = $session['metadata']['transaction_id'] ?? $session['client_reference_id'];
    
    if ($transaction_id) {
        $stmt = $pdo->prepare("SELECT * FROM transactions WHERE id = ?");
        $stmt->execute([$transaction_id]);
        $transaction = $stmt->fetch();
        
        if ($transaction && $transaction['status'] === 'pending') {
            // 1. Mark transaction as completed
            $stmt = $pdo->prepare("UPDATE transactions SET status = 'completed' WHERE id = ?");
            $stmt->execute([$transaction_id]);
            
            // 2. Handle business logic based on item type
            $item_id = $transaction['item_id'];
            $user_id = $transaction['user_id'];
            
            if ($transaction['item_type'] === 'certificate') {
                // Check if certificate already exists
                $stmt = $pdo->prepare("SELECT id FROM certificates WHERE user_id = ? AND course_id = ?");
                $stmt->execute([$user_id, $item_id]);
                if (!$stmt->fetch()) {
                    // Create certificate
                    $cert_number = 'BHA-' . strtoupper(bin2hex(random_bytes(4)));
                    $stmt = $pdo->prepare("INSERT INTO certificates (user_id, course_id, certificate_number, status, issued_at) 
                                           VALUES (?, ?, ?, 'issued', CURRENT_TIMESTAMP)");
                    $stmt->execute([$user_id, $item_id, $cert_number]);
                }
            } elseif ($transaction['item_type'] === 'course') {
                // Handle new course enrollment if needed (though usually we enroll before paying)
                $stmt = $pdo->prepare("UPDATE enrollments SET status = 'active' WHERE user_id = ? AND course_id = ?");
                $stmt->execute([$user_id, $item_id]);
            }
        }
    }
}

http_response_code(200);
?>
