<?php
require_once '../includes/auth.php';
requireLogin();

$course_id = $_GET['id'] ?? null;
if (!$course_id) {
    header("Location: dashboard.php");
    exit();
}

// Check if passed exam
$stmt = $pdo->prepare("SELECT e.*, c.title as course_title, c.price, c.certificate_price 
    FROM enrollments e 
    JOIN courses c ON e.course_id = c.id 
    WHERE e.user_id = ? AND e.course_id = ? AND e.status = 'completed'");
$stmt->execute([$_SESSION['user_id'], $course_id]);
$course_data = $stmt->fetch();

if (!$course_data) {
    header("Location: course_view.php?id=" . $course_id);
    exit();
}

$message = '';
$voucher_discount = 0;

// Handle voucher check
if (isset($_POST['apply_voucher'])) {
    $code = $_POST['voucher_code'];
    $stmt = $pdo->prepare("SELECT * FROM vouchers WHERE code = ? AND (expiry_date >= CURDATE() OR expiry_date IS NULL) AND used_count < usage_limit");
    $stmt->execute([$code]);
    $voucher = $stmt->fetch();

    if ($voucher) {
        if ($voucher['discount_type'] == 'percent') {
            $voucher_discount = ($course_data['price'] * $voucher['discount_value']) / 100;
        } else {
            $voucher_discount = $voucher['discount_value'];
        }
        $message = "Voucher applied! £" . number_format($voucher_discount, 2) . " discount.";
    } else {
        $message = "Invalid or expired voucher.";
    }
}

// Final Calculations
$base_price = $course_data['price'];
$hard_copy_price = 25.00; // Standard price for hard copy
$total_price = $base_price - $voucher_discount;

// Handle Payment Redirection to Stripe
if (isset($_POST['pay_now'])) {
    $include_hard_copy = isset($_POST['hard_copy']);
    $final_amount = $total_price + ($include_hard_copy ? $hard_copy_price : 0);
    
    // Redirect to Checkout
    header("Location: checkout.php?course_id=$course_id&amount=$final_amount&type=certificate");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Your Certificate | BHA Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandBlue: '#0056b3',
                        brandGreen: '#28a745',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8FAFC] flex min-h-screen text-sm">

    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-grow p-8">
        <div class="max-w-4xl mx-auto">
            <header class="mb-12">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Certification & Checkout</h1>
                <p class="text-gray-500">Claim your professional credentials for <span class="text-brandBlue font-bold"><?php echo $course_data['course_title']; ?></span>.</p>
            </header>

            <?php if ($message): ?>
                <div class="bg-blue-50 text-brandBlue p-4 rounded-xl mb-8 border border-blue-100 flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Payment Options -->
                <div class="space-y-8">
                    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-brandGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Certificate Options
                        </h3>
                        <form action="certificate_pay.php?id=<?php echo $course_id; ?>" method="POST" id="payForm">
                            <div class="space-y-4">
                                <label class="flex items-start p-5 rounded-2xl border-2 border-brandBlue bg-blue-50/50 cursor-pointer relative overflow-hidden group">
                                    <input type="radio" checked class="hidden">
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-bold text-gray-900">Soft Copy (PDF)</span>
                                            <span class="text-brandBlue font-extrabold">INCLUDED</span>
                                        </div>
                                        <p class="text-xs text-gray-500 leading-relaxed">Instantly downloadable, CPD accredited, and verifiable via unique QR code.</p>
                                    </div>
                                    <div class="absolute top-0 right-0 w-12 h-12 bg-brandBlue text-white rounded-bl-3xl flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </label>

                                <label class="flex items-start p-5 rounded-2xl border-2 border-gray-100 hover:border-brandGreen transition cursor-pointer group">
                                    <input type="checkbox" name="hard_copy" id="hard_copy_toggle" class="mt-1 w-5 h-5 text-brandGreen border-gray-300 rounded focus:ring-brandGreen">
                                    <div class="ml-4">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-bold text-gray-900 group-hover:text-brandGreen transition">Add Hard Copy Card</span>
                                            <span class="text-gray-900 font-extrabold">+ £25.00</span>
                                        </div>
                                        <p class="text-xs text-gray-500 leading-relaxed">Professionally printed physical ID card sent to your address (Free UK Shipping).</p>
                                    </div>
                                </label>
                            </div>

                            <div class="mt-8">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Voucher or Referral Code</label>
                                <div class="flex space-x-2">
                                    <input type="text" name="voucher_code" class="flex-grow px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-brandBlue/20 outline-none text-sm" placeholder="ENTER CODE">
                                    <button type="submit" name="apply_voucher" class="bg-gray-900 text-white px-6 py-3 rounded-xl font-bold text-xs uppercase hover:bg-black transition">Apply</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-3xl border border-dashed border-gray-200">
                        <h4 class="font-bold text-gray-900 mb-2">Secure Payment</h4>
                        <p class="text-xs text-gray-400 leading-relaxed">Your transaction is protected by 256-bit SSL encryption. We accept all major credit cards and PayPal.</p>
                    </div>
                </div>

                <!-- Summary & Checkout -->
                <div>
                    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 sticky top-8">
                        <h3 class="font-bold text-gray-900 mb-8 border-b border-gray-50 pb-6">Payment Summary</h3>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-gray-500">
                                <span>Module Fee (<?php echo $course_data['course_title']; ?>)</span>
                                <span class="font-semibold text-gray-900">£<?php echo number_format($base_price, 2); ?></span>
                            </div>
                            <?php if ($voucher_discount > 0): ?>
                                <div class="flex justify-between text-brandGreen">
                                    <span>Voucher Discount</span>
                                    <span class="font-bold">- £<?php echo number_format($voucher_discount, 2); ?></span>
                                </div>
                            <?php endif; ?>
                            <div id="hardCopyRow" class="hidden flex justify-between text-gray-500">
                                <span>Hard Copy ID Card</span>
                                <span class="font-semibold text-gray-900">£25.00</span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Learning Platform Fee</span>
                                <span class="font-semibold text-brandGreen">FREE</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-50 pt-6 mb-10 flex justify-between items-end">
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total Amount</p>
                                <h2 id="totalDisplay" class="text-4xl font-extrabold text-brandBlue">£<?php echo number_format($total_price, 2); ?></h2>
                            </div>
                        </div>

                        <button form="payForm" name="pay_now" class="w-full bg-brandBlue text-white py-5 rounded-2xl font-extrabold text-lg hover:bg-blue-700 transition shadow-xl shadow-brandBlue/20 uppercase tracking-wider">
                            Complete Purchase
                        </button>
                        
                        <div class="mt-8 flex justify-center space-x-3 opacity-30 grayscale scale-75">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-6">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-6">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" class="h-6">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const hardCopyToggle = document.getElementById('hard_copy_toggle');
        const hardCopyRow = document.getElementById('hardCopyRow');
        const totalDisplay = document.getElementById('totalDisplay');
        const totalBase = <?php echo $total_price; ?>;

        hardCopyToggle.addEventListener('change', function() {
            if (this.checked) {
                hardCopyRow.classList.remove('hidden');
                totalDisplay.innerText = '£' + (totalBase + 25).toFixed(2);
            } else {
                hardCopyRow.classList.add('hidden');
                totalDisplay.innerText = '£' + totalBase.toFixed(2);
            }
        });
    </script>
</body>
</html>
