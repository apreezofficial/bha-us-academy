<?php
require_once '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];

// Get Search and Category filters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? 'all';

// Fetch categories
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();

// Fetch courses the user is NOT enrolled in
$query = "SELECT c.*, cat.name as category_name FROM courses c 
          LEFT JOIN categories cat ON c.category_id = cat.id
          WHERE c.id NOT IN (SELECT course_id FROM enrollments WHERE user_id = ?)";
$params = [$user_id];

if ($search) {
    $query .= " AND (c.title LIKE ? OR c.description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($category !== 'all') {
    $query .= " AND c.category_id = ?";
    $params[] = $category;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$available_courses = $stmt->fetchAll();

// Enrollment action
if (isset($_POST['enroll'])) {
    $course_id = $_POST['course_id'];
    $stmt = $pdo->prepare("INSERT INTO enrollments (user_id, course_id, status) VALUES (?, ?, 'active')");
    if ($stmt->execute([$user_id, $course_id])) {
        header("Location: course_view.php?course_id=" . $course_id);
        exit;
    }
}

$pageTitle = "Catalog";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight mb-1">Clinical Curriculum</h1>
            <p class="text-muted-foreground">Browse and enroll in professional healthcare modules.</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-4">
        <form class="flex-1 flex gap-2">
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search modules..." class="w-full bg-card border rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-primary outline-none transition-all">
            </div>
            <select name="category" onchange="this.form.submit()" class="bg-card border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary outline-none">
                <option value="all">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo $category == $cat['id'] ? 'selected' : ''; ?>><?php echo $cat['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="bg-primary text-primary-foreground px-6 py-2 rounded-lg text-sm font-medium">Filter</button>
        </form>
    </div>

    <!-- Grid -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($available_courses as $course): ?>
        <div class="bg-card border rounded-xl overflow-hidden flex flex-col group hover:shadow-lg transition-all border-b-4 hover:border-b-brandBlue">
            <div class="h-48 bg-muted relative">
                <img src="<?php echo img_url($course['image']); ?>" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute top-4 left-4 bg-brandBlue text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest leading-none shadow-lg">
                    £<?php echo number_format($course['price'], 2); ?>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-4 left-4 right-4">
                    <p class="text-[10px] font-bold text-white/70 uppercase tracking-widest mb-1"><?php echo $course['category_name']; ?></p>
                    <h3 class="text-white font-bold text-lg leading-tight"><?php echo $course['title']; ?></h3>
                </div>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <p class="text-xs text-muted-foreground mb-6 line-clamp-2 leading-relaxed"><?php echo $course['description']; ?></p>
                <div class="mt-auto pt-6 border-t flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brandGreen"><path d="m9 12 2 2 4-4"></path><circle cx="12" cy="12" r="10"></circle></svg>
                        <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider">CPD Accredited</span>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                        <button type="submit" name="enroll" class="text-sm font-bold text-brandBlue hover:underline flex items-center gap-1 group/btn">
                            Enroll Now
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover/btn:translate-x-1 transition-transform"><path d="m9 18 6-6-6-6"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (empty($available_courses)): ?>
        <div class="col-span-full py-20 bg-card border border-dashed rounded-xl text-center">
            <h3 class="text-lg font-bold mb-2">No modules found</h3>
            <p class="text-muted-foreground">Try adjusting your filters or search terms.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
