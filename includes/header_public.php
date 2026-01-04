<?php
// includes/header_public.php
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'BHA Academy — Professional Healthcare Training'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brandBlue: '#0056b3',
                        brandGreen: '#28a745',
                        darkBg: '#030014',
                    },
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                    },
                    animation: {
                        'aurora': 'aurora 20s linear infinite',
                    },
                    keyframes: {
                        aurora: {
                            'from': { backgroundPosition: '50% 50%, 50% 50%' },
                            'to': { backgroundPosition: '350% 50%, 350% 50%' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .mask-radial {
            mask-image: radial-gradient(ellipse at 100% 0%, black 10%, transparent 70%);
        }
        .text-gradient {
            background: linear-gradient(135deg, #0056b3 0%, #28a745 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .bg-grid {
            background-size: 56px 56px;
            background-image: 
                linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
        }
        .aurora-bg {
            --aurora: repeating-linear-gradient(100deg, #0056b3 10%, #28a745 15%, #0056b3 20%, #28a745 25%, #0056b3 30%);
            background-image: var(--aurora);
            background-size: 300%, 200%;
            filter: blur(100px);
            opacity: 0.15;
            pointer-events: none;
        }
    </style>
</head>
<body class="font-outfit antialiased bg-darkBg text-white selection:bg-brandGreen/30">
    <div class="fixed inset-0 z-0 pointer-events-none opacity-40">
        <div class="absolute inset-0 bg-grid"></div>
        <div class="absolute -top-[20%] -left-[10%] w-[700px] h-[700px] aurora-bg animate-aurora"></div>
        <div class="absolute top-[40%] -right-[10%] w-[600px] h-[600px] aurora-bg animate-aurora [animation-delay:-5s] opacity-10"></div>
    </div>

    <header class="fixed inset-x-0 top-0 z-50 border-b border-white/5 backdrop-blur-xl bg-darkBg/30">
        <div class="max-w-[1600px] mx-auto px-6 sm:px-10">
            <div class="flex h-20 items-center justify-between">
                <div class="flex items-center gap-10">
                    <a href="index.php" class="flex items-center gap-4 group">
                        <div class="relative w-12 h-12 bg-white rounded-xl overflow-hidden shadow-lg group-hover:scale-110 transition-transform">
                            <img src="assets/logo.jpg" alt="BHA Logo" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-black tracking-tighter uppercase leading-none">Brilliance</span>
                            <span class="text-[8px] font-bold text-brandBlue tracking-[0.2em] uppercase">Healthcare Academy</span>
                        </div>
                    </a>
                    <nav class="hidden md:flex items-center gap-8">
                        <a href="about.php" class="text-sm font-medium text-white/60 hover:text-white transition-colors">About</a>
                        <a href="for-teams.php" class="text-sm font-medium text-white/60 hover:text-white transition-colors">For Teams</a>
                        <a href="certificates-info.php" class="text-sm font-medium text-white/60 hover:text-white transition-colors">Certificates</a>
                        <a href="contact.php" class="text-sm font-medium text-white/60 hover:text-white transition-colors">Contact</a>
                    </nav>
                </div>
                <div class="flex items-center gap-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="student/dashboard.php" class="text-sm font-bold text-white/80 hover:text-white">Dashboard</a>
                        <a href="logout.php" class="bg-white/5 border border-white/10 hover:bg-white/10 px-6 py-2.5 rounded-full text-sm font-bold transition-all">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="text-sm font-bold text-white/60 hover:text-white transition-colors">Login</a>
                        <a href="register.php" class="bg-gradient-to-r from-brandBlue to-brandGreen px-8 py-3 rounded-full text-sm font-bold hover:shadow-[0_0_30px_-5px_#0056b3] transition-all">Join Academy</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <main class="relative z-10 pt-20">
