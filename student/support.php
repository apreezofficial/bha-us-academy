<?php
require_once '../includes/auth.php';
requireLogin();

$pageTitle = "Support Hub";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-10 max-w-5xl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="max-w-xl">
            <h1 class="text-4xl font-black tracking-tighter mb-4 leading-none uppercase">Clinical Assistance</h1>
            <p class="text-muted-foreground font-medium">Access our knowledge base or connect with professional support during UK standard business hours.</p>
        </div>
        
        <div class="flex items-center gap-2 bg-muted/30 px-4 py-2 rounded-full border border-dashed">
            <span class="text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Response State</span>
            <div class="h-2 w-2 rounded-full bg-brandGreen"></div>
            <span class="text-xs font-bold leading-none tracking-tighter uppercase">Optimal</span>
        </div>
    </div>

    <!-- Contact Channels -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <a href="mailto:support@bha-academy.co.uk" class="bg-card border rounded-[2rem] p-10 shadow-sm flex flex-col gap-6 group hover:border-brandBlue transition-all hover:-translate-y-1">
            <div class="w-14 h-14 bg-brandBlue/10 text-brandBlue rounded-[1.2rem] flex items-center justify-center shrink-0 border border-brandBlue/20 group-hover:bg-brandBlue group-hover:text-white transition-colors duration-500 shadow-lg shadow-brandBlue/5">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
            </div>
            <div>
                <h4 class="text-xl font-black tracking-tight mb-2">Electronic Correspondence</h4>
                <p class="text-xs text-muted-foreground font-medium leading-relaxed italic uppercase tracking-wider">support@bha-academy.co.uk</p>
                <p class="text-[11px] text-muted-foreground mt-4 font-bold border-t pt-4">24H PRIORITY RESPONSE FOR ACCREDITED LEARNERS</p>
            </div>
        </a>

        <div class="bg-card border rounded-[2rem] p-10 shadow-sm flex flex-col gap-6 group hover:border-brandGreen transition-all hover:-translate-y-1">
            <div class="w-14 h-14 bg-brandGreen/10 text-brandGreen rounded-[1.2rem] flex items-center justify-center shrink-0 border border-brandGreen/20 group-hover:bg-brandGreen group-hover:text-white transition-colors duration-500 shadow-lg shadow-brandGreen/5">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            </div>
            <div>
                <h4 class="text-xl font-black tracking-tight mb-2">Direct Telephony</h4>
                <p class="text-xs text-muted-foreground font-medium leading-relaxed italic uppercase tracking-wider">+44 (0) 123 456 7890</p>
                <p class="text-[11px] text-muted-foreground mt-4 font-bold border-t pt-4">MONDAY TO FRIDAY — 09:00 TO 17:00 GMT</p>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="bg-card border rounded-[3rem] p-12 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-brandBlue/5 rounded-full -mr-32 -mt-32 blur-[100px]"></div>
        
        <h3 class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mb-12 border-b pb-6">Knowledge Base & FAQ</h3>
        
        <div class="grid gap-12 sm:grid-cols-2">
            <div class="space-y-4">
                <div class="h-8 w-8 bg-muted rounded-xl flex items-center justify-center text-xs font-black italic">Q1</div>
                <h5 class="font-black text-base tracking-tight leading-none mb-4">Credential Extraction?</h5>
                <p class="text-[11px] text-muted-foreground leading-relaxed font-medium">Upon successful assessment completion and verification of fee settlement, your credentials populate instantly in the dedicated "Certificates" console for immediate PDF extraction.</p>
            </div>
            <div class="space-y-4">
                <div class="h-8 w-8 bg-muted rounded-xl flex items-center justify-center text-xs font-black italic">Q2</div>
                <h5 class="font-black text-base tracking-tight leading-none mb-4">UK Accreditation?</h5>
                <p class="text-[11px] text-muted-foreground leading-relaxed font-medium">Affirmative. BHA Academy curriculum is meticulously mapped to standard UK healthcare competencies and recognized within clinical frameworks for professional development (CPD).</p>
            </div>
            <div class="space-y-4">
                <div class="h-8 w-8 bg-muted rounded-xl flex items-center justify-center text-xs font-black italic">Q3</div>
                <h5 class="font-black text-base tracking-tight leading-none mb-4">Referral Utilization?</h5>
                <p class="text-[11px] text-muted-foreground leading-relaxed font-medium">Referral credits acts as fluid clinical currency. During checkout for any module or PVC ID card, your available balance is automatically calculated and subtracted from the total payable amount.</p>
            </div>
            <div class="space-y-4">
                <div class="h-8 w-8 bg-muted rounded-xl flex items-center justify-center text-xs font-black italic">Q4</div>
                <h5 class="font-black text-base tracking-tight leading-none mb-4">Access Duration?</h5>
                <p class="text-[11px] text-muted-foreground leading-relaxed font-medium">Life-cycle access. Once enrolled in a clinical module, your access to the curriculum, assessments, and historical data remains active indefinitely for subsequent review.</p>
            </div>
        </div>
    </div>
    
    <div class="bg-foreground text-background p-8 rounded-[2rem] text-center shadow-2xl shadow-brandBlue/10">
        <p class="text-[10px] font-black uppercase tracking-[0.2em] mb-2 opacity-50">Legal Assistance</p>
        <p class="text-xs font-bold italic">For formal clinical report requests or data privacy inquiries, please contact legal@bha-academy.co.uk</p>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
