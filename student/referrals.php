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

$pageTitle = "Referrals";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight mb-1">Referral Program</h1>
            <p class="text-muted-foreground">Earn rewards by inviting other healthcare professionals to join our academy.</p>
        </div>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-8">
            <!-- Information Card -->
            <div class="bg-card border rounded-xl p-8 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-brandBlue/5 rounded-bl-full group-hover:scale-110 transition-transform"></div>
                <h3 class="text-xl font-bold mb-6">How it works</h3>
                <div class="grid gap-6 sm:grid-cols-3">
                    <div class="space-y-3">
                        <div class="w-8 h-8 bg-primary/10 text-brandBlue rounded-full flex items-center justify-center text-xs font-bold">1</div>
                        <p class="font-bold text-sm">Share Code</p>
                        <p class="text-[11px] text-muted-foreground leading-relaxed">Invite your colleagues to join with your unique ID.</p>
                    </div>
                    <div class="space-y-3">
                        <div class="w-8 h-8 bg-primary/10 text-brandBlue rounded-full flex items-center justify-center text-xs font-bold">2</div>
                        <p class="font-bold text-sm">They Learn</p>
                        <p class="text-[11px] text-muted-foreground leading-relaxed">They sign up and complete their first certification.</p>
                    </div>
                    <div class="space-y-3">
                        <div class="w-8 h-8 bg-brandGreen/10 text-brandGreen rounded-full flex items-center justify-center text-xs font-bold">3</div>
                        <p class="font-bold text-sm">Earn Credits</p>
                        <p class="text-[11px] text-muted-foreground leading-relaxed">You receive £5 credit to your account balance.</p>
                    </div>
                </div>
            </div>

            <!-- Referrals Table -->
            <div class="bg-card border rounded-xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b">
                    <h4 class="font-bold text-sm uppercase tracking-wider text-muted-foreground">Referral History</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-muted/50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Professional</th>
                                <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Joined</th>
                                <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-muted-foreground text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <?php foreach ($referrals as $r): ?>
                                <tr class="hover:bg-muted/30 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-sm"><?php echo $r['name']; ?></td>
                                    <td class="px-6 py-4 text-xs text-muted-foreground"><?php echo date('d M Y', strtotime($r['created_at'])); ?></td>
                                    <td class="px-6 py-4 text-right">
                                        <?php if ($r['has_purchased']): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-brandGreen/10 text-brandGreen uppercase tracking-wider">Rewarded</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-muted text-muted-foreground uppercase tracking-wider">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($referrals)): ?>
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-muted-foreground italic text-sm">You haven't referred anyone yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Referral Code Card -->
            <div class="bg-primary text-primary-foreground p-8 rounded-xl shadow-lg relative overflow-hidden group text-center">
                <div class="absolute inset-0 bg-brandBlue/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/50 mb-3">Your Unique Link Code</p>
                <h2 class="text-3xl font-black mb-6 tracking-[0.15em]"><?php echo $user_data['referral_code']; ?></h2>
                <button onclick="navigator.clipboard.writeText('<?php echo $user_data['referral_code']; ?>')" class="w-full bg-white text-black py-4 rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-white/90 transition-colors">
                    Copy Code
                </button>
            </div>

            <!-- Earnings Card -->
            <div class="bg-card border rounded-xl p-8 shadow-sm">
                <p class="text-[10px] font-bold uppercase tracking-widest text-muted-foreground mb-1">Total Rewards Earned</p>
                <h3 class="text-4xl font-extrabold tracking-tight mb-4">£<?php echo number_format($user_data['balance'], 2); ?></h3>
                <p class="text-[11px] text-muted-foreground leading-relaxed">This balance is automatically applied as a discount on your next certificate or module purchase.</p>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
