<?php
require_once '../includes/auth.php';
requireLogin();

$pageTitle = "Settings";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="max-w-xl">
            <h1 class="text-4xl font-black tracking-tighter mb-4 leading-none uppercase">Platform Console</h1>
            <p class="text-muted-foreground font-medium">Personalize your professional clinical environment and notification preferences.</p>
        </div>
        
        <div class="flex items-center gap-2 bg-muted/30 px-4 py-2 rounded-full border border-dashed">
            <span class="text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Version</span>
            <span class="text-xs font-bold leading-none tracking-tighter uppercase">Alpha 2.0.4</span>
        </div>
    </div>

    <!-- Settings Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Appearance Section -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-card border rounded-[2rem] p-8 shadow-sm">
                <div class="flex items-center gap-4 mb-10 border-b pb-6">
                    <div class="h-10 w-10 bg-brandBlue/10 text-brandBlue rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="M20 12h2"></path><path d="m19.07 19.07 1.41 1.41"></path><path d="M12 20v2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="M2 12h2"></path><path d="m7.76 7.76-1.41-1.41"></path><circle cx="12" cy="12" r="4"></circle></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold leading-none">Aesthetic Preferences</h3>
                        <p class="text-[11px] text-muted-foreground font-medium mt-1">Choose a visual interface that optimizes your focus.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Light Mode Wrapper -->
                    <div id="theme-light" onclick="setTheme('light')" class="theme-option group cursor-pointer border-2 border-muted bg-muted/10 rounded-[1.5rem] p-6 transition-all hover:border-brandBlue/40 selected:border-brandBlue selected:bg-brandBlue/5">
                        <div class="aspect-[16/10] bg-white border border-gray-200 rounded-xl mb-4 relative overflow-hidden shadow-inner flex items-center justify-center">
                            <span class="text-[10px] font-bold text-black opacity-40 uppercase tracking-widest">Day Mode</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold">White Theme</span>
                            <div class="h-4 w-4 rounded-full border-2 border-muted flex items-center justify-center checked:border-brandBlue">
                                <div class="h-2 w-2 rounded-full bg-brandBlue hidden check-dot"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Dark Mode Wrapper -->
                    <div id="theme-dark" onclick="setTheme('dark')" class="theme-option group cursor-pointer border-2 border-muted bg-muted/10 rounded-[1.5rem] p-6 transition-all hover:border-brandBlue/40 selected:border-brandBlue selected:bg-brandBlue/5">
                        <div class="aspect-[16/10] bg-slate-950 border border-slate-900 rounded-xl mb-4 relative overflow-hidden shadow-inner flex items-center justify-center">
                            <span class="text-[10px] font-bold text-white opacity-40 uppercase tracking-widest">Night Mode</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold">Onyx Dark</span>
                            <div class="h-4 w-4 rounded-full border-2 border-muted flex items-center justify-center checked:border-brandBlue">
                                <div class="h-2 w-2 rounded-full bg-brandBlue hidden check-dot"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="bg-card border rounded-[2rem] p-8 shadow-sm opacity-60 grayscale cursor-not-allowed">
                <div class="flex items-center gap-4 mb-8">
                    <div class="h-10 w-10 bg-brandGreen/10 text-brandGreen rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold leading-none">Dispatch Logic</h3>
                        <p class="text-[11px] text-muted-foreground font-medium mt-1">Configure how the platform communicates vital updates.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-muted/5">
                        <div class="min-w-0">
                            <p class="text-sm font-bold">Email Attestations</p>
                            <p class="text-[10px] text-muted-foreground font-medium italic">Instant alerts for certifications and grade reports.</p>
                        </div>
                        <div class="h-6 w-10 bg-brandBlue rounded-full p-1 shadow-inner flex items-center">
                            <div class="h-4 w-4 bg-white rounded-full ml-auto"></div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-muted/5">
                        <div class="min-w-0">
                            <p class="text-sm font-bold">Research Updates</p>
                            <p class="text-[10px] text-muted-foreground font-medium italic">Notifications for new module releases and clinical updates.</p>
                        </div>
                        <div class="h-6 w-10 bg-muted/50 rounded-full p-1 shadow-inner flex items-center">
                            <div class="h-4 w-4 bg-white/50 rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="bg-brandBlue text-white p-8 rounded-[2rem] shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-3xl"></div>
                <h4 class="text-sm font-black uppercase tracking-widest mb-4 opacity-70 italic">Synchronous Settings</h4>
                <p class="text-xs font-bold leading-relaxed mb-6">Your preferences are saved locally to ensure immediate application upon re-entry. These settings optimize clinical focus and reduce eye strain during intensive modules.</p>
                <div class="pt-6 border-t border-white/20">
                    <div class="flex items-center gap-2">
                        <div class="h-1.5 w-1.5 rounded-full bg-white opacity-50"></div>
                        <span class="text-[9px] font-black uppercase tracking-widest">Active Link Established</span>
                    </div>
                </div>
            </div>

            <div class="bg-card border border-dashed rounded-[2rem] p-6 text-center">
                <p class="text-[10px] font-bold text-muted-foreground uppercase mb-1">Last Configured</p>
                <p class="text-xs font-black"><?php echo date('M d, Y @ H:i'); ?></p>
            </div>
        </div>
    </div>
</div>

<script>
    function setTheme(theme) {
        localStorage.setItem('theme', theme);
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        updateUI();
    }

    function updateUI() {
        const theme = localStorage.getItem('theme') || 'dark';
        document.querySelectorAll('.theme-option').forEach(opt => {
            opt.classList.remove('border-brandBlue', 'bg-brandBlue/5');
            opt.classList.add('border-muted', 'bg-muted/10');
            opt.querySelector('.check-dot').classList.add('hidden');
        });

        const selected = document.getElementById('theme-' + theme);
        if (selected) {
            selected.classList.add('border-brandBlue', 'bg-brandBlue/5');
            selected.classList.remove('border-muted', 'bg-muted/10');
            selected.querySelector('.check-dot').classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', updateUI);
</script>

<style>
/* Custom utility for theme selection script */
.theme-option.selected {
    border-color: #0056b3 !important;
    background-color: rgba(0, 86, 179, 0.05) !important;
}
</style>

<?php include '../includes/footer_student.php'; ?>
