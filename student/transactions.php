<?php
require_once '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];

// Fetch Transactions
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$transactions = $stmt->fetchAll();

$pageTitle = "Billing";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight mb-1">Billing & Transactions</h1>
            <p class="text-muted-foreground">Manage your clinical training investments and certificate receipts.</p>
        </div>
    </div>

    <div class="bg-card border rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b">
            <h4 class="font-bold text-sm uppercase tracking-wider text-muted-foreground">Transaction History</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left font-medium">
                <thead class="bg-muted/50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Item</th>
                        <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Reference</th>
                        <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-muted-foreground text-center">Method</th>
                        <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-muted-foreground text-center">Status</th>
                        <th class="px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-muted-foreground text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-sm">
                    <?php foreach ($transactions as $tx): ?>
                        <tr class="hover:bg-muted/30 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-semibold block leading-none mb-1 text-foreground"><?php echo ucfirst($tx['item_type']); ?> Certification</span>
                                <span class="text-[10px] text-muted-foreground uppercase"><?php echo date('d M Y, H:i', strtotime($tx['created_at'])); ?></span>
                            </td>
                            <td class="px-6 py-4 text-xs font-mono text-muted-foreground">TX-<?php echo str_pad($tx['id'], 6, '0', STR_PAD_LEFT); ?></td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs uppercase bg-muted px-2 py-0.5 rounded"><?php echo $tx['payment_method']; ?></span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-brandGreen/10 text-brandGreen uppercase tracking-wider">Completed</span>
                            </td>
                            <td class="px-6 py-4 text-right font-bold">£<?php echo number_format($tx['amount'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($transactions)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-muted-foreground italic">No transactions recorded.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
