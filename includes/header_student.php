<?php
// includes/header_student.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $pageTitle ?? 'Dashboard'; ?> | BHA Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        sidebar: {
                            DEFAULT: '#ffffff',
                            foreground: '#09090b',
                            primary: '#18181b',
                            'primary-foreground': '#fafafa',
                            accent: '#f4f4f5',
                            'accent-foreground': '#18181b',
                            border: '#e4e4e7',
                            ring: '#a1a1aa',
                        },
                        brandBlue: '#0056b3',
                        brandGreen: '#28a745',
                        background: '#ffffff',
                        foreground: '#09090b',
                        card: '#ffffff',
                        'card-foreground': '#09090b',
                        popover: '#ffffff',
                        'popover-foreground': '#09090b',
                        primary: '#18181b',
                        'primary-foreground': '#fafafa',
                        secondary: '#f4f4f5',
                        'secondary-foreground': '#18181b',
                        muted: '#f4f4f5',
                        'muted-foreground': '#71717a',
                        accent: '#f4f4f5',
                        'accent-foreground': '#18181b',
                        destructive: '#ef4444',
                        'destructive-foreground': '#fafafa',
                        border: '#e4e4e7',
                        input: '#e4e4e7',
                        ring: '#18181b',
                    },
                    borderRadius: {
                        lg: '0.5rem',
                        md: 'calc(0.5rem - 2px)',
                        sm: 'calc(0.5rem - 4px)',
                    },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .dark {
            --background: 240 10% 3.9%;
            --foreground: 0 0% 98%;
            --card: 240 10% 3.9%;
            --card-foreground: 0 0% 98%;
            --popover: 240 10% 3.9%;
            --popover-foreground: 0 0% 98%;
            --primary: 0 0% 98%;
            --primary-foreground: 240 5.9% 10%;
            --secondary: 240 3.7% 15.9%;
            --secondary-foreground: 0 0% 98%;
            --muted: 240 3.7% 15.9%;
            --muted-foreground: 240 5% 64.9%;
            --accent: 240 3.7% 15.9%;
            --accent-foreground: 0 0% 98%;
            --destructive: 0 62.8% 30.6%;
            --destructive-foreground: 0 0% 98%;
            --border: 240 3.7% 15.9%;
            --input: 240 3.7% 15.9%;
            --ring: 240 4.9% 83.9%;
            --sidebar: 240 5.9% 10%;
            --sidebar-foreground: 240 4.8% 95.9%;
            --sidebar-primary: 224.3 76.3% 48%;
            --sidebar-primary-foreground: 0 0% 100%;
            --sidebar-accent: 240 3.7% 15.9%;
            --sidebar-accent-foreground: 240 4.8% 95.9%;
            --sidebar-border: 240 3.7% 15.9%;
            --sidebar-ring: 217.2 91.2% 59.8%;
        }
    </style>
</head>
<body class="antialiased bg-background text-foreground dark">
    <div class="flex min-h-screen w-full bg-background">
        <!-- Sidebar -->
        <?php include 'sidebar_student.php'; ?>

        <div class="flex flex-col flex-1 min-w-0">
            <!-- Header -->
            <header class="sticky top-0 z-30 flex h-16 w-full shrink-0 items-center justify-between border-b bg-background/95 px-4 backdrop-blur">
                <div class="flex items-center gap-4">
                    <button class="md:hidden p-2 hover:bg-accent rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-muted-foreground">Student</span>
                        <span class="text-sm font-medium text-muted-foreground">/</span>
                        <span class="text-sm font-medium"><?php echo str_replace('.php', '', ucfirst($current_page)); ?></span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button class="p-2 text-muted-foreground hover:text-foreground hover:bg-accent rounded-md transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell"><path d="M10.268 21a2 2 0 0 0 3.464 0"></path><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"></path></svg>
                    </button>
                    <a href="profile.php" class="flex items-center gap-2 p-1 pl-2 hover:bg-accent rounded-full transition-colors group">
                        <div class="flex flex-col items-end hidden sm:flex">
                            <span class="text-xs font-semibold leading-none"><?php echo $_SESSION['user_name']; ?></span>
                            <span class="text-[10px] text-muted-foreground">Student ID: #<?php echo 1000 + $_SESSION['user_id']; ?></span>
                        </div>
                        <div class="h-8 w-8 rounded-full bg-brandBlue flex items-center justify-center text-white font-bold text-sm">
                            <?php echo substr($_SESSION['user_name'], 0, 1); ?>
                        </div>
                    </a>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8">
