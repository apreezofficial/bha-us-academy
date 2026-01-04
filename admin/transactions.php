<?php
require_once '../includes/auth.php';
requireAdmin();

$stmt = $pdo->query("SELECT t.*, u.name as user_name 
    FROM transactions t 
    JOIN users u ON t.user_id = u.id 
    ORDER BY t.created_at DESC");
$transactions = $stmt->fetchAll();

$total_revenue = $pdo->query("SELECT SUM(amount) FROM transactions WHERE status = 'completed'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Overview | BHA Academy Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandBlue: '#0056b3',
                        brandGreen: '#28a745',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8FAFC] flex min-h-screen text-sm">

    <?php include '../includes/sidebar.php'; ?>

    <main class="flex-grow p-8">
        <header class="mb-12">
            <h1 class="text-3xl font-bold text-gray-900 leading-none mb-3">Revenue & Transactions</h1>
            <p class="text-gray-500">Track all certificates and module payments across the platform.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Total Revenue</p>
                <h3 class="text-4xl font-extrabold text-brandBlue">£<?php echo number_format($total_revenue, 2); ?></h3>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Total Transactions</p>
                <h3 class="text-4xl font-extrabold text-gray-900"><?php echo count($transactions); ?></h3>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Avg. Transaction</p>
                <h3 class="text-4xl font-extrabold text-brandGreen">£<?php echo count($transactions) > 0 ? number_format($total_revenue / count($transactions), 2) : '0.00'; ?></h3>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-400 font-medium">
                    <tr>
                        <th class="px-8 py-5 uppercase tracking-wider text-[10px]">Reference</th>
                        <th class="px-8 py-5 uppercase tracking-wider text-[10px]">Student</th>
                        <th class="px-8 py-5 uppercase tracking-wider text-[10px]">Amount</th>
                        <th class="px-8 py-5 uppercase tracking-wider text-[10px]">Date</th>
                        <th class="px-8 py-5 uppercase tracking-wider text-[10px]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php foreach ($transactions as $t): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-8 py-5 text-gray-500 font-mono">#TX-<?php echo str_pad($t['id'], 6, '0', STR_PAD_LEFT); ?></td>
                            <td class="px-8 py-5">
                                <span class="font-bold text-gray-900"><?php echo $t['user_name']; ?></span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="font-extrabold text-gray-900">£<?php echo number_format($t['amount'], 2); ?></span>
                            </td>
                            <td class="px-8 py-5 text-gray-400"><?php echo date('d M Y, H:i', strtotime($t['created_at'])); ?></td>
                            <td class="px-8 py-5">
                                <span class="bg-green-50 text-brandGreen px-3 py-1 rounded-full text-[10px] font-bold uppercase">Completed</span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
