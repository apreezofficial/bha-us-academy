<?php
// includes/footer_public.php
?>
    </main>

    <footer class="relative z-10 border-t border-white/5 bg-darkBg/80 backdrop-blur-md pt-24 pb-12 mt-32">
        <div class="max-w-[1600px] mx-auto px-6 sm:px-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-16 mb-20">
                <div class="col-span-1 md:col-span-2">
                    <a href="index.php" class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 bg-gradient-to-br from-brandBlue to-brandGreen rounded-2xl flex items-center justify-center shadow-2xl">
                            <span class="text-white font-black text-2xl">B</span>
                        </div>
                        <span class="text-2xl font-bold tracking-tighter uppercase">Brilliance <span class="text-brandBlue">Healthcare</span></span>
                    </a>
                    <p class="text-white/40 text-lg leading-relaxed max-w-md">
                        Pioneering the future of UK healthcare education through AI-driven clinical modules and gold-standard CPD accreditation.
                    </p>
                </div>
                <div>
                    <h5 class="text-sm font-bold uppercase tracking-[0.2em] text-white/30 mb-8">Navigation</h5>
                    <ul class="space-y-4">
                        <li><a href="about.php" class="text-white/60 hover:text-brandGreen transition-colors">Our Mission</a></li>
                        <li><a href="for-teams.php" class="text-white/60 hover:text-brandGreen transition-colors">Corporate Training</a></li>
                        <li><a href="certificates-info.php" class="text-white/60 hover:text-brandGreen transition-colors">Accreditation</a></li>
                        <li><a href="contact.php" class="text-white/60 hover:text-brandGreen transition-colors">Contact Support</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-sm font-bold uppercase tracking-[0.2em] text-white/30 mb-8">Social Connect</h5>
                    <div class="flex gap-4">
                        <a href="#" class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-brandBlue/20 hover:border-brandBlue/50 transition-all text-white/40 hover:text-white focus:outline-none">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-brandBlue/20 hover:border-brandBlue/50 transition-all text-white/40 hover:text-white focus:outline-none">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/5 pt-12 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-white/20 text-sm font-medium">
                    &copy; <?php echo date('Y'); ?> Brilliance Healthcare Academy. All rights reserved.
                </p>
                <div class="flex gap-8">
                    <a href="#" class="text-xs font-bold text-white/20 hover:text-white transition-colors uppercase tracking-widest">Privacy</a>
                    <a href="#" class="text-xs font-bold text-white/20 hover:text-white transition-colors uppercase tracking-widest">Terms</a>
                    <a href="#" class="text-xs font-bold text-white/20 hover:text-white transition-colors uppercase tracking-widest">CPD Policy</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
