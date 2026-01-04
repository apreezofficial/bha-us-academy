<?php
require_once '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$pageTitle = "My Profile";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-8 max-w-4xl">
    <div>
        <h1 class="text-3xl font-bold tracking-tight mb-1">Account Settings</h1>
        <p class="text-muted-foreground">Manage your professional credentials and clinical profile.</p>
    </div>

    <div class="grid gap-8">
        <!-- Profile Info -->
        <div class="bg-card border rounded-xl p-8 shadow-sm">
            <h3 class="text-lg font-bold mb-6">Personal details</h3>
            <div class="flex items-center gap-6 mb-10">
                <div class="h-24 w-24 rounded-full bg-brandBlue flex items-center justify-center text-white text-3xl font-black">
                    <?php echo substr($user['name'], 0, 1); ?>
                </div>
                <div>
                    <h4 class="text-2xl font-bold leading-none mb-1"><?php echo $user['name']; ?></h4>
                    <p class="text-muted-foreground text-sm"><?php echo $user['email']; ?></p>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-muted-foreground mb-2 ml-1">Full Name</label>
                    <input type="text" disabled value="<?php echo $user['name']; ?>" class="w-full bg-muted border rounded-lg px-4 py-2 text-sm text-foreground/50 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-muted-foreground mb-2 ml-1">Email Address</label>
                    <input type="email" disabled value="<?php echo $user['email']; ?>" class="w-full bg-muted border rounded-lg px-4 py-2 text-sm text-foreground/50 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-muted-foreground mb-2 ml-1">Academy Member ID</label>
                    <input type="text" disabled value="#BHA-<?php echo 1000 + $user['id']; ?>" class="w-full bg-muted border rounded-lg px-4 py-2 text-sm text-foreground/50 cursor-not-allowed font-mono">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-muted-foreground mb-2 ml-1">Membership Date</label>
                    <input type="text" disabled value="<?php echo date('d M Y', strtotime($user['created_at'])); ?>" class="w-full bg-muted border rounded-lg px-4 py-2 text-sm text-foreground/50 cursor-not-allowed">
                </div>
            </div>
        </div>

        <!-- Security -->
        <div class="bg-card border rounded-xl p-8 shadow-sm">
            <h3 class="text-lg font-bold mb-6 text-destructive">Security & Risk</h3>
            <div class="space-y-4">
                <button class="flex items-center gap-2 text-sm font-semibold hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground leading-none"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    Change Account Password
                </button>
                <div class="h-px bg-border"></div>
                <button class="text-destructive text-sm font-semibold hover:underline flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="leading-none"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                    Request Account Deletion
                </button>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
