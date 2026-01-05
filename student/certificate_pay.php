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
$message_type = 'info';
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
        $message_type = 'success';
    } else {
        $message = "Invalid or expired voucher.";
        $message_type = 'error';
    }
}

// Final Calculations
$base_price = $course_data['price'];
$hard_copy_price = 25.00; // Standard price for hard copy
$total_price = max(0, $base_price - $voucher_discount);

// Handle Payment Redirection or Instant Claim
if (isset($_POST['pay_now'])) {
    $include_hard_copy = isset($_POST['hard_copy']);
    $final_amount = $total_price + ($include_hard_copy ? $hard_copy_price : 0);
    
    // Check for free claim
    if ($final_amount <= 0) {
        // Direct issuance for free
        header("Location: checkout.php?course_id=$course_id&amount=0&type=certificate");
    } else {
        // Redirect to Stripe Checkout
        header("Location: checkout.php?course_id=$course_id&amount=$final_amount&type=certificate");
    }
    exit();
}

$pageTitle = "Checkout";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="max-w-xl">
            <h1 class="text-4xl font-black tracking-tighter mb-4 leading-none uppercase">Certification Checkout</h1>
            <p class="text-muted-foreground font-medium">Claim your professional credentials for <span class="text-foreground font-bold"><?php echo $course_data['course_title']; ?></span>.</p>
        </div>
        
        <div class="flex items-center gap-2 bg-muted/30 px-4 py-2 rounded-full border border-dashed">
            <span class="text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Security Status</span>
            <div class="h-2 w-2 rounded-full bg-brandGreen"></div>
            <span class="text-xs font-bold leading-none uppercase tracking-tighter">Encrypted</span>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="p-4 rounded-2xl border flex items-center gap-4 <?php echo $message_type == 'success' ? 'bg-brandGreen/10 text-brandGreen border-brandGreen/20' : ($message_type == 'error' ? 'bg-destructive/10 text-destructive border-destructive/20' : 'bg-brandBlue/10 text-brandBlue border-brandBlue/20'); ?>">
            <div class="h-10 w-10 rounded-xl bg-background/50 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
            </div>
            <p class="text-sm font-bold"><?php echo $message; ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Delivery Options -->
        <div class="space-y-8">
            <div class="bg-card border rounded-[2rem] p-8 shadow-sm">
                <h3 class="font-bold text-foreground text-sm uppercase tracking-widest mb-6 flex items-center border-b pb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3 text-brandGreen"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path></svg>
                    Certificate Options
                </h3>
                
                <form action="certificate_pay.php?id=<?php echo $course_id; ?>" method="POST" id="payForm" class="space-y-4">
                    <label class="flex items-start p-6 rounded-2xl border-2 border-brandBlue bg-brandBlue/5 cursor-pointer relative overflow-hidden group">
                        <input type="radio" checked class="hidden">
                        <div class="flex-grow">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-foreground text-base">Soft Copy (e-PDF)</span>
                                <span class="text-[10px] font-black uppercase tracking-tighter bg-brandBlue text-white px-2 py-0.5 rounded">Included</span>
                            </div>
                            <p class="text-[11px] text-muted-foreground leading-relaxed font-medium">Instantly downloadable, professionally accredited, and verifiable via unique QR code system.</p>
                        </div>
                        <div class="absolute top-0 right-0 w-10 h-10 bg-brandBlue text-white rounded-bl-3xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                    </label>

                    <label class="flex items-start p-6 rounded-2xl border-2 border-muted hover:border-brandGreen transition-all cursor-pointer group bg-card">
                        <input type="checkbox" name="hard_copy" id="hard_copy_toggle" class="mt-1 h-5 w-5 rounded border-muted-foreground/30 text-brandGreen focus:ring-brandGreen bg-background">
                        <div class="ml-4 flex-grow">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-foreground text-base group-hover:text-brandGreen transition-colors">Physical Hard Copy</span>
                                <span class="text-sm font-black text-foreground">+ £<?php echo number_format($hard_copy_price, 2); ?></span>
                            </div>
                            <p class="text-[11px] text-muted-foreground leading-relaxed font-medium">Standard clinical ID card printed on premium PVC. Sent to your address with tracked shipping.</p>
                        </div>
                    </label>

                    <div class="mt-10">
                        <label class="block text-[10px] font-black text-muted-foreground uppercase tracking-widest mb-3">Redeem Referral or Voucher</label>
                        <div class="flex gap-2">
                            <input type="text" name="voucher_code" class="flex-grow h-12 bg-muted/50 px-4 rounded-xl border border-muted focus:border-brandBlue focus:ring-1 focus:ring-brandBlue outline-none text-sm font-bold uppercase tracking-wider" placeholder="ENTER CODE">
                            <button type="submit" name="apply_voucher" class="h-12 bg-foreground text-background px-8 rounded-xl font-bold text-xs uppercase tracking-widest hover:opacity-90 transition-all shadow-lg active:scale-95">Verify</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-muted/10 p-6 rounded-[2rem] border border-dashed text-center">
                <div class="flex items-center justify-center gap-2 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <h4 class="font-bold text-foreground text-xs uppercase tracking-widest">Global Accreditation</h4>
                </div>
                <p class="text-[11px] text-muted-foreground leading-relaxed font-medium">All certificates are CPD certified and recognized globally in clinical and professional environments.</p>
            </div>
        </div>

        <!-- Summary & Checkout -->
        <div class="lg:sticky lg:top-24 h-fit">
            <div class="bg-card border rounded-[2rem] p-10 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-brandBlue/5 rounded-full -mr-16 -mt-16 blur-3xl"></div>
                
                <h3 class="font-bold text-foreground text-sm uppercase tracking-widest mb-10 border-b pb-4">Professional Intent</h3>
                
                <div class="space-y-6 mb-12">
                    <div class="flex justify-between items-center group">
                        <span class="text-sm font-medium text-muted-foreground group-hover:text-foreground transition-colors">Course Module Fee</span>
                        <span class="text-sm font-black">£<?php echo number_format($base_price, 2); ?></span>
                    </div>
                    
                    <?php if ($voucher_discount > 0): ?>
                        <div class="flex justify-between items-center text-brandGreen">
                            <span class="text-sm font-bold">Voucher Deduction</span>
                            <span class="text-sm font-black">- £<?php echo number_format($voucher_discount, 2); ?></span>
                        </div>
                    <?php endif; ?>

                    <div id="hardCopyRow" class="hidden flex justify-between items-center text-brandBlue">
                        <span class="text-sm font-bold">PVC ID Card Fabrication</span>
                        <span class="text-sm font-black">£<?php echo number_format($hard_copy_price, 2); ?></span>
                    </div>

                    <div class="flex justify-between items-center pt-6 border-t border-dashed">
                        <div>
                            <p class="text-[10px] text-muted-foreground font-black uppercase tracking-widest opacity-60">Payable Total</p>
                            <h2 id="totalDisplay" class="text-5xl font-black tracking-tighter text-foreground leading-none mt-1">£<?php echo number_format($total_price, 2); ?></h2>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <button form="payForm" name="pay_now" class="w-full h-16 bg-brandBlue text-white rounded-2xl font-black text-lg hover:shadow-2xl hover:shadow-brandBlue/20 hover:-translate-y-0.5 active:translate-y-0 transition-all uppercase tracking-widest flex items-center justify-center gap-3">
                        <span id="buttonText"><?php echo ($total_price <= 0) ? 'Claim Instant Access' : 'Proceed to Payment'; ?></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=""><path d="m9 18 6-6-6-6"></path></svg>
                    </button>
                    
                    <p class="text-[10px] text-muted-foreground text-center font-bold uppercase tracking-tighter opacity-40">By proceeding, you agree to our certification conditions & terms.</p>
                </div>

                <div class="mt-12 flex justify-center items-center gap-6 opacity-40 grayscale">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-4" alt="Visa">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-5" alt="Mastercard">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" class="h-4" alt="PayPal">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Stripe_logo%2C_revised_2016.png" class="h-4" alt="Stripe">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hardCopyToggle = document.getElementById('hard_copy_toggle');
        const hardCopyRow = document.getElementById('hardCopyRow');
        const totalDisplay = document.getElementById('totalDisplay');
        const totalBase = <?php echo $total_price; ?>;
        const hardCopyPrice = <?php echo $hard_copy_price; ?>;

        hardCopyToggle.addEventListener('change', function() {
            const buttonText = document.getElementById('buttonText');
            if (this.checked) {
                hardCopyRow.classList.remove('hidden');
                const newTotal = (totalBase + hardCopyPrice);
                totalDisplay.innerText = '£' + newTotal.toFixed(2);
                buttonText.innerText = 'Proceed to Payment';
            } else {
                hardCopyRow.classList.add('hidden');
                totalDisplay.innerText = '£' + totalBase.toFixed(2);
                buttonText.innerText = totalBase <= 0 ? 'Claim Instant Access' : 'Proceed to Payment';
            }
        });
    });
</script>

<?php include '../includes/footer_student.php'; ?>
