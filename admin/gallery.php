<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Create gallery table if it doesn't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS gallery (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        caption TEXT,
        image VARCHAR(255) NOT NULL,
        category VARCHAR(100) DEFAULT 'general',
        is_featured BOOLEAN DEFAULT FALSE,
        is_active BOOLEAN DEFAULT TRUE,
        sort_order INT DEFAULT 0,
        created_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
} catch(PDOException $e) {
    // Continue if table creation fails
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_image'])) {
        $title = sanitize_input($_POST['title']);
        $caption = sanitize_input($_POST['caption']);
        $category = sanitize_input($_POST['category']);
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        
        // For now, we'll use placeholder images since file upload needs more setup
        $placeholder_images = [
            'assets/images/githunguri_bridgewaystudents.jpeg',
            'assets/images/githunguri_bridgewaylogo.jpeg',
            'assets/images/githunguri_bridgewaygraduation.jpeg',
            'assets/images/githunguri_bridgewaythanksgiving.jpeg'
        ];
        $image = $placeholder_images[array_rand($placeholder_images)];
        
        try {
            $stmt = $pdo->prepare("INSERT INTO gallery (title, caption, image, category, is_featured, created_by) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $caption, $image, $category, $is_featured, $_SESSION['admin_id']]);
            $message = "Image added successfully!";
            $message_type = "success";
        } catch(PDOException $e) {
            $message = "Error adding image: " . $e->getMessage();
            $message_type = "danger";
        }
    }
}

// Get all gallery images
try {
    $stmt = $pdo->prepare("SELECT * FROM gallery ORDER BY is_featured DESC, created_at DESC");
    $stmt->execute();
    $gallery_images = $stmt->fetchAll();
} catch(PDOException $e) {
    $gallery_images = [];
}

include 'includes/admin_header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/admin_sidebar.php'; ?>
        
        <main>
            <div class="admin-header">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">
                        <i class="fas fa-images me-2"></i>Gallery Management
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addImageModal">
                        <i class="fas fa-plus me-1"></i>Add New Image
                    </button>
                </div>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Gallery Grid -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">School Gallery (<?php echo count($gallery_images); ?> images)</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($gallery_images)): ?>
                        <div class="row">
                            <?php foreach($gallery_images as $image): ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card h-100">
                                        <img src="../<?php echo $image['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($image['title']); ?>" style="height: 200px; object-fit: cover;">
                                        <div class="card-body p-3">
                                            <h6 class="card-title mb-1"><?php echo htmlspecialchars($image['title']); ?></h6>
                                            <?php if($image['is_featured']): ?>
                                                <span class="badge bg-warning mb-2">Featured</span>
                                            <?php endif; ?>
                                            <p class="card-text small text-muted"><?php echo htmlspecialchars($image['caption']); ?></p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted"><?php echo ucfirst($image['category']); ?></small>
                                                <span class="badge bg-<?php echo $image['is_active'] ? 'success' : 'secondary'; ?>">
                                                    <?php echo $image['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Images Found</h5>
                            <p class="text-muted">Start by adding your first gallery image using the button above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add Image Modal -->
<div class="modal fade" id="addImageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add New Image
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> This demo uses placeholder images. In production, you would upload actual images.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="title" class="form-label">Image Title *</label>
                            <input type="text" class="form-control" id="title" name="title" required placeholder="e.g., Students in Science Lab">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category" name="category">
                                <option value="general">General</option>
                                <option value="academics">Academics</option>
                                <option value="sports">Sports</option>
                                <option value="events">Events</option>
                                <option value="facilities">Facilities</option>
                                <option value="graduation">Graduation</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="caption" class="form-label">Caption/Description</label>
                        <textarea class="form-control" id="caption" name="caption" rows="3" placeholder="Describe what's happening in this image"></textarea>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured">
                        <label class="form-check-label" for="is_featured">
                            <strong>Featured Image</strong> <small class="text-muted">(Show on homepage gallery preview)</small>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_image" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Add Image
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
