<?php
// sidebar.php
$current_page = basename($_SERVER['PHP_SELF']);
$is_admin = isAdmin();
?>
<aside class="w-64 bg-white h-screen border-r border-gray-100 hidden lg:flex flex-col sticky top-0">
    <div class="px-6 h-20 flex items-center border-b border-gray-50">
        <a href="../index.php" class="flex items-center space-x-2">
            <img src="../assets/logo.jpg" alt="Logo" class="h-10 w-auto rounded">
            <span class="text-lg font-bold text-brandBlue">BHA Academy</span>
        </a>
    </div>

    <div class="flex-grow py-8 overflow-y-auto">
        <nav class="px-4 space-y-2">
            <p class="text-[10px] font-bold text-gray-400 px-4 mb-4 uppercase tracking-widest">Main Menu</p>
            
            <?php if ($is_admin): ?>
                <a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'bg-brandBlue text-white shadow-lg shadow-brandBlue/20' : 'text-gray-500 hover:bg-gray-50'; ?> flex items-center px-4 py-3 rounded-xl transition font-medium group text-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="courses.php" class="<?php echo $current_page == 'courses.php' ? 'bg-brandBlue text-white shadow-lg shadow-brandBlue/20' : 'text-gray-500 hover:bg-gray-50'; ?> flex items-center px-4 py-3 rounded-xl transition font-medium group text-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Courses
                </a>
                <a href="vouchers.php" class="<?php echo $current_page == 'vouchers.php' ? 'bg-brandBlue text-white shadow-lg shadow-brandBlue/20' : 'text-gray-500 hover:bg-gray-50'; ?> flex items-center px-4 py-3 rounded-xl transition font-medium group text-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    Vouchers
                </a>
                <a href="transactions.php" class="<?php echo $current_page == 'transactions.php' ? 'bg-brandBlue text-white shadow-lg shadow-brandBlue/20' : 'text-gray-500 hover:bg-gray-50'; ?> flex items-center px-4 py-3 rounded-xl transition font-medium group text-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Finance
                </a>
            <?php else: ?>
                <a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'bg-brandBlue text-white shadow-lg shadow-brandBlue/20' : 'text-gray-500 hover:bg-gray-50'; ?> flex items-center px-4 py-3 rounded-xl transition font-medium group text-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    My Learning
                </a>
                <a href="courses.php" class="<?php echo $current_page == 'courses.php' ? 'bg-brandBlue text-white shadow-lg shadow-brandBlue/20' : 'text-gray-500 hover:bg-gray-50'; ?> flex items-center px-4 py-3 rounded-xl transition font-medium group text-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Browse Courses
                </a>
                <a href="certificates.php" class="<?php echo $current_page == 'certificates.php' ? 'bg-brandBlue text-white shadow-lg shadow-brandBlue/20' : 'text-gray-500 hover:bg-gray-50'; ?> flex items-center px-4 py-3 rounded-xl transition font-medium group text-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04default_api:6A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Certificates
                </a>
                <a href="referrals.php" class="<?php echo $current_page == 'referrals.php' ? 'bg-brandBlue text-white shadow-lg shadow-brandBlue/20' : 'text-gray-500 hover:bg-gray-50'; ?> flex items-center px-4 py-3 rounded-xl transition font-medium group text-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Referrals
                </a>
            <?php endif; ?>
        </nav>
    </div>

    <div class="p-6 border-t border-gray-50">
        <div class="bg-gray-50 rounded-2xl p-4 flex items-center mb-6">
            <div class="w-10 h-10 bg-brandBlue text-white rounded-full flex items-center justify-center font-bold mr-3 uppercase">
                <?php echo substr($_SESSION['user_name'], 0, 1); ?>
            </div>
            <div class="flex-grow min-w-0">
                <p class="text-sm font-bold text-gray-900 truncate"><?php echo $_SESSION['user_name']; ?></p>
                <p class="text-[10px] text-gray-500 uppercase tracking-tighter">Student Account</p>
            </div>
        </div>
        <a href="../logout.php" class="flex items-center text-red-500 hover:text-red-700 text-sm font-bold transition px-4">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Logout
        </a>
    </div>
</aside>
