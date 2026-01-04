<?php
require_once 'includes/config.php';
$pageTitle = "For Organizations — BHA Academy";
include 'includes/header_public.php';
?>

<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center pt-40 pb-20 overflow-hidden">
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10 relative z-10 w-full text-center">
        <h2 class="text-xs font-bold uppercase tracking-[0.4em] text-brandBlue mb-12">Enterprise Solutions</h2>
        <h1 class="text-6xl md:text-8xl lg:text-9xl font-black leading-[0.9] tracking-tighter mb-16">
            Scale Your <br>
            <span class="text-gradient">Workforce.</span>
        </h1>
        <p class="text-2xl md:text-4xl text-white/40 max-w-5xl mx-auto leading-relaxed font-light mb-16">
            Custom-built training ecosystems for <span class="text-white">NHS Trusts, Clinics, and Private Groups</span>. Manage thousands of students with a single dashboard.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
            <a href="contact.php" class="w-full sm:w-auto px-12 py-5 rounded-full bg-brandBlue text-white font-bold text-lg hover:shadow-[0_0_30px_-5px_#0056b3] transition-all">
                Request Demo
            </a>
            <a href="register.php" class="w-full sm:w-auto px-12 py-5 rounded-full bg-white/5 border border-white/10 text-white font-bold text-lg hover:bg-white/10 transition-all">
                Bulk Registration
            </a>
        </div>
    </div>
</section>

<!-- Features Grid -->
<section class="py-32 relative">
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="p-10 bg-white/5 border border-white/10 rounded-[3rem] hover:border-brandBlue/50 transition-all">
                <h4 class="text-2xl font-bold mb-4">Centralized Reporting</h4>
                <p class="text-white/40 leading-relaxed font-light">Track completion rates, exam scores, and certificate issuance for your entire team in real-time.</p>
            </div>
            <div class="p-10 bg-white/5 border border-white/10 rounded-[3rem] hover:border-brandGreen/50 transition-all">
                <h4 class="text-2xl font-bold mb-4">Custom Curriculums</h4>
                <p class="text-white/40 leading-relaxed font-light">Order bespoke modules tailored specifically to your organization's unique clinical requirements.</p>
            </div>
            <div class="p-10 bg-white/5 border border-white/10 rounded-[3rem] hover:border-brandBlue/50 transition-all">
                <h4 class="text-2xl font-bold mb-4">White-Label Options</h4>
                <p class="text-white/40 leading-relaxed font-light">Host training on your own subdomain with your organization's branding and color schemes.</p>
            </div>
            <div class="p-10 bg-white/5 border border-white/10 rounded-[3rem] hover:border-brandGreen/50 transition-all">
                <h4 class="text-2xl font-bold mb-4">Volume Discounts</h4>
                <p class="text-white/40 leading-relaxed font-light">Significant price reductions for teams of 50 or more. Flexible billing and invoicing options.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-64">
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10 text-center">
        <div class="max-w-4xl mx-auto p-20 bg-gradient-to-br from-brandBlue to-brandGreen rounded-[4rem] relative overflow-hidden group shadow-2xl shadow-brandBlue/20">
            <div class="absolute inset-0 bg-darkBg/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <h3 class="text-5xl md:text-7xl font-black tracking-tighter text-white mb-12 relative z-10">Ready to <br>Transform?</h3>
            <a href="contact.php" class="inline-block px-14 py-6 rounded-full bg-white text-darkBg font-bold text-xl hover:scale-110 transition-transform relative z-10">
                Contact Enterprise Team
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer_public.php'; ?>
