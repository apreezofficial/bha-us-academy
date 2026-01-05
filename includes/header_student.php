<?php
// includes/header_student.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en" id="html-root">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script>
        // High-performance theme detection
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <title><?php echo $pageTitle ?? 'Dashboard'; ?> | BHA Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        background: 'hsl(var(--background))',
                        foreground: 'hsl(var(--foreground))',
                        card: 'hsl(var(--card))',
                        'card-foreground': 'hsl(var(--card-foreground))',
                        popover: 'hsl(var(--popover))',
                        'popover-foreground': 'hsl(var(--popover-foreground))',
                        primary: 'hsl(var(--primary))',
                        'primary-foreground': 'hsl(var(--primary-foreground))',
                        secondary: 'hsl(var(--secondary))',
                        'secondary-foreground': 'hsl(var(--secondary-foreground))',
                        muted: 'hsl(var(--muted))',
                        'muted-foreground': 'hsl(var(--muted-foreground))',
                        accent: 'hsl(var(--accent))',
                        'accent-foreground': 'hsl(var(--accent-foreground))',
                        destructive: 'hsl(var(--destructive))',
                        'destructive-foreground': 'hsl(var(--destructive-foreground))',
                        border: 'hsl(var(--border))',
                        input: 'hsl(var(--input))',
                        ring: 'hsl(var(--ring))',
                        sidebar: 'hsl(var(--sidebar-background))',
                        'sidebar-foreground': 'hsl(var(--sidebar-foreground))',
                        'sidebar-border': 'hsl(var(--sidebar-border))',
                        brandBlue: '#0056b3',
                        brandGreen: '#28a745',
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --background: 0 0% 100%;
            --foreground: 240 10% 3.9%;
            --card: 0 0% 100%;
            --card-foreground: 240 10% 3.9%;
            --popover: 0 0% 100%;
            --popover-foreground: 240 10% 3.9%;
            --primary: 222.2 47.4% 11.2%;
            --primary-foreground: 210 40% 98%;
            --secondary: 210 40% 96.1%;
            --secondary-foreground: 222.2 47.4% 11.2%;
            --muted: 210 40% 96.1%;
            --muted-foreground: 215.4 16.3% 46.9%;
            --accent: 210 40% 96.1%;
            --accent-foreground: 222.2 47.4% 11.2%;
            --destructive: 0 84.2% 60.2%;
            --destructive-foreground: 210 40% 98%;
            --border: 214.3 31.8% 91.4%;
            --input: 214.3 31.8% 91.4%;
            --ring: 222.2 84% 4.9%;
            --sidebar-background: 210 40% 98%;
            --sidebar-foreground: 222.2 47.4% 11.2%;
            --sidebar-border: 214.3 31.8% 91.4%;
        }
        .dark {
            --background: 224 71% 4%;
            --foreground: 213 31% 91%;
            --card: 224 71% 4%;
            --card-foreground: 213 31% 91%;
            --popover: 224 71% 4%;
            --popover-foreground: 215 20.2% 65.1%;
            --primary: 210 40% 98%;
            --primary-foreground: 222.2 47.4% 11.2%;
            --secondary: 222.2 47.4% 11.2%;
            --secondary-foreground: 210 40% 98%;
            --muted: 223 47% 11%;
            --muted-foreground: 215.4 16.3% 56.9%;
            --accent: 216 34% 17%;
            --accent-foreground: 210 40% 98%;
            --destructive: 0 63% 31%;
            --destructive-foreground: 210 40% 98%;
            --border: 216 34% 17%;
            --input: 216 34% 17%;
            --ring: 216 34% 17%;
            --sidebar-background: 224 71% 4%;
            --sidebar-foreground: 213 31% 91%;
            --sidebar-border: 216 34% 17%;
        }
        body { font-family: 'Inter', sans-serif; }
        
        /* Strict Content Separation for Fixed Sidebar */
        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        .main-content {
            flex: 1;
            min-width: 0;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @media (min-width: 768px) {
            body[data-sidebar="expanded"] .main-content { margin-left: 16rem; }
            body[data-sidebar="collapsed"] .main-content { margin-left: 5rem; }
        }
        
        /* Prevent content bleed under fixed header if needed */
        .sticky-header {
            width: 100%;
        }
    </style>
</head>
<body class="antialiased min-h-screen bg-background text-foreground group" data-sidebar="expanded" data-slot="sidebar-wrapper">
    <div class="main-wrapper">
        <?php include 'sidebar_student.php'; ?>

        <div class="main-content flex flex-col">
            <header class="sticky top-0 z-40 border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 sticky-header">
                <div class="flex h-16 items-center justify-between px-4 md:px-8">
                    <div class="flex items-center gap-4">
                        <button id="sidebar-toggle" class="p-2 rounded-lg hover:bg-accent text-muted-foreground transition-colors" title="Toggle Sidebar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-panel-left"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M9 3v18"></path></svg>
                        </button>
                        <nav class="flex items-center gap-2 text-sm text-muted-foreground overflow-hidden">
                            <a href="dashboard.php" class="hover:text-foreground transition-colors shrink-0">BHA Academy</a>
                            <span class="shrink-0">/</span>
                            <span class="font-medium text-foreground truncate"><?php echo $pageTitle ?? 'Overview'; ?></span>
                        </nav>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="bg-card border rounded-lg px-3 py-1 flex flex-col items-end hidden sm:flex shadow-sm">
                             <span class="text-[9px] font-bold uppercase tracking-wider text-muted-foreground leading-none mb-1">Status</span>
                             <span class="text-xs font-bold text-brandGreen leading-none uppercase tracking-tighter">Active Learner</span>
                        </div>
                        <div class="h-8 w-8 rounded-lg bg-brandBlue text-white flex items-center justify-center font-bold text-xs shadow-sm ring-1 ring-white/20">
                            <?php echo substr($_SESSION['user_name'], 0, 1); ?>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 w-full">
                <div class="container max-w-7xl mx-auto p-4 md:p-8 pt-6">
