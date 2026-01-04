<?php
require_once 'includes/config.php';
$pageTitle = "Accreditation & Certificates — BHA Academy";
include 'includes/header_public.php';
?>

<!-- Hero Section -->
<section class="relative min-h-[80vh] flex items-center pt-40 pb-20 overflow-hidden">
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10 relative z-10 w-full">
        <h2 class="text-xs font-bold uppercase tracking-[0.4em] text-brandGreen mb-12">The Gold Standard</h2>
        <h1 class="text-6xl md:text-8xl font-black leading-[0.9] tracking-tighter mb-16 italic">
            Certified <br>
            Excellence.
        </h1>
        <p class="text-3xl text-white/40 max-w-4xl leading-relaxed font-light">
            Every certificate issued by Brilliance Healthcare Academy is <span class="text-white">CPD Accredited</span> and recognized by the UK's leading healthcare governing bodies.
        </p>
    </div>
</section>

<!-- Certification Grid -->
<section class="py-32 relative">
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <div class="p-16 bg-white/5 border border-white/10 rounded-[4rem] relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-brandBlue/10 blur-[100px] group-hover:bg-brandBlue/30 transition-all"></div>
                <h4 class="text-4xl font-black mb-8">Instant Digital <br>Issuance.</h4>
                <p class="text-xl text-white/40 leading-relaxed font-light mb-12 italic">
                    Download your professional PDF certificate immediately after passing your final clinical exam. No waiting, no delays.
                </p>
                <div class="w-full h-80 bg-darkBg border border-white/5 rounded-3xl p-8 shadow-inner overflow-hidden">
                    <!-- Certificate Mockup -->
                    <div class="border-2 border-brandGreen/20 p-8 h-full rounded-xl flex flex-col justify-between opacity-40">
                        <div>
                            <p class="text-[8px] font-bold text-brandGreen uppercase mb-2">Completion Certificate</p>
                            <p class="text-xl font-bold">John Doe</p>
                        </div>
                        <div class="text-[8px] font-mono text-white/20">ID: BHA-129-XJ29</div>
                    </div>
                </div>
            </div>
            
            <div class="p-16 bg-white/5 border border-white/10 rounded-[4rem] relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-brandGreen/10 blur-[100px] group-hover:bg-brandGreen/30 transition-all"></div>
                <h4 class="text-4xl font-black mb-8">Global <br>Recognition.</h4>
                <p class="text-xl text-white/40 leading-relaxed font-light mb-12 italic">
                    Our accreditation is mapped to the UK Care Certificate standards and clinical protocols used across the NHS.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center gap-6 p-6 bg-white/5 rounded-3xl border border-white/10">
                        <div class="w-12 h-12 bg-brandGreen/20 rounded-xl flex items-center justify-center font-bold text-brandGreen">CPD</div>
                        <span class="font-bold text-white/60">Fully Accredited CPD Points</span>
                    </div>
                    <div class="flex items-center gap-6 p-6 bg-white/5 rounded-3xl border border-white/10">
                        <div class="w-12 h-12 bg-brandBlue/20 rounded-xl flex items-center justify-center font-bold text-brandBlue text-xs text-center">UK<br>GOV</div>
                        <span class="font-bold text-white/60">Mapped to UK Clinical Frameworks</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer_public.php'; ?>
