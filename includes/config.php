<?php
// Brilliance Healthcare Academy Configuration

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'bha_academy');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site URLs
define('SITE_URL', 'http://localhost/gigs/bha%20academy/');

// Pollinations AI API
define('POLLINATIONS_API_URL', 'https://text.pollinations.ai/');

// Theme Colors
define('COLOR_PRIMARY', '#0056b3'); // Blue
define('COLOR_SECONDARY', '#28a745'); // Green

// Stripe Configuration
define('STRIPE_PUBLIC_KEY', 'pk_test_placeholder');
define('STRIPE_SECRET_KEY', 'sk_test_placeholder');
define('STRIPE_WEBHOOK_SECRET', 'whsec_placeholder');

// Helper Functions
function img_url($path) {
    if (!$path) return 'http://localhost/gigs/bha%20academy/assets/logo.jpg';
    return $path;
}

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // For now, only log error if DB exists. In production, we'd handle this better.
    // die("Connection failed: " . $e->getMessage());
}

// Autoload helper functions (if any)
// require_once 'functions.php';
?>
