<?php
require_once '../includes/auth.php';
requireLogin();

$stmt = $pdo->prepare("SELECT cert.*, c.title as course_title 
    FROM certificates cert 
    JOIN courses c ON cert.course_id = c.id 
    WHERE cert.user_id = ? 
    ORDER BY cert.issued_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$certificates = $stmt->fetchAll();

$pageTitle = "Credential Portfolio";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 text-foreground">
        <div class="max-w-xl">
            <h1 class="text-4xl font-black tracking-tighter mb-4 leading-none uppercase">Certified Achievements</h1>
            <p class="text-muted-foreground font-medium">Verify your clinical expertise and manage your professional credentials recognized by BHA Academy.</p>
        </div>
        
        <div class="flex items-center gap-2 bg-muted/30 px-4 py-2 rounded-full border border-dashed">
            <span class="text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Registry Status</span>
            <div class="h-2 w-2 rounded-full bg-brandGreen"></div>
            <span class="text-xs font-bold leading-none tracking-tighter uppercase">Synchronized</span>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="p-6 rounded-3xl bg-brandGreen/10 border border-brandGreen/20 text-brandGreen flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="h-12 w-12 rounded-2xl bg-brandGreen text-white flex items-center justify-center shrink-0 shadow-lg shadow-brandGreen/20">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div>
                <h4 class="font-black text-sm uppercase tracking-tight">Accreditation Success</h4>
                <p class="text-xs font-bold opacity-80">Your professional certificate has been securely appended to your registry.</p>
            </div>
        </div>
    <?php endif; ?>

    <div class="grid gap-10 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($certificates as $cert): ?>
            <div class="bg-card border-2 border-muted hover:border-brandBlue rounded-[2.5rem] overflow-hidden flex flex-col group transition-all duration-500 hover:shadow-2xl hover:shadow-brandBlue/5 hover:-translate-y-1 relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-brandBlue/5 rounded-full -mr-16 -mt-16 blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="p-10 pb-0 relative">
                    <div class="w-16 h-16 bg-brandBlue/10 text-brandBlue rounded-[1.3rem] flex items-center justify-center mb-8 border border-brandBlue/20 group-hover:bg-brandBlue group-hover:text-white transition-all duration-700 shadow-xl shadow-brandBlue/5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                    </div>
                    
                    <h3 class="text-2xl font-black tracking-tight leading-[1.1] mb-2 group-hover:text-brandBlue transition-colors duration-500"><?php echo $cert['course_title']; ?></h3>
                    <div class="flex items-center gap-2 mb-8">
                        <span class="text-[9px] text-muted-foreground font-black uppercase tracking-widest">REG NO:</span>
                        <span class="text-[9px] font-mono font-bold py-1 px-2 bg-muted rounded-lg border"><?php echo $cert['certificate_number']; ?></span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-muted/30 p-4 rounded-2xl border border-dashed text-center">
                            <p class="text-[9px] text-muted-foreground font-black uppercase tracking-widest mb-1">Affirmed</p>
                            <p class="font-black text-xs uppercase"><?php echo date('d M Y', strtotime($cert['issued_at'])); ?></p>
                        </div>
                        <div class="bg-muted/30 p-4 rounded-2xl border border-dashed text-center">
                            <p class="text-[9px] text-muted-foreground font-black uppercase tracking-widest mb-1">Category</p>
                            <p class="font-black text-xs uppercase tracking-tighter"><?php echo $cert['status'] ?: 'Accredited'; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-auto p-10 pt-0 flex flex-col gap-3 relative">
                    <button class="w-full h-14 bg-foreground text-background rounded-2xl font-black text-xs uppercase tracking-widest flex items-center justify-center gap-3 hover:opacity-90 active:scale-95 transition-all shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>
                        Download PDF
                    </button>
                    <a href="../verify.php?id=<?php echo $cert['certificate_number']; ?>" class="h-12 w-full flex items-center justify-center text-[10px] font-black text-muted-foreground uppercase tracking-widest hover:text-brandBlue transition-colors group/link border border-transparent hover:border-muted rounded-xl">
                        Universal Verification Registry
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="ml-2 group-hover/link:translate-x-1 transition-transform"><path d="m9 18 6-6-6-6"></path></svg>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if (empty($certificates)): ?>
            <div class="col-span-full py-32 bg-card border-2 border-dashed rounded-[3rem] text-center px-8 relative overflow-hidden">
                <div class="absolute inset-0 bg-muted/5 opacity-50"></div>
                <div class="w-24 h-24 bg-muted text-muted-foreground/30 rounded-[2rem] flex items-center justify-center mx-auto mb-8 shadow-inner border border-muted/50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                </div>
                <h3 class="text-2xl font-black tracking-tight mb-4 uppercase">Registry Empty</h3>
                <p class="text-muted-foreground mb-10 text-sm max-w-sm mx-auto font-medium">Your professional portfolio is awaiting its first clinical validation. Complete your modules and assessments to generate permanent credentials.</p>
                <a href="courses.php" class="inline-flex h-14 px-12 items-center bg-brandBlue text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-2xl shadow-brandBlue/20 hover:-translate-y-1 transition-all">Browse Curriculum</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
