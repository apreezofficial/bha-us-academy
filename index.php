<?php
require_once 'includes/config.php';

// Fetch courses
try {
    $stmt = $pdo->query("SELECT * FROM courses ORDER BY created_at DESC LIMIT 6");
    $db_courses = $stmt->fetchAll();
} catch (Exception $e) {
    $db_courses = [];
}

$pageTitle = "BHA Academy — The Gold Standard in UK Healthcare Training";
include 'includes/header_public.php';
?>

<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden py-32">
    <!-- Decorative Accents -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1000px] h-[1000px] bg-brandBlue/5 rounded-full blur-[120px] pointer-events-none"></div>
    
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10 text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 mb-12 animate-fade-in-up">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brandGreen opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-brandGreen"></span>
            </span>
            <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/60">Professional CPD Accreditation</span>
        </div>
        
        <h1 class="text-5xl md:text-7xl lg:text-8xl font-black leading-[0.9] tracking-tighter mb-12">
            Pioneering <br>
            <span class="text-gradient">Clinical</span> <br>
            Excellence.
        </h1>
        
        <p class="text-xl md:text-3xl text-white/40 max-w-4xl mx-auto mb-16 leading-relaxed font-light">
            Empowering the next generation of UK healthcare professionals through <span class="text-white">AI-driven clinical intelligence</span> and gold-standard professional training.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
            <a href="register.php" class="w-full sm:w-auto px-12 py-5 rounded-full bg-white text-black font-bold text-lg hover:bg-brandGreen hover:text-white transition-all duration-500 shadow-2xl shadow-brandGreen/20">
                Start Training Free
            </a>
            <a href="#courses" class="w-full sm:w-auto px-12 py-5 rounded-full bg-white/5 border border-white/10 text-white font-bold text-lg hover:bg-white/10 transition-all">
                Browse Curriculum
            </a>
        </div>

        <div class="mt-32 pt-16 border-t border-white/5 grid grid-cols-2 md:grid-cols-4 gap-12 text-left">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-white/30 mb-2">Completion Rate</p>
                <h4 class="text-4xl font-black">99.8%</h4>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-white/30 mb-2">UK Hospitals</p>
                <h4 class="text-4xl font-black">450+</h4>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-white/30 mb-2">Active Students</p>
                <h4 class="text-4xl font-black">12K+</h4>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-white/30 mb-2">CPD Credits</p>
                <h4 class="text-4xl font-black text-brandGreen">INSTANT</h4>
            </div>
        </div>
    </div>
</section>

<!-- Featured Courses Section -->
<section id="courses" class="py-32 relative">
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10">
        <div class="flex flex-col md:flex-row justify-between items-end gap-8 mb-24">
            <div class="max-w-2xl">
                <h2 class="text-xs font-bold uppercase tracking-[0.4em] text-brandGreen mb-6">Course Directory</h2>
                <h3 class="text-5xl md:text-7xl font-black tracking-tighter leading-none">
                    Industry-Standard <br>Learning Modules.
                </h3>
            </div>
            <a href="login.php" class="group flex items-center gap-3 text-lg font-bold">
                View All Courses
                <div class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center group-hover:bg-brandBlue group-hover:border-brandBlue transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($db_courses as $course): ?>
                <div class="group relative bg-white/5 border border-white/5 rounded-[2.5rem] p-10 hover:bg-white/[0.08] transition-all duration-500 overflow-hidden h-full flex flex-col">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brandBlue/10 blur-[60px] group-hover:bg-brandGreen/20 transition-all"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="mb-12 flex justify-between items-start">
                            <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center border border-white/10 group-hover:border-brandGreen/50 transition-colors">
                                <svg class="w-8 h-8 text-brandBlue group-hover:text-brandGreen transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <span class="px-4 py-2 rounded-full bg-brandGreen/10 border border-brandGreen/20 text-[10px] font-bold uppercase tracking-widest text-brandGreen">
                                CPD ACCREDITED
                            </span>
                        </div>
                        
                        <h4 class="text-3xl font-bold tracking-tight mb-6 group-hover:text-brandBlue transition-colors">
                            <?php echo htmlspecialchars($course['title'] ?? 'Untitled Course'); ?>
                        </h4>
                        
                        <p class="text-white/40 leading-relaxed mb-auto line-clamp-3">
                            <?php echo htmlspecialchars($course['description'] ?? 'No description available.'); ?>
                        </p>
                        
                        <div class="mt-12 flex items-center justify-between pt-8 border-t border-white/5">
                            <span class="text-2xl font-black">
                                <?php echo (isset($course['price']) && $course['price'] > 0) ? '£' . number_format($course['price'], 2) : 'FREE'; ?>
                            </span>
                            <a href="login.php" class="px-8 py-3 rounded-xl bg-white/5 hover:bg-brandBlue text-sm font-bold transition-all">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="py-64 bg-white/2 overflow-hidden relative">
    <div class="absolute top-1/2 left-0 w-[800px] h-[800px] bg-brandGreen/5 rounded-full blur-[150px] pointer-events-none"></div>
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-32 items-center">
            <div>
                <h2 class="text-xs font-bold uppercase tracking-[0.4em] text-brandBlue mb-8">Clinical standard</h2>
                <h3 class="text-6xl md:text-8xl font-black tracking-tighter leading-[0.85] mb-12">
                    Professionalism <br>
                    Is Not An <br>
                    Option.
                </h3>
                <p class="text-2xl text-white/40 leading-relaxed max-w-xl font-light">
                    Our platform is more than just an LMS. We provide clinical-grade simulations and AI-assisted content analysis to ensure every student meets the rigorous standards of the UK Healthcare industry.
                </p>
            </div>
            <div class="relative">
                <div class="aspect-square bg-white/5 rounded-[4rem] border border-white/10 p-12 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-brandBlue/20 to-brandGreen/20 opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                    <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&q=80&w=2070" class="w-full h-full object-cover rounded-[3rem] shadow-2xl grayscale group-hover:grayscale-0 transition-all duration-1000 scale-110 group-hover:scale-100" alt="Clinical Environment">
                </div>
                <!-- Floating Card -->
                <div class="absolute -bottom-10 -left-10 bg-darkBg border border-white/10 p-8 rounded-3xl shadow-2xl backdrop-blur-3xl">
                    <p class="text-[10px] font-bold text-brandGreen uppercase tracking-widest mb-2">Verified Instructor</p>
                    <p class="text-lg font-bold">Dr. Sarah Thompson</p>
                    <p class="text-sm text-white/40">NHS Clinical Lead</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer_public.php'; ?>
