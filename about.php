<?php
require_once 'includes/config.php';
$pageTitle = "Our Mission — Brilliance Healthcare Academy";
include 'includes/header_public.php';
?>

<!-- Hero Section -->
<section class="relative min-h-[80vh] flex items-center pt-40 pb-20 overflow-hidden">
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10 relative z-10 w-full">
        <div class="max-w-6xl">
            <h2 class="text-xs font-bold uppercase tracking-[0.4em] text-brandGreen mb-12 animate-fade-in">Our Founding Story</h2>
            <h1 class="text-6xl md:text-8xl font-black leading-[0.9] tracking-tighter mb-16 italic">
                Pioneering <br>
                Healthcare <br>
                Education.
            </h1>
            <p class="text-3xl text-white/40 max-w-3xl leading-relaxed font-light">
                Brilliance Healthcare Academy (BHA) was founded with a singular vision: to bridge the gap between <span class="text-white">academic knowledge</span> and <span class="text-white">clinical excellence</span>.
            </p>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-32 relative">
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="p-12 bg-white/5 border border-white/10 rounded-[3rem]">
                <div class="w-16 h-16 bg-brandBlue/20 rounded-2xl flex items-center justify-center mb-8">
                    <svg class="w-8 h-8 text-brandBlue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h4 class="text-3xl font-bold mb-6">Integrity</h4>
                <p class="text-white/40 leading-relaxed font-light">We adhere to the highest clinical standards, ensuring every module is peer-reviewed and CPD accredited.</p>
            </div>
            <div class="p-12 bg-white/5 border border-white/10 rounded-[3rem]">
                <div class="w-16 h-16 bg-brandGreen/20 rounded-2xl flex items-center justify-center mb-8">
                    <svg class="w-8 h-8 text-brandGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h4 class="text-3xl font-bold mb-6">Innovation</h4>
                <p class="text-white/40 leading-relaxed font-light">Leveraging AI to provide personalized study paths and real-time clinical simulations for students.</p>
            </div>
            <div class="p-12 bg-white/5 border border-white/10 rounded-[3rem]">
                <div class="w-16 h-16 bg-brandBlue/20 rounded-2xl flex items-center justify-center mb-8">
                    <svg class="w-8 h-8 text-brandBlue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h4 class="text-3xl font-bold mb-6">Community</h4>
                <p class="text-white/40 leading-relaxed font-light">Building a global network of healthcare professionals who support and mentor each other.</p>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-32 bg-white/2">
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-32">
            <div>
                <h3 class="text-5xl font-black mb-12 tracking-tight">Our Reach.</h3>
                <p class="text-xl text-white/60 leading-relaxed mb-8">
                    Since our inception, we have trained over 12,000 students across the UK and internationally. Our certificates are recognized by major NHS trusts and private healthcare providers.
                </p>
                <div class="space-y-6">
                    <div class="flex items-center gap-6 p-6 rounded-3xl bg-white/5 border border-white/10">
                        <div class="text-4xl font-black text-brandGreen">450+</div>
                        <div class="text-sm font-bold uppercase tracking-widest text-white/40">Partner Institutions</div>
                    </div>
                    <div class="flex items-center gap-6 p-6 rounded-3xl bg-white/5 border border-white/10">
                        <div class="text-4xl font-black text-brandBlue">98%</div>
                        <div class="text-sm font-bold uppercase tracking-widest text-white/40">Student Satisfaction</div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&q=80&w=2080" class="rounded-[4rem] shadow-2xl border border-white/10" alt="Laboratory">
                <div class="absolute -top-10 -right-10 w-48 h-48 bg-brandBlue/30 rounded-full blur-[80px]"></div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer_public.php'; ?>
