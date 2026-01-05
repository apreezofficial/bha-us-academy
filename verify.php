<?php
require_once 'includes/config.php';

$cert_id = $_GET['id'] ?? '';
$certificate = null;

if ($cert_id) {
    $stmt = $pdo->prepare("SELECT cert.*, c.title as course_title, u.name as user_name 
        FROM certificates cert 
        JOIN courses c ON cert.course_id = c.id 
        JOIN users u ON cert.user_id = u.id 
        WHERE cert.certificate_number = ?");
    $stmt->execute([$cert_id]);
    $certificate = $stmt->fetch();
}

$pageTitle = "Verify Credential";
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verify | BHA Academy Registry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        background: 'hsl(224 71% 4%)',
                        foreground: 'hsl(213 31% 91%)',
                        card: 'hsl(224 71% 4%)',
                        border: 'hsl(216 34% 17%)',
                        primary: 'hsl(210 40% 98%)',
                        brandBlue: '#0056b3',
                        brandGreen: '#28a745',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: hsl(224 71% 4%); color: hsl(213 31% 91%); }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-6 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-900 via-background to-background">

    <div class="max-w-xl w-full">
        <!-- Logo/Header -->
        <div class="text-center mb-12">
            <div class="h-16 w-16 bg-brandBlue text-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-2xl shadow-brandBlue/20">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path></svg>
            </div>
            <h1 class="text-3xl font-black tracking-tighter uppercase leading-none">Universal Registry</h1>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2 shrink-0 italic">Digital Credential Verification Service</p>
        </div>

        <div class="bg-card border-2 border-border rounded-[3rem] p-10 shadow-2xl relative overflow-hidden backdrop-blur-sm bg-background/50">
            <div class="absolute top-0 right-0 w-40 h-40 bg-brandBlue/10 rounded-full -mr-20 -mt-20 blur-3xl"></div>
            
            <form action="verify.php" method="GET" class="mb-10">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-4 ml-2">Credential Identification Number</label>
                <div class="flex gap-2">
                    <input type="text" name="id" value="<?php echo htmlspecialchars($cert_id); ?>" placeholder="e.g. BHA-XXXX-XXXX" class="flex-grow h-16 bg-slate-900/50 border-2 border-border rounded-2xl px-6 font-mono text-lg tracking-widest focus:border-brandBlue focus:ring-1 focus:ring-brandBlue outline-none uppercase" required>
                    <button type="submit" class="h-16 w-16 bg-foreground text-background rounded-2xl flex items-center justify-center hover:opacity-90 transition-all shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                    </button>
                </div>
            </form>

            <?php if ($cert_id): ?>
                <?php if ($certificate): ?>
                    <div class="animate-in fade-in slide-in-from-bottom-4 duration-700">
                        <div class="bg-brandGreen/10 border-2 border-brandGreen/20 rounded-[2.5rem] p-8 text-center relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-4 opacity-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            </div>
                            
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-brandGreen text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-6 italic shadow-lg shadow-brandGreen/20">
                                <div class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></div>
                                Authenticated
                            </span>

                            <div class="space-y-6 relative">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Accredited Professional</p>
                                    <h2 class="text-3xl font-black tracking-tighter leading-none"><?php echo $certificate['user_name']; ?></h2>
                                </div>
                                <div class="pt-6 border-t border-brandGreen/10">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Clinical Module</p>
                                    <h3 class="text-xl font-black tracking-tight leading-none text-brandGreen"><?php echo $certificate['course_title']; ?></h3>
                                </div>
                                <div class="flex justify-center gap-10 pt-6 border-t border-brandGreen/10">
                                    <div class="text-center">
                                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500 mb-1">Date Issued</p>
                                        <p class="text-xs font-black uppercase"><?php echo date('M d, Y', strtotime($certificate['issued_at'])); ?></p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500 mb-1">Type</p>
                                        <p class="text-xs font-black uppercase">Level 1 Cert</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="p-8 rounded-[2.5rem] bg-destructive/5 border-2 border-destructive/20 text-center animate-in zoom-in duration-500">
                        <div class="h-16 w-16 bg-destructive/10 text-destructive rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        </div>
                        <h4 class="text-lg font-black uppercase tracking-tight text-destructive">Registry Conflict</h4>
                        <p class="text-xs font-bold text-slate-500 mt-2">The credential number provided does not exist in our secure clinical registry. Please verify the ID and retry.</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="mt-12 text-center">
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-600 mb-4 shrink-0 shrink-0">BHA Academy Regulatory Compliance</p>
            <div class="flex items-center justify-center gap-6 opacity-30 grayscale saturate-0">
                <span class="text-[9px] font-bold border px-2 py-0.5 rounded">CPD ACCREDITED</span>
                <span class="text-[9px] font-bold border px-2 py-0.5 rounded">ISO 27001 SECURE</span>
                <span class="text-[9px] font-bold border px-2 py-0.5 rounded">GDPR COMPLIANT</span>
            </div>
        </div>
    </div>

</body>
</html>
