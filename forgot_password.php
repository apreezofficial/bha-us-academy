<?php
require_once 'includes/config.php';
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    if (!empty($email)) {
        // In a real system, send an email with a unique token.
        // For this demo, we'll simulate the "email sent" feedback.
        $message = "Clinical recovery instructions sent to <strong>$email</strong>. Please check your inbox.";
    } else {
        $error = "Please enter a valid email address.";
    }
}

$pageTitle = "Reset Password — BHA Academy";
include 'includes/header_public.php';
?>

<section class="min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Decorative Accents -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brandBlue/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-md w-full relative z-10">
        <div class="bg-white/5 border border-white/10 backdrop-blur-3xl rounded-[3rem] p-10 md:p-14 shadow-2xl">
            <div class="text-center mb-12">
                <a href="login.php" class="text-[10px] font-bold uppercase tracking-widest text-white/30 mb-8 inline-block hover:text-brandBlue transition-colors flex items-center justify-center gap-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Login
                </a>
                <h1 class="text-4xl font-black tracking-tighter mb-4 italic">Reset <span class="text-brandBlue">Access.</span></h1>
                <p class="text-white/40 font-light">Recover your clinical learning account.</p>
            </div>

            <?php if ($message): ?>
                <div class="bg-brandBlue/10 border border-brandBlue/20 text-brandBlue p-6 rounded-2xl text-sm mb-8 leading-relaxed">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-2xl text-sm mb-8">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if (!$message): ?>
            <form action="forgot_password.php" method="POST" class="space-y-6">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-white/30 mb-3 ml-1">Email Address</label>
                    <input type="email" name="email" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-brandBlue outline-none transition-all placeholder:text-white/10" placeholder="nurse@nhs.uk">
                </div>
                
                <button type="submit" class="w-full py-5 rounded-full bg-white text-black font-bold text-lg hover:bg-brandBlue hover:text-white transition-all duration-500 shadow-xl shadow-brandBlue/10">
                    Send Recovery Link
                </button>
            </form>
            <?php endif; ?>

            <div class="mt-12 text-center">
                <p class="text-white/40 text-sm font-light">
                    Protected by UK Clinical Data Standards.
                </p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer_public.php'; ?>
