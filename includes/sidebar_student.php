<?php
// includes/sidebar_student.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside id="sidebar-student" class="fixed inset-y-0 left-0 z-50 bg-sidebar border-r transition-all duration-300 transform md:translate-x-0 group-data-[sidebar=collapsed]:w-20 w-64 md:group-data-[sidebar=collapsed]:translate-x-0 overflow-hidden h-screen flex flex-col">
    <div class="flex flex-col h-full w-full bg-sidebar">
        <!-- Sidebar Header -->
        <div class="h-16 flex items-center px-6 border-b shrink-0 group-data-[sidebar=collapsed]:px-5 group-data-[sidebar=collapsed]:justify-center">
            <a href="dashboard.php" class="flex items-center gap-3">
                <div class="h-8 w-8 bg-brandBlue rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                    <img src="../assets/logo.jpg" alt="Logo" class="h-5 w-5 rounded-sm">
                </div>
                <span class="font-bold text-lg tracking-tight uppercase group-data-[sidebar=collapsed]:hidden text-foreground">BHA Academy</span>
            </a>
        </div>

        <!-- Navigation - Independently Scrollable -->
        <nav class="flex-1 overflow-y-auto overflow-x-hidden py-6 px-4 space-y-8 custom-sidebar-scroll group-data-[sidebar=collapsed]:px-3">
            <!-- Main Group -->
            <div>
                <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest px-2 mb-4 group-data-[sidebar=collapsed]:hidden">General</p>
                <div class="space-y-1">
                    <a href="dashboard.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg transition-all <?php echo $current_page == 'dashboard.php' ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-accent hover:text-foreground'; ?>" title="Dashboard">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><rect width="7" height="9" x="3" y="3" rx="1"></rect><rect width="7" height="5" x="14" y="3" rx="1"></rect><rect width="7" height="9" x="14" y="12" rx="1"></rect><rect width="7" height="5" x="3" y="16" rx="1"></rect></svg>
                        <span class="text-sm font-semibold group-data-[sidebar=collapsed]:hidden whitespace-nowrap">Dashboard</span>
                    </a>
                    <a href="courses.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg transition-all <?php echo $current_page == 'courses.php' ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-accent hover:text-foreground'; ?>" title="Browse Catalog">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span class="text-sm font-semibold group-data-[sidebar=collapsed]:hidden whitespace-nowrap">Browse Catalog</span>
                    </a>
                </div>
            </div>

            <!-- My Learning -->
            <div>
                <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest px-2 mb-4 group-data-[sidebar=collapsed]:hidden">My Learning</p>
                <div class="space-y-1">
                    <a href="dashboard.php#active-courses" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg transition-all <?php echo $current_page == 'course_view.php' ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-accent hover:text-foreground'; ?>" title="My Courses">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M8 7h6"></path><path d="M8 11h8"></path></svg>
                        <span class="text-sm font-semibold group-data-[sidebar=collapsed]:hidden whitespace-nowrap">My Courses</span>
                    </a>
                    <a href="exams.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg transition-all <?php echo $current_page == 'exams.php' || $current_page == 'exam_view.php' ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-accent hover:text-foreground'; ?>" title="Assessments">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path></svg>
                        <span class="text-sm font-semibold group-data-[sidebar=collapsed]:hidden whitespace-nowrap">Assessments</span>
                    </a>
                    <a href="certificates.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg transition-all <?php echo $current_page == 'certificates.php' ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-accent hover:text-foreground'; ?>" title="Credentials">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        <span class="text-sm font-semibold group-data-[sidebar=collapsed]:hidden whitespace-nowrap">Credentials</span>
                    </a>
                </div>
            </div>

            <!-- Account & Growth -->
            <div>
                <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest px-2 mb-4 group-data-[sidebar=collapsed]:hidden">Account</p>
                <div class="space-y-1">
                    <a href="profile.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg transition-all <?php echo $current_page == 'profile.php' ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-accent hover:text-foreground'; ?>" title="Profile">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span class="text-sm font-semibold group-data-[sidebar=collapsed]:hidden whitespace-nowrap">Profile</span>
                    </a>
                    <a href="referrals.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg transition-all <?php echo $current_page == 'referrals.php' ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-accent hover:text-foreground'; ?>" title="Refer & Earn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span class="text-sm font-semibold group-data-[sidebar=collapsed]:hidden whitespace-nowrap">Refer & Earn</span>
                    </a>
                    <a href="transactions.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg transition-all <?php echo $current_page == 'transactions.php' ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-accent hover:text-foreground'; ?>" title="Billing">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line></svg>
                        <span class="text-sm font-semibold group-data-[sidebar=collapsed]:hidden whitespace-nowrap">Billing</span>
                    </a>
                </div>
            </div>

            <!-- Support & Preferences -->
            <div>
                <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest px-2 mb-4 group-data-[sidebar=collapsed]:hidden">Support</p>
                <div class="space-y-1">
                    <a href="settings.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg transition-all <?php echo $current_page == 'settings.php' ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-accent hover:text-foreground'; ?>" title="Settings">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span class="text-sm font-semibold group-data-[sidebar=collapsed]:hidden whitespace-nowrap">Settings</span>
                    </a>
                    <a href="support.php" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg transition-all <?php echo $current_page == 'support.php' ? 'bg-primary text-primary-foreground shadow-sm' : 'text-muted-foreground hover:bg-accent hover:text-foreground'; ?>" title="Help Center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><path d="M12 17h.01"></path></svg>
                        <span class="text-sm font-semibold group-data-[sidebar=collapsed]:hidden whitespace-nowrap">Help Center</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t shrink-0 bg-sidebar group-data-[sidebar=collapsed]:p-2 group-data-[sidebar=collapsed]:flex group-data-[sidebar=collapsed]:justify-center">
            <a href="../logout.php" class="sidebar-link flex items-center gap-3 p-3 rounded-xl text-destructive hover:bg-destructive/10 transition-all group overflow-hidden" title="Sign Out">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 group-hover:-translate-x-1 transition-transform"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" x2="9" y1="12" y2="12"></line></svg>
                <span class="text-sm font-bold group-data-[sidebar=collapsed]:hidden tracking-tight uppercase whitespace-nowrap">Sign Out</span>
            </a>
        </div>
    </div>
</aside>

<style>
.custom-sidebar-scroll {
    scrollbar-width: thin;
    scrollbar-color: hsl(var(--muted)) transparent;
}
.custom-sidebar-scroll::-webkit-scrollbar { 
    width: 4px; 
}
.custom-sidebar-scroll::-webkit-scrollbar-track { 
    background: transparent; 
}
.custom-sidebar-scroll::-webkit-scrollbar-thumb { 
    background: hsl(var(--muted)); 
    border-radius: 20px; 
}
.custom-sidebar-scroll::-webkit-scrollbar-thumb:hover {
    background: hsl(var(--muted-foreground) / 0.5);
}

body[data-sidebar="collapsed"] .sidebar-link {
    justify-content: center;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
}

body[data-sidebar="collapsed"] .sidebar-link svg {
    margin-right: 0;
}
</style>
