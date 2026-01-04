<?php
require_once 'includes/auth.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $referral_code = $_POST['referral_code'] ?? null;

    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $error = 'Email already registered.';
    } else {
        $referred_by = null;
        if ($referral_code) {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE referral_code = ?");
            $stmt->execute([$referral_code]);
            $referer = $stmt->fetch();
            if ($referer) {
                $referred_by = $referer['id'];
            }
        }

        if (registerUser($name, $email, $password, $referred_by)) {
            $success = 'Account created! You can now login.';
        } else {
            $error = 'Failed to create account. Please try again.';
        }
    }
}

$pageTitle = "Join the Academy — BHA Academy";
include 'includes/header_public.php';
?>

<section class="min-h-screen flex items-center justify-center p-6 py-20 relative overflow-hidden">
    <!-- Decorative Accents -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-brandGreen/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-md w-full relative z-10">
        <div class="bg-white/5 border border-white/10 backdrop-blur-3xl rounded-[3rem] p-10 md:p-14 shadow-2xl">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-black tracking-tighter mb-4 italic">Join the <span class="text-brandGreen">Future.</span></h1>
                <p class="text-white/40 font-light">Excellence begins with a single step.</p>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-2xl text-sm mb-8 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-brandGreen/10 border border-brandGreen/20 text-brandGreen p-4 rounded-2xl text-sm mb-8 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <?php echo $success; ?>
                    <a href="login.php" class="ml-auto font-bold underline">Login Now</a>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST" class="space-y-5">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-white/30 mb-3 ml-1">Full Name</label>
                    <input type="text" name="name" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-brandGreen outline-none transition-all placeholder:text-white/10" placeholder="John Doe">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-white/30 mb-3 ml-1">Email Address</label>
                    <input type="email" name="email" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-brandGreen outline-none transition-all placeholder:text-white/10" placeholder="name@domain.com">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-white/30 mb-3 ml-1">Password</label>
                    <input type="password" name="password" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-brandGreen outline-none transition-all placeholder:text-white/10" placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-white/30 mb-3 ml-1">Referral Code (Optional)</label>
                    <input type="text" name="referral_code" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-brandGreen outline-none transition-all placeholder:text-white/10" placeholder="BHA-XXXXX">
                </div>
                
                <p class="text-[10px] text-white/20 leading-relaxed px-1">
                    By registering, you agree to the <a href="#" class="text-white font-bold hover:underline">Terms of Service</a> and our clinical <a href="#" class="text-white font-bold hover:underline">Privacy Policy</a>.
                </p>

                <button type="submit" class="w-full py-5 rounded-full bg-brandGreen text-white font-bold text-lg hover:shadow-[0_0_40px_-10px_#28a745] transition-all duration-500">
                    Create Account
                </button>
            </form>

            <div class="mt-12 text-center">
                <p class="text-white/40 text-sm font-light">
                    Already registered? <a href="login.php" class="text-white font-bold hover:text-brandBlue underline underline-offset-4 decoration-white/20">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer_public.php'; ?>
