<?php
require_once '../includes/auth.php';
requireLogin();

// Fetch summary
$stmt = $pdo->prepare("SELECT referral_code, balance FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user_data = $stmt->fetch();

// Fetch Referred Users
$stmt = $pdo->prepare("SELECT name, created_at, 
    (SELECT COUNT(*) FROM transactions WHERE user_id = users.id AND status = 'completed') as has_purchased 
    FROM users WHERE referred_by = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$referrals = $stmt->fetchAll();

$pageTitle = "Referral Network";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="max-w-xl">
            <h1 class="text-4xl font-black tracking-tighter mb-4 leading-none uppercase">Propagate Knowledge</h1>
            <p class="text-muted-foreground font-medium">Expand the BHA Academy network and earn clinical credits for every professional you refer.</p>
        </div>
        
        <div class="flex items-center gap-2 bg-muted/30 px-4 py-2 rounded-full border border-dashed">
            <span class="text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Network Status</span>
            <div class="h-2 w-2 rounded-full bg-brandBlue"></div>
            <span class="text-xs font-bold leading-none tracking-tighter uppercase">Growing</span>
        </div>
    </div>

    <!-- Referral Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="bg-card border rounded-[2rem] p-8 shadow-sm flex flex-col justify-center">
            <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mb-1">Total Network</p>
            <h3 class="text-4xl font-black tracking-tighter leading-none"><?php echo count($referrals); ?> <span class="text-sm font-bold text-muted-foreground">PROS</span></h3>
        </div>
        <div class="bg-card border rounded-[2rem] p-8 shadow-sm flex flex-col justify-center">
            <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mb-1">Conversion Rate</p>
            <h3 class="text-4xl font-black tracking-tighter leading-none">
                <?php 
                $converted = count(array_filter($referrals, fn($r) => $r['has_purchased']));
                echo count($referrals) > 0 ? round(($converted / count($referrals)) * 100) : 0; 
                ?>%
            </h3>
        </div>
        <div class="lg:col-span-2 bg-brandBlue text-white border rounded-[2rem] p-8 shadow-xl relative overflow-hidden flex flex-col justify-center">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-3xl"></div>
            <p class="text-[10px] font-black uppercase tracking-widest text-white/50 mb-1">Accumulated Balance</p>
            <h3 class="text-5xl font-black tracking-tighter leading-none italic">£<?php echo number_format($user_data['balance'], 2); ?></h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-8">
            <!-- How to propagate -->
            <div class="bg-card border rounded-[2rem] p-10 relative overflow-hidden">
                <div class="absolute bottom-0 right-0 w-40 h-40 bg-brandBlue/5 rounded-full -mr-20 -mb-20 blur-3xl"></div>
                <h3 class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mb-10 border-b pb-4">Propagation Protocol</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 relative">
                    <div class="space-y-4">
                        <div class="h-12 w-12 bg-primary/10 text-brandBlue rounded-2xl flex items-center justify-center font-black text-xl italic border">01</div>
                        <h4 class="text-sm font-black uppercase tracking-tight">Identity Sharing</h4>
                        <p class="text-[11px] text-muted-foreground leading-relaxed font-medium">Distribute your unique clinical referral code to colleagues.</p>
                    </div>
                    <div class="space-y-4">
                        <div class="h-12 w-12 bg-primary/10 text-brandBlue rounded-2xl flex items-center justify-center font-black text-xl italic border">02</div>
                        <h4 class="text-sm font-black uppercase tracking-tight">Enrolled Success</h4>
                        <p class="text-[11px] text-muted-foreground leading-relaxed font-medium">Your referred peer successfully completes a module or certification.</p>
                    </div>
                    <div class="space-y-4">
                        <div class="h-12 w-12 bg-brandGreen/10 text-brandGreen rounded-2xl flex items-center justify-center font-black text-xl italic border">03</div>
                        <h4 class="text-sm font-black uppercase tracking-tight">Financial Credit</h4>
                        <p class="text-[11px] text-muted-foreground leading-relaxed font-medium">Receive £5.00 instantly credited to your professional wallet.</p>
                    </div>
                </div>
            </div>

            <!-- History -->
            <div class="bg-card border rounded-[2rem] overflow-hidden shadow-sm">
                <div class="px-10 py-6 border-b flex items-center justify-between">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Network Ledger</h4>
                    <span class="text-[10px] font-bold text-muted-foreground italic"><?php echo count($referrals); ?> Active Nodes</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-muted/30">
                            <tr>
                                <th class="px-10 py-4 text-[10px] font-black uppercase tracking-widest text-muted-foreground">Professional Node</th>
                                <th class="px-10 py-4 text-[10px] font-black uppercase tracking-widest text-muted-foreground">Registered</th>
                                <th class="px-10 py-4 text-[10px] font-black uppercase tracking-widest text-muted-foreground text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm">
                            <?php foreach ($referrals as $r): ?>
                                <tr class="hover:bg-muted/10 transition-colors group">
                                    <td class="px-10 py-5 font-black tracking-tight text-foreground group-hover:text-brandBlue transition-colors"><?php echo $r['name']; ?></td>
                                    <td class="px-10 py-5 text-xs font-bold text-muted-foreground"><?php echo date('M d, Y', strtotime($r['created_at'])); ?></td>
                                    <td class="px-10 py-5 text-right">
                                        <?php if ($r['has_purchased']): ?>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-brandGreen/10 text-brandGreen uppercase tracking-widest border border-brandGreen/20">Rewarded</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-muted text-muted-foreground uppercase tracking-widest opacity-40">Dormant</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($referrals)): ?>
                                <tr>
                                    <td colspan="3" class="px-10 py-20 text-center text-muted-foreground italic text-sm font-medium">Your referral network remains localized. Share your code to expand.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Code Card -->
            <div class="bg-background border-2 border-brandBlue rounded-[2.5rem] p-10 shadow-2xl shadow-brandBlue/10 relative overflow-hidden group text-center">
                <div class="absolute inset-0 bg-brandBlue/5 opacity-40"></div>
                <div class="relative">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground mb-4">Propagation Code</p>
                    <h2 class="text-4xl font-black mb-8 tracking-[0.15em] text-foreground font-mono"><?php echo $user_data['referral_code']; ?></h2>
                    <button onclick="navigator.clipboard.writeText('<?php echo $user_data['referral_code']; ?>'); alert('Code Encrypted to Clipboard!');" class="w-full h-14 bg-foreground text-background rounded-2xl font-black text-xs uppercase tracking-widest hover:opacity-90 active:scale-95 transition-all shadow-xl">
                        Copy to Clipboard
                    </button>
                    <p class="text-[9px] font-bold text-muted-foreground mt-6 italic">Verified unique clinical ID</p>
                </div>
            </div>

            <!-- Promotion -->
            <div class="bg-muted/20 border border-dashed rounded-[2rem] p-8">
                <h4 class="text-[10px] font-black uppercase tracking-widest mb-4">Platform Logic</h4>
                <p class="text-[11px] text-muted-foreground leading-relaxed font-medium italic">"Credits earned via referrals are permanent and can be used to subsidize any professional certification within the academy."</p>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
