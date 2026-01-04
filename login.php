<?php
require_once 'includes/auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (loginUser($email, $password)) {
        if (isAdmin()) {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: student/dashboard.php");
        }
        exit();
    } else {
        $error = 'Invalid email or password.';
    }
}

$pageTitle = "Login — BHA Academy";
include 'includes/header_public.php';
?>

<section class="min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Decorative Accents -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brandBlue/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-md w-full relative z-10">
        <div class="bg-white/5 border border-white/10 backdrop-blur-3xl rounded-[3rem] p-10 md:p-14 shadow-2xl">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-black tracking-tighter mb-4">Welcome <span class="text-brandBlue">Back.</span></h1>
                <p class="text-white/40 font-light italic">Access your clinical modules.</p>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-2xl text-sm mb-8 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="space-y-6">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-white/30 mb-3 ml-1">Email Address</label>
                    <input type="email" name="email" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-brandBlue outline-none transition-all placeholder:text-white/10" placeholder="nurse@nhs.uk">
                </div>
                <div>
                    <div class="flex justify-between items-center mb-3 px-1">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-white/30">Password</label>
                        <a href="forgot_password.php" class="text-[10px] font-bold uppercase tracking-widest text-brandBlue hover:text-white transition-colors">Forgot?</a>
                    </div>
                    <input type="password" name="password" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-brandBlue outline-none transition-all placeholder:text-white/10" placeholder="••••••••">
                </div>
                
                <button type="submit" class="w-full py-5 rounded-full bg-white text-black font-bold text-lg hover:bg-brandBlue hover:text-white transition-all duration-500 shadow-xl shadow-brandBlue/10">
                    Sign In
                </button>
            </form>

            <div class="mt-12 text-center">
                <p class="text-white/40 text-sm font-light">
                    New to the academy? <a href="register.php" class="text-white font-bold hover:text-brandGreen underline underline-offset-4 decoration-white/20">Create account</a>
                </p>
            </div>
        </div>
        
        <div class="mt-12 flex justify-center items-center gap-6 opacity-30 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-700">
            <span class="text-[10px] font-bold tracking-[0.2em] text-white">CPD CERTIFIED</span>
            <div class="h-4 w-px bg-white/20"></div>
            <span class="text-[10px] font-bold tracking-[0.2em] text-white">UK STANDARDS</span>
        </div>
    </div>
</section>

<?php include 'includes/footer_public.php'; ?>
