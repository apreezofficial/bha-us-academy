<?php
require_once 'includes/config.php';
$pageTitle = "Contact Us — BHA Academy";
include 'includes/header_public.php';
?>

<!-- Hero Section -->
<section class="relative min-h-[70vh] flex items-center pt-40 pb-20 overflow-hidden">
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10 relative z-10 w-full">
        <h2 class="text-xs font-bold uppercase tracking-[0.4em] text-brandBlue mb-12">Support Network</h2>
        <h1 class="text-6xl md:text-9xl font-black leading-[0.9] tracking-tighter mb-16">
            Get In <br>
            <span class="text-gradient">Touch.</span>
        </h1>
        <p class="text-3xl text-white/40 max-w-3xl leading-relaxed font-light">
            Have questions about a course or corporate training? Our clinical support team is here to <span class="text-white">assist you 24/7</span>.
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-32 relative">
    <div class="max-w-[1600px] mx-auto px-6 sm:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-32">
            <div>
                <form action="process_contact.php" method="POST" class="space-y-8">
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-white/30 mb-4">Full Name</label>
                            <input type="text" name="name" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-brandBlue outline-none transition-all" placeholder="Enter name...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-white/30 mb-4">Email Address</label>
                            <input type="email" name="email" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-brandBlue outline-none transition-all" placeholder="Enter email...">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-white/30 mb-4">Inquiry Type</label>
                        <select name="type" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-brandBlue outline-none transition-all appearance-none cursor-pointer">
                            <option value="general" class="bg-darkBg">General Inquiry</option>
                            <option value="corporate" class="bg-darkBg">Corporate Training</option>
                            <option value="support" class="bg-darkBg">Student Support</option>
                            <option value="billing" class="bg-darkBg">Billing & Payments</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-white/30 mb-4">Your Message</label>
                        <textarea name="message" required rows="6" class="w-full bg-white/5 border border-white/10 rounded-3xl px-6 py-6 text-white focus:border-brandBlue outline-none transition-all resize-none" placeholder="How can we help?"></textarea>
                    </div>
                    <button type="submit" class="w-full py-6 rounded-full bg-gradient-to-r from-brandBlue to-brandGreen text-white font-bold text-xl hover:shadow-[0_0_40px_-10px_#0056b3] transition-all">
                        Send Clinical Inquiry
                    </button>
                </form>
            </div>
            
            <div class="space-y-16">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-[0.4em] text-white/20 mb-8">Registered Office</h4>
                    <p class="text-2xl font-bold leading-relaxed">
                        128 City Road,<br>
                        London, EC1V 2NX<br>
                        United Kingdom
                    </p>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-[0.4em] text-white/20 mb-8">Fast Response</h4>
                    <p class="text-2xl font-bold text-brandGreen">support@bhaacademy.co.uk</p>
                    <p class="text-xl text-white/40 mt-2">Expected response time: <span class="text-white">2 hours</span></p>
                </div>
                <div class="p-10 border border-white/5 rounded-[3rem] bg-white/2">
                    <p class="text-white/40 font-light italic leading-relaxed">
                        "The support at BHA is unmatched. I had an issue with my exam access and it was resolved in less than 30 minutes on a Sunday."
                    </p>
                    <p class="text-sm font-bold mt-6">— Emma Richards, Senior Lead Nurse</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer_public.php'; ?>
