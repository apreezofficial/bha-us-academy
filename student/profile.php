<?php
require_once '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$pageTitle = "Account Console";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-10 max-w-5xl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="max-w-xl">
            <h1 class="text-4xl font-black tracking-tighter mb-4 leading-none uppercase">Professional Identity</h1>
            <p class="text-muted-foreground font-medium">Manage your clinical credentials, security protocols, and platform profile.</p>
        </div>
        
        <div class="flex items-center gap-2 bg-muted/30 px-4 py-2 rounded-full border border-dashed">
            <span class="text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Encryption</span>
            <div class="h-2 w-2 rounded-full bg-brandGreen"></div>
            <span class="text-xs font-bold leading-none tracking-tighter uppercase">Standard Secure</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Main Form Area -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-card border rounded-[2rem] p-10 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-40 h-40 bg-brandBlue/5 rounded-full -mr-20 -mt-20 blur-3xl"></div>
                
                <h3 class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mb-10 border-b pb-4">Clinical Registry Data</h3>
                
                <div class="flex flex-col sm:flex-row items-center gap-8 mb-12">
                    <div class="relative group">
                        <div class="h-24 w-24 rounded-3xl bg-brandBlue text-white flex items-center justify-center text-4xl font-black shadow-2xl shadow-brandBlue/20 transform group-hover:scale-105 transition-transform">
                            <?php echo substr($user['name'], 0, 1); ?>
                        </div>
                        <button class="absolute -bottom-2 -right-2 h-8 w-8 bg-card border rounded-xl flex items-center justify-center shadow-lg hover:text-brandBlue transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black tracking-tight leading-none mb-2"><?php echo $user['name']; ?></h2>
                        <p class="text-xs font-bold text-muted-foreground uppercase tracking-widest bg-muted px-3 py-1 rounded-full inline-block">Academy ID: #BHA-<?php echo 1000 + $user['id']; ?></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-muted-foreground ml-1">Full Name</label>
                        <div class="h-12 bg-muted/30 border rounded-xl px-4 flex items-center text-sm font-bold opacity-60 pointer-events-none"><?php echo $user['name']; ?></div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-muted-foreground ml-1">Primary Email</label>
                        <div class="h-12 bg-muted/30 border rounded-xl px-4 flex items-center text-sm font-bold opacity-60 pointer-events-none"><?php echo $user['email']; ?></div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-muted-foreground ml-1">Member Since</label>
                        <div class="h-12 bg-muted/30 border rounded-xl px-4 flex items-center text-sm font-bold opacity-60 pointer-events-none"><?php echo date('F d, Y', strtotime($user['created_at'])); ?></div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-muted-foreground ml-1">Clinical Specialization</label>
                        <div class="h-12 bg-muted/30 border rounded-xl px-4 flex items-center text-sm font-bold opacity-60 pointer-events-none italic text-muted-foreground">Unspecified</div>
                    </div>
                </div>
            </div>

            <!-- Risk Management -->
            <div class="bg-card border rounded-[2rem] p-8 shadow-sm">
                <h3 class="text-[10px] font-black uppercase tracking-widest text-destructive mb-6 flex items-center gap-3">
                    <div class="h-1.5 w-1.5 rounded-full bg-destructive animate-pulse"></div>
                    Critical Safeguards
                </h3>
                <div class="grid gap-4">
                    <button class="flex items-center justify-between p-4 rounded-2xl bg-muted/10 hover:bg-muted/20 transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 bg-background border rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-bold">Credential Authentication</p>
                                <p class="text-[10px] text-muted-foreground font-medium italic">Update your primary account password.</p>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground group-hover:translate-x-1 transition-transform"><path d="m9 18 6-6-6-6"></path></svg>
                    </button>

                    <button class="flex items-center justify-between p-4 rounded-2xl bg-destructive/5 hover:bg-destructive/10 transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 bg-destructive/10 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-destructive"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-bold text-destructive">Termination Protocol</p>
                                <p class="text-[10px] text-destructive/50 font-medium italic">Permanently erase your clinical records.</p>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-destructive/40 group-hover:translate-x-1 transition-transform"><path d="m9 18 6-6-6-6"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Meta -->
        <div class="space-y-6">
            <div class="bg-foreground text-background p-8 rounded-[2rem] shadow-xl relative overflow-hidden">
                <div class="absolute inset-0 bg-brandBlue/10 opacity-50"></div>
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] mb-4 opacity-50">Access Status</h4>
                <div class="space-y-4 relative">
                    <div class="flex justify-between items-center">
                        <span class="text-[11px] font-bold">2FA Security</span>
                        <span class="text-[9px] font-black px-2 py-0.5 bg-destructive rounded text-white">Disabled</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[11px] font-bold">Verified Status</span>
                        <span class="text-[9px] font-black px-2 py-0.5 bg-brandGreen rounded text-white italic tracking-tighter">Approved</span>
                    </div>
                    <div class="pt-4 border-t border-background/20">
                        <p class="text-[10px] font-medium leading-relaxed opacity-60 italic">"Security is a shared clinical responsibility. Ensure your credentials are never shared."</p>
                    </div>
                </div>
            </div>

            <div class="bg-card border border-dashed rounded-[2rem] p-6 text-center">
                <p class="text-[10px] font-bold text-muted-foreground uppercase mb-1">System Load</p>
                <div class="flex items-center justify-center gap-1.5">
                    <div class="h-1.5 w-10 bg-brandGreen rounded-full"></div>
                    <div class="h-1.5 w-10 bg-brandGreen/20 rounded-full"></div>
                    <div class="h-1.5 w-10 bg-brandGreen/20 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
