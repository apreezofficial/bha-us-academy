<?php
require_once 'includes/config.php';

// Fetch courses
try {
    $stmt = $pdo->query("SELECT * FROM courses ORDER BY created_at DESC LIMIT 6");
    $db_courses = $stmt->fetchAll();
} catch (Exception $e) {
    $db_courses = [];
}

$pageTitle = "The Gold Standard in Clinical Training";
include 'includes/header_public.php';
?>

<!-- Hero Section -->
<section class="relative min-h-[95vh] flex items-center justify-center overflow-hidden py-32">
    <!-- Decorative Accents -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1200px] h-[1200px] bg-brandBlue/5 rounded-full blur-[140px] pointer-events-none opacity-50"></div>
    
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10 text-center relative z-10">
        <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-white/5 border border-white/10 mb-12 animate-in fade-in slide-in-from-bottom-4 duration-1000">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brandGreen opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-brandGreen"></span>
            </span>
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-white/50">Clinical standard CPD Accreditation</span>
        </div>
        
        <h1 class="text-6xl md:text-8xl lg:text-[10rem] font-black leading-[0.8] tracking-tighter mb-16 uppercase italic">
            Clinical <br>
            <span class="text-brandBlue italic">Excellence</span> <br>
            Redefined.
        </h1>
        
        <p class="text-xl md:text-3xl text-white/30 max-w-4xl mx-auto mb-20 leading-relaxed font-medium">
            Empowering the next generation of UK healthcare professionals through <span class="text-white">AI-augmented clinical simulations</span> and accredited world-class training protocols.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
            <a href="register.php" class="w-full sm:w-auto h-16 px-16 rounded-2xl bg-white text-black font-black text-xs uppercase tracking-[0.2em] hover:bg-brandGreen hover:text-white transition-all duration-700 shadow-2xl shadow-brandGreen/20 flex items-center justify-center">
                Initialize Enrollment
            </a>
            <a href="#courses" class="w-full sm:w-auto h-16 px-16 rounded-2xl bg-white/5 border border-white/10 text-white font-black text-xs uppercase tracking-[0.2em] hover:bg-white/10 transition-all flex items-center justify-center">
                Browse Curriculum
            </a>
        </div>

        <div class="mt-40 pt-20 border-t border-white/5 grid grid-cols-2 md:grid-cols-4 gap-12 text-left opacity-60 grayscale group-hover:grayscale-0 transition-all">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-white/40 mb-3 italic">Clinical Success</p>
                <h4 class="text-5xl font-black italic tracking-tighter">99.8%</h4>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-white/40 mb-3 italic">NHS Partners</p>
                <h4 class="text-5xl font-black italic tracking-tighter">450+</h4>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-white/40 mb-3 italic">Active Cadets</p>
                <h4 class="text-5xl font-black italic tracking-tighter">12K+</h4>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-white/40 mb-3 italic">Verification</p>
                <h4 class="text-5xl font-black italic tracking-tighter text-brandGreen">LIVE</h4>
            </div>
        </div>
    </div>
</section>

<!-- Trust Verification Section -->
<section class="py-24 border-y border-white/5 bg-white/2">
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10 flex flex-col md:flex-row items-center justify-between gap-12">
        <div class="max-w-xl">
            <h3 class="text-3xl font-black tracking-tighter uppercase italic leading-none mb-4">Validate Every Credential.</h3>
            <p class="text-white/40 font-medium">External organizations can verify the authenticity of any clinical certificate issued by our academy in real-time through our universal registry.</p>
        </div>
        <a href="verify.php" class="h-16 px-12 bg-transparent border-2 border-white/10 rounded-2xl font-black text-[10px] uppercase tracking-widest flex items-center gap-4 hover:border-brandBlue hover:text-brandBlue transition-all shrink-0">
            Access Universal Registry
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path></svg>
        </a>
    </div>
</section>

<!-- Featured Courses Section -->
<section id="courses" class="py-40 relative">
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10">
        <div class="flex flex-col md:flex-row justify-between items-end gap-12 mb-32">
            <div class="max-w-3xl">
                <h2 class="text-xs font-black uppercase tracking-[0.5em] text-brandGreen mb-8">Clinical Directory</h2>
                <h3 class="text-5xl md:text-8xl font-black tracking-tighter leading-[0.8] uppercase italic">
                    Accredited <br>Curriculum.
                </h3>
            </div>
            <a href="login.php" class="group flex items-center gap-4 text-xs font-black uppercase tracking-widest hover:text-brandBlue transition-colors">
                Registry Full Access
                <div class="w-14 h-14 rounded-2xl border-2 border-white/10 flex items-center justify-center group-hover:bg-brandBlue group-hover:border-brandBlue transition-all rotate-[-15deg] group-hover:rotate-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php foreach ($db_courses as $course): ?>
                <div class="group relative bg-white/[0.03] border-2 border-white/5 rounded-[3rem] p-12 hover:bg-white/[0.06] hover:border-brandBlue/30 transition-all duration-700 overflow-hidden h-full flex flex-col hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-brandBlue/5 blur-[80px] group-hover:bg-brandGreen/10 transition-all duration-1000"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="mb-14 flex justify-between items-start">
                            <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center border-2 border-white/5 group-hover:border-brandGreen/30 transition-all duration-700 shadow-2xl">
                                <svg class="w-10 h-10 text-brandBlue group-hover:text-brandGreen transition-colors duration-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <span class="px-5 py-2.5 rounded-full bg-brandGreen/10 border-2 border-brandGreen/20 text-[9px] font-black uppercase tracking-[0.2em] text-brandGreen italic shadow-lg shadow-brandGreen/5">
                                CPD ACCREDITED
                            </span>
                        </div>
                        
                        <h4 class="text-4xl font-black tracking-tighter mb-8 leading-[1.1] group-hover:text-brandBlue transition-colors duration-500 uppercase italic">
                            <?php echo htmlspecialchars($course['title'] ?? 'Untitled Course'); ?>
                        </h4>
                        
                        <p class="text-white/30 text-base font-medium leading-relaxed mb-auto line-clamp-3 italic">
                            <?php echo htmlspecialchars($course['description'] ?? 'No description available.'); ?>
                        </p>
                        
                        <div class="mt-16 flex items-center justify-between pt-10 border-t border-white/5">
                            <span class="text-3xl font-black italic tracking-tighter">
                                <?php echo (isset($course['price']) && $course['price'] > 0) ? '£' . number_format($course['price'], 2) : 'FREE'; ?>
                            </span>
                            <a href="login.php" class="h-14 px-10 rounded-2xl bg-white/5 hover:bg-white text-black text-white hover:text-black text-xs font-black uppercase tracking-widest transition-all duration-500 shadow-xl">
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
<section class="py-80 bg-white/[0.01] overflow-hidden relative">
    <div class="absolute top-1/2 left-0 w-[1000px] h-[1000px] bg-brandGreen/5 rounded-full blur-[180px] pointer-events-none opacity-40"></div>
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-40 items-center">
            <div>
                <h2 class="text-xs font-black uppercase tracking-[0.6em] text-brandBlue mb-12">Clinical DNA</h2>
                <h3 class="text-6xl md:text-[10rem] font-black tracking-[calc(-0.05em)] leading-[0.75] mb-16 uppercase italic">
                    Precision <br>
                    Is Our <br>
                    Standard.
                </h3>
                <p class="text-2xl text-white/30 leading-relaxed max-w-xl font-medium italic">
                    Universal healthcare requires absolute precision. We deliver deep-level simulations and expert-led curriculum to ensure every BHA Academy graduate is a clinical authority in their field.
                </p>
            </div>
            <div class="relative">
                <div class="aspect-square bg-white/5 rounded-[6rem] border-4 border-white/5 p-16 relative overflow-hidden group shadow-3xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-brandBlue/30 to-brandGreen/30 opacity-0 group-hover:opacity-100 transition-opacity duration-1000 z-10"></div>
                    <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&q=80&w=2070" class="w-full h-full object-cover rounded-[4.5rem] shadow-2xl grayscale group-hover:grayscale-0 transition-all duration-1000 scale-110 group-hover:scale-100" alt="Clinical Environment">
                </div>
                <!-- Floating Card -->
                <div class="absolute -bottom-16 -left-16 bg-background border-4 border-white/5 p-12 rounded-[3.5rem] shadow-3xl backdrop-blur-3xl z-20 hover:-translate-y-2 transition-transform duration-500">
                    <p class="text-[10px] font-black text-brandGreen uppercase tracking-[0.3em] mb-4 italic">Registry Verified</p>
                    <p class="text-2xl font-black italic tracking-tighter">Clinical Intelligence 2.0</p>
                    <p class="text-sm text-white/30 font-bold mt-2 uppercase tracking-widest">Active System Status</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer_public.php'; ?>
