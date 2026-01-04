<?php
require_once '../includes/auth.php';
requireAdmin();

$message = '';

// Handle Voucher Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_voucher'])) {
    $code = strtoupper($_POST['code']);
    $type = $_POST['type'];
    $value = $_POST['value'];
    $expiry = $_POST['expiry'] ?: null;
    $limit = $_POST['limit'] ?: 1;

    try {
        $stmt = $pdo->prepare("INSERT INTO vouchers (code, discount_type, discount_value, expiry_date, usage_limit) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$code, $type, $value, $expiry, $limit]);
        $message = "Voucher '$code' created successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

$vouchers = $pdo->query("SELECT * FROM vouchers ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Vouchers | BHA Academy Admin</title>
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
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Discount Vouchers</h1>
                <p class="text-gray-500">Create coupons to boost student enrollment.</p>
            </div>
            <button onclick="document.getElementById('vModal').classList.toggle('hidden')" class="bg-brandBlue text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-brandBlue/20 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Voucher
            </button>
        </header>

        <?php if ($message): ?>
            <div class="bg-blue-50 text-brandBlue p-4 rounded-xl mb-8 border border-blue-100 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden text-sm">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-400 font-medium">
                    <tr>
                        <th class="px-6 py-4 uppercase tracking-wider text-[10px]">Voucher Code</th>
                        <th class="px-6 py-4 uppercase tracking-wider text-[10px]">Discount</th>
                        <th class="px-6 py-4 uppercase tracking-wider text-[10px]">Usage</th>
                        <th class="px-6 py-4 uppercase tracking-wider text-[10px]">Expiry</th>
                        <th class="px-6 py-4 uppercase tracking-wider text-[10px] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php foreach ($vouchers as $v): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="bg-gray-100 px-3 py-1.5 rounded-lg font-mono font-bold text-gray-900 border border-gray-200"><?php echo $v['code']; ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900"><?php echo $v['discount_type'] == 'percent' ? $v['discount_value'] . '%' : '£' . $v['discount_value']; ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-900 font-medium"><?php echo $v['used_count']; ?> / <?php echo $v['usage_limit']; ?></span>
                                    <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="bg-brandBlue h-full" style="width: <?php echo ($v['used_count'] / $v['usage_limit']) * 100; ?>%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-400">
                                <?php echo $v['expiry_date'] ?: 'NEVER'; ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-red-500 hover:text-red-700 font-bold">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Add Modal -->
        <div id="vModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
                <div class="p-8 border-b border-gray-50">
                    <h2 class="text-xl font-bold text-gray-900">Create New Voucher</h2>
                </div>
                <form action="vouchers.php" method="POST" class="p-8 space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Voucher Code</label>
                        <input type="text" name="code" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-brandBlue/20 outline-none transition uppercase" placeholder="SAVE20">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Type</label>
                            <select name="type" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-brandBlue/20 outline-none transition">
                                <option value="percent">Percentage (%)</option>
                                <option value="flat">Flat Amount (£)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Value</label>
                            <input type="number" name="value" step="0.01" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-brandBlue/20 outline-none transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Usage Limit</label>
                        <input type="number" name="limit" value="100" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-brandBlue/20 outline-none transition">
                    </div>
                    <button type="submit" name="add_voucher" class="w-full bg-brandBlue text-white py-4 rounded-xl font-bold hover:bg-blue-700 transition">Save Voucher</button>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
