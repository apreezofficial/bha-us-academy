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

$pageTitle = "Certificates";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight mb-1">My Credentials</h1>
            <p class="text-muted-foreground">Your professional recognition and achievement history.</p>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="bg-brandGreen/10 border border-brandGreen/20 text-brandGreen p-6 rounded-xl flex items-center shadow-sm animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-4"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <div>
                <h4 class="font-bold">Payment Successful!</h4>
                <p class="text-sm opacity-80">Your certificate has been issued and added to your portfolio.</p>
            </div>
        </div>
    <?php endif; ?>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($certificates as $cert): ?>
            <div class="bg-card border rounded-xl overflow-hidden flex flex-col group hover:border-brandBlue transition-all shadow-sm">
                <div class="p-6 pb-0">
                    <div class="w-12 h-12 bg-primary/5 text-brandBlue rounded-lg flex items-center justify-center mb-4 group-hover:bg-brandBlue group-hover:text-white transition-colors duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-award"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                    </div>
                    <h3 class="text-lg font-bold leading-tight mb-1"><?php echo $cert['course_title']; ?></h3>
                    <p class="text-[10px] text-muted-foreground font-bold uppercase tracking-widest mb-6">ID: <?php echo $cert['certificate_number']; ?></p>
                    
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="bg-muted/50 p-3 rounded-lg border">
                            <p class="text-[9px] text-muted-foreground font-bold uppercase mb-1">Issued</p>
                            <p class="font-bold text-sm"><?php echo date('d M Y', strtotime($cert['issued_at'])); ?></p>
                        </div>
                        <div class="bg-muted/50 p-3 rounded-lg border">
                            <p class="text-[9px] text-muted-foreground font-bold uppercase mb-1">Type</p>
                            <p class="font-bold text-sm uppercase"><?php echo $cert['type']; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-auto p-6 pt-0 flex flex-col gap-2">
                    <button class="w-full h-10 bg-primary text-primary-foreground rounded-lg font-medium text-sm flex items-center justify-center gap-2 hover:opacity-90 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>
                        Download PDF
                    </button>
                    <a href="#" class="text-center text-[10px] font-bold text-muted-foreground uppercase tracking-wider py-2 hover:text-brandBlue transition-colors">Verify Credential Online &rarr;</a>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if (empty($certificates)): ?>
            <div class="col-span-full py-20 bg-card border border-dashed rounded-xl text-center">
                <div class="w-16 h-16 bg-muted rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground opacity-50"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                </div>
                <h3 class="text-lg font-bold mb-2">No certificates yet</h3>
                <p class="text-muted-foreground mb-8 text-sm max-w-xs mx-auto">Complete your first module and pass the professional assessment to earn your credentials.</p>
                <a href="courses.php" class="inline-flex h-10 px-8 items-center bg-primary text-primary-foreground rounded-lg font-medium text-sm">Explore Curriculum</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
