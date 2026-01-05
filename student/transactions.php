<?php
require_once '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];

// Fetch Transactions
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$transactions = $stmt->fetchAll();

$pageTitle = "Financial Console";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 text-foreground">
        <div class="max-w-xl">
            <h1 class="text-4xl font-black tracking-tighter mb-4 leading-none uppercase">Clinical Investments</h1>
            <p class="text-muted-foreground font-medium">Verify your professional expenditures and download receipts for certification and modules.</p>
        </div>
        
        <div class="flex items-center gap-2 bg-muted/30 px-4 py-2 rounded-full border border-dashed">
            <span class="text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Status</span>
            <div class="h-2 w-2 rounded-full bg-brandGreen"></div>
            <span class="text-xs font-bold leading-none tracking-tighter uppercase">Clear Balance</span>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-card border rounded-[2rem] p-8 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mb-1">Total Expended</p>
            <h3 class="text-4xl font-black tracking-tighter leading-none italic">
                £<?php 
                $total = array_sum(array_column($transactions, 'amount'));
                echo number_format($total, 2); 
                ?>
            </h3>
        </div>
        <div class="bg-card border rounded-[2rem] p-8 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mb-1">Receipts Issued</p>
            <h3 class="text-4xl font-black tracking-tighter leading-none"><?php echo count($transactions); ?></h3>
        </div>
        <div class="bg-card border rounded-[2rem] p-8 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mb-1">Default Method</p>
            <h3 class="text-2xl font-black tracking-tighter leading-none uppercase text-brandBlue">Stripe Secure</h3>
        </div>
    </div>

    <div class="bg-card border rounded-[2rem] overflow-hidden shadow-sm">
        <div class="px-10 py-6 border-b flex items-center justify-between">
            <h4 class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Professional Ledger</h4>
            <div class="flex gap-2">
                <div class="h-2 w-2 rounded-full bg-muted"></div>
                <div class="h-2 w-2 rounded-full bg-muted"></div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-muted/30">
                    <tr>
                        <th class="px-10 py-4 text-[10px] font-black uppercase tracking-widest text-muted-foreground">Clinical Asset</th>
                        <th class="px-10 py-4 text-[10px] font-black uppercase tracking-widest text-muted-foreground">Reference</th>
                        <th class="px-10 py-4 text-[10px] font-black uppercase tracking-widest text-muted-foreground text-center">Protocol</th>
                        <th class="px-10 py-4 text-[10px] font-black uppercase tracking-widest text-muted-foreground text-center">State</th>
                        <th class="px-10 py-4 text-[10px] font-black uppercase tracking-widest text-muted-foreground text-right">Value</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-sm">
                    <?php foreach ($transactions as $tx): ?>
                        <tr class="hover:bg-muted/10 transition-colors group">
                            <td class="px-10 py-5">
                                <span class="font-black tracking-tight block leading-none mb-1 text-foreground group-hover:text-brandBlue transition-colors"><?php echo ucfirst($tx['item_type']); ?> Accreditation</span>
                                <span class="text-[9px] font-bold text-muted-foreground uppercase tracking-tighter"><?php echo date('M d, Y @ H:i', strtotime($tx['created_at'])); ?></span>
                            </td>
                            <td class="px-10 py-5 font-mono text-[10px] font-bold text-muted-foreground">#TX-<?php echo str_pad($tx['id'], 6, '0', STR_PAD_LEFT); ?></td>
                            <td class="px-10 py-5 text-center">
                                <span class="text-[9px] font-black uppercase tracking-widest bg-muted px-2 py-1 rounded border"><?php echo $tx['payment_method']; ?></span>
                            </td>
                            <td class="px-10 py-5 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-black bg-brandGreen/10 text-brandGreen uppercase tracking-widest border border-brandGreen/20">
                                    <div class="h-1 w-1 rounded-full bg-brandGreen"></div>
                                    Cleared
                                </span>
                            </td>
                            <td class="px-10 py-5 text-right font-black text-base italic">£<?php echo number_format($tx['amount'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($transactions)): ?>
                        <tr>
                            <td colspan="5" class="px-10 py-20 text-center text-muted-foreground italic font-medium">No recorded transactions found in the clinical registry.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="bg-muted/20 border border-dashed rounded-[2rem] p-8 text-center">
        <p class="text-[11px] text-muted-foreground leading-relaxed font-medium italic">"All fees are inclusive of standard UK VAT where applicable. Digital receipts are cryptographically signed for professional verification."</p>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
