<?php
require_once '../includes/auth.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$cat_id = $_GET['category'] ?? null;

// Fetch ALL categories for filter
$stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $stmt->fetchAll();

// Fetch ALL courses (no limit)
$query = "SELECT c.*, cat.name as category_name 
          FROM courses c 
          LEFT JOIN categories cat ON c.category_id = cat.id 
          WHERE 1=1";
$params = [];

if ($cat_id) {
    $query .= " AND c.category_id = ?";
    $params[] = $cat_id;
}

$query .= " ORDER BY c.created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$courses = $stmt->fetchAll();

$pageTitle = "Course Catalog";
include '../includes/header_student.php';
?>

<div class="flex flex-col gap-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="max-w-xl">
            <h1 class="text-4xl font-black tracking-tighter mb-4 leading-none uppercase">Academic Catalog</h1>
            <p class="text-muted-foreground font-medium">Explore all available clinical training modules and accreditation paths.</p>
        </div>
        
        <!-- Filter -->
        <div class="flex flex-wrap gap-2">
            <a href="courses.php" class="h-9 px-4 rounded-full flex items-center justify-center text-xs font-bold uppercase tracking-widest transition-all <?php echo !$cat_id ? 'bg-primary text-primary-foreground' : 'bg-muted text-muted-foreground hover:bg-muted/80'; ?>">
                All Modules
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="courses.php?category=<?php echo $cat['id']; ?>" class="h-9 px-4 rounded-full flex items-center justify-center text-xs font-bold uppercase tracking-widest transition-all <?php echo $cat_id == $cat['id'] ? 'bg-primary text-primary-foreground' : 'bg-muted text-muted-foreground hover:bg-muted/80'; ?>">
                    <?php echo $cat['name']; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($courses as $course): ?>
            <div class="group bg-card border rounded-[2rem] overflow-hidden hover:border-brandBlue transition-all duration-500 shadow-sm hover:shadow-2xl hover:-translate-y-1">
                <div class="aspect-[16/10] relative overflow-hidden bg-muted">
                    <img src="<?php echo img_url($course['image']); ?>" alt="<?php echo $course['title']; ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                        <span class="px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-widest text-white border border-white/20">
                            <?php echo $course['category_name'] ?: 'Clinical'; ?>
                        </span>
                    </div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-black tracking-tight mb-4 leading-tight min-h-[4rem] line-clamp-2"><?php echo $course['title']; ?></h3>
                    <p class="text-sm text-muted-foreground line-clamp-2 mb-8 font-medium leading-relaxed"><?php echo $course['description']; ?></p>
                    
                    <div class="flex items-center justify-between pt-6 border-t border-border/50">
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-black">£<?php echo number_format($course['price'], 2); ?></span>
                            <span class="text-[10px] font-bold text-muted-foreground uppercase opacity-60">incl. VAT</span>
                        </div>
                        <a href="course_view.php?id=<?php echo $course['id']; ?>" class="h-11 px-6 bg-primary text-primary-foreground rounded-xl font-bold text-sm flex items-center gap-2 hover:opacity-90 shadow-lg transition-all group">
                            Enroll
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><path d="m9 18 6-6-6-6"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../includes/footer_student.php'; ?>
