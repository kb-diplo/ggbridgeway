<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $youtube_url = sanitize_input($_POST['youtube_url']);
    $button_text = sanitize_input($_POST['button_text']);
    $button_link = sanitize_input($_POST['button_link']);
    $sort_order = (int)$_POST['sort_order'];
    
    try {
        if (isset($_POST['add_banner'])) {
            $stmt = $pdo->prepare("INSERT INTO banners (title, image, description, youtube_url, button_text, button_link, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, 'assets/images/banner-placeholder.jpg', $description, $youtube_url, $button_text, $button_link, $sort_order]);
            $message = "Banner added successfully!";
            $message_type = "success";
        }
    } catch(PDOException $e) {
        $message = "Error adding banner: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Handle actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = (int)$_GET['id'];
    
    try {
        if ($action == 'delete') {
            $stmt = $pdo->prepare("DELETE FROM banners WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Banner deleted successfully.";
            $message_type = "success";
        } elseif ($action == 'toggle') {
            $stmt = $pdo->prepare("UPDATE banners SET is_active = NOT is_active WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Banner status updated.";
            $message_type = "success";
        }
    } catch(PDOException $e) {
        $message = "Error performing action.";
        $message_type = "danger";
    }
}

// Get banners
try {
    $stmt = $pdo->prepare("SELECT * FROM banners ORDER BY sort_order ASC");
    $stmt->execute();
    $banners = $stmt->fetchAll();
} catch(PDOException $e) {
    $banners = [];
}

include 'includes/admin_header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/admin_sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="admin-header">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">
                        <i class="fas fa-images me-2"></i>Homepage Banners
                    </h1>
                </div>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Add Banner Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>Add New Banner
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Banner Title *</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="0">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="youtube_url" class="form-label">YouTube Video URL (Optional)</label>
                                <input type="url" class="form-control" id="youtube_url" name="youtube_url" 
                                       placeholder="https://www.youtube.com/watch?v=...">
                                <small class="text-muted">Add a YouTube video to make banner interactive</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="button_text" class="form-label">Button Text</label>
                                <input type="text" class="form-control" id="button_text" name="button_text" 
                                       value="Learn More" placeholder="Learn More">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="button_link" class="form-label">Button Link</label>
                            <input type="text" class="form-control" id="button_link" name="button_link" 
                                   placeholder="/about.php or external URL">
                            <small class="text-muted">Where the button should link to</small>
                        </div>
                        
                        <button type="submit" name="add_banner" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Add Banner
                        </button>
                    </form>
                </div>
            </div>

            <!-- Banners List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Existing Banners</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($banners)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($banners as $banner): ?>
                                        <tr>
                                            <td><strong><?php echo htmlspecialchars($banner['title']); ?></strong></td>
                                            <td><?php echo htmlspecialchars(substr($banner['description'], 0, 100)) . (strlen($banner['description']) > 100 ? '...' : ''); ?></td>
                                            <td><?php echo $banner['sort_order']; ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $banner['is_active'] ? 'success' : 'secondary'; ?>">
                                                    <?php echo $banner['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="banners.php?action=toggle&id=<?php echo $banner['id']; ?>" 
                                                       class="btn btn-outline-<?php echo $banner['is_active'] ? 'warning' : 'success'; ?>" 
                                                       title="<?php echo $banner['is_active'] ? 'Deactivate' : 'Activate'; ?>">
                                                        <i class="fas fa-<?php echo $banner['is_active'] ? 'eye-slash' : 'eye'; ?>"></i>
                                                    </a>
                                                    <a href="banners.php?action=delete&id=<?php echo $banner['id']; ?>" 
                                                       class="btn btn-outline-danger" title="Delete"
                                                       onclick="return confirmDelete('Are you sure you want to delete this banner?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No banners found</h5>
                            <p class="text-muted">Add your first homepage banner using the form above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
