<?php
require_once '../includes/auth.php';
requireLogin();

$pageTitle = "Support";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-8 max-w-4xl">
    <div>
        <h1 class="text-3xl font-bold tracking-tight mb-1">Help & Support</h1>
        <p class="text-muted-foreground">Find answers or connect with our support team during UK business hours.</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <a href="mailto:support@bha-academy.co.uk" class="bg-card border rounded-xl p-8 shadow-sm flex flex-col gap-4 group hover:border-brandBlue transition-colors">
            <div class="w-10 h-10 bg-primary/5 text-brandBlue rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
            </div>
            <div>
                <h4 class="font-bold mb-1">Email Support</h4>
                <p class="text-xs text-muted-foreground">Responds within 24 business hours.</p>
            </div>
        </a>
        <div class="bg-card border rounded-xl p-8 shadow-sm flex flex-col gap-4">
            <div class="w-10 h-10 bg-primary/5 text-brandGreen rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold mb-1">Phone Line</h4>
                <p class="text-xs text-muted-foreground">+44 (0) 123 456 7890 (Mon-Fri)</p>
            </div>
        </div>
    </div>

    <div class="bg-card border rounded-xl p-8 shadow-sm">
        <h3 class="text-lg font-bold mb-6">Frequently Asked Questions</h3>
        <div class="space-y-6">
            <div>
                <h5 class="font-bold text-sm mb-2 leading-none">How do I download my certificate?</h5>
                <p class="text-xs text-muted-foreground leading-relaxed">Once you pass a module exam, navigate to the Certificates page where a download link will be available instantly.</p>
            </div>
            <div class="h-px bg-border"></div>
            <div>
                <h5 class="font-bold text-sm mb-2 leading-none">Is BHA Academy CPD accredited?</h5>
                <p class="text-xs text-muted-foreground leading-relaxed">Yes, all our courses are mapped to standard UK healthcare frameworks and contribute towards your CPD portfolio.</p>
            </div>
            <div class="h-px bg-border"></div>
            <div>
                <h5 class="font-bold text-sm mb-2 leading-none">Can I use my referral balance for multiple purchases?</h5>
                <p class="text-xs text-muted-foreground leading-relaxed">Absolutely. Your referral balance remains active until fully utilized as discounts on module or certificate payments.</p>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
