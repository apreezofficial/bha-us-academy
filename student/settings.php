<?php
require_once '../includes/auth.php';
requireLogin();

$pageTitle = "Settings";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-8 max-w-4xl">
    <div>
        <h1 class="text-3xl font-bold tracking-tight mb-1">Platform Settings</h1>
        <p class="text-muted-foreground">Customize your clinical learning environment.</p>
    </div>

    <div class="grid gap-8">
        <div class="bg-card border rounded-xl p-8 shadow-sm">
            <h3 class="text-lg font-bold mb-6">Appearance</h3>
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="border rounded-lg p-4 cursor-pointer hover:border-brandBlue transition-colors border-2 border-brandBlue bg-muted/20">
                    <div class="h-12 bg-zinc-900 rounded mb-3 flex items-center justify-center">
                        <span class="text-[10px] font-bold text-white uppercase tracking-tighter">Dark Mode</span>
                    </div>
                    <p class="text-xs font-bold text-center">Always Dark (Default)</p>
                </div>
                <div class="border rounded-lg p-4 cursor-not-allowed opacity-50 grayscale transition-colors">
                    <div class="h-12 bg-white border rounded mb-3 flex items-center justify-center">
                        <span class="text-[10px] font-bold text-black uppercase tracking-tighter">Light Mode</span>
                    </div>
                    <p class="text-xs font-bold text-center">Light Mode (Coming Soon)</p>
                </div>
            </div>
        </div>

        <div class="bg-card border rounded-xl p-8 shadow-sm opacity-50 grayscale">
            <h3 class="text-lg font-bold mb-6">Notifications</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold">Email Alerts</p>
                        <p class="text-[10px] text-muted-foreground italic">Course completion and certificate issuance.</p>
                    </div>
                    <div class="h-6 w-10 bg-brandBlue rounded-full p-1">
                        <div class="h-4 w-4 bg-white rounded-full ml-auto"></div>
                    </div>
                </div>
                <div class="h-px bg-border"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold">Marketing & Offers</p>
                        <p class="text-[10px] text-muted-foreground italic">New module releases and discount vouchers.</p>
                    </div>
                    <div class="h-6 w-10 bg-muted rounded-full p-1">
                        <div class="h-4 w-4 bg-white rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
