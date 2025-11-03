<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Handle form submission for adding media
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_media'])) {
        $title = sanitize_input($_POST['title']);
        $description = sanitize_input($_POST['description']);
        $media_type = sanitize_input($_POST['media_type']);
        $youtube_url = sanitize_input($_POST['youtube_url']);
        $category = sanitize_input($_POST['category']);
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        
        try {
            $stmt = $pdo->prepare("INSERT INTO school_media (title, description, media_type, youtube_url, category, is_featured) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $media_type, $youtube_url, $category, $is_featured]);
            $message = "Media item added successfully!";
            $message_type = "success";
        } catch(PDOException $e) {
            $message = "Error adding media item.";
            $message_type = "danger";
        }
    }
}

// Handle actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = (int)$_GET['id'];
    
    try {
        if ($action == 'delete') {
            $stmt = $pdo->prepare("DELETE FROM school_media WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Media item deleted successfully.";
            $message_type = "success";
        } elseif ($action == 'toggle_featured') {
            $stmt = $pdo->prepare("UPDATE school_media SET is_featured = NOT is_featured WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Featured status updated.";
            $message_type = "success";
        }
    } catch(PDOException $e) {
        $message = "Error performing action.";
        $message_type = "danger";
    }
}

// Get media items
try {
    $stmt = $pdo->prepare("SELECT * FROM school_media ORDER BY created_at DESC");
    $stmt->execute();
    $media_items = $stmt->fetchAll();
} catch(PDOException $e) {
    $media_items = [];
}

// Function to extract YouTube video ID
function getYouTubeVideoId($url) {
    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $url, $matches);
    return isset($matches[1]) ? $matches[1] : null;
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
                        <i class="fas fa-photo-video me-2"></i>Media Management
                    </h1>
                </div>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Add Media Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>Add New Media Item
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Title *</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="media_type" class="form-label">Media Type *</label>
                                <select class="form-control" id="media_type" name="media_type" required>
                                    <option value="video">YouTube Video</option>
                                    <option value="image">Image</option>
                                    <option value="document">Document</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="youtube_url" class="form-label">YouTube URL</label>
                                <input type="url" class="form-control" id="youtube_url" name="youtube_url" 
                                       placeholder="https://www.youtube.com/watch?v=...">
                                <small class="text-muted">For video content, paste the full YouTube URL</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="introduction">School Introduction</option>
                                    <option value="academics">Academics</option>
                                    <option value="events">Events</option>
                                    <option value="sports">Sports</option>
                                    <option value="facilities">Facilities</option>
                                    <option value="achievements">Achievements</option>
                                    <option value="general">General</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured">
                                <label class="form-check-label" for="is_featured">
                                    Featured Item (will appear prominently on website)
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" name="add_media" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Add Media Item
                        </button>
                    </form>
                </div>
            </div>

            <!-- Media Items List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Media Library (<?php echo count($media_items); ?> items)</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($media_items)): ?>
                        <div class="row">
                            <?php foreach($media_items as $item): ?>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card h-100">
                                        <?php if($item['media_type'] == 'video' && $item['youtube_url']): ?>
                                            <?php $videoId = getYouTubeVideoId($item['youtube_url']); ?>
                                            <?php if($videoId): ?>
                                                <div class="position-relative">
                                                    <img src="https://img.youtube.com/vi/<?php echo $videoId; ?>/maxresdefault.jpg" 
                                                         class="card-img-top" alt="Video Thumbnail" style="height: 200px; object-fit: cover;">
                                                    <div class="position-absolute top-50 start-50 translate-middle">
                                                        <i class="fas fa-play-circle text-white" style="font-size: 3rem; opacity: 0.8;"></i>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div class="card-img-top d-flex align-items-center justify-content-center" 
                                                 style="height: 200px; background-color: var(--light-gray);">
                                                <i class="fas fa-<?php echo $item['media_type'] == 'image' ? 'image' : 'file-alt'; ?>" 
                                                   style="font-size: 3rem; color: var(--navy-blue);"></i>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h6>
                                                <?php if($item['is_featured']): ?>
                                                    <span class="badge bg-warning text-dark">Featured</span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <i class="fas fa-tag me-1"></i><?php echo ucfirst($item['category']); ?> • 
                                                    <i class="fas fa-<?php echo $item['media_type'] == 'video' ? 'video' : ($item['media_type'] == 'image' ? 'image' : 'file'); ?> me-1"></i><?php echo ucfirst($item['media_type']); ?>
                                                </small>
                                            </p>
                                            
                                            <?php if($item['description']): ?>
                                                <p class="card-text"><?php echo htmlspecialchars(substr($item['description'], 0, 100)) . (strlen($item['description']) > 100 ? '...' : ''); ?></p>
                                            <?php endif; ?>
                                            
                                            <small class="text-muted">Added: <?php echo date('M j, Y', strtotime($item['created_at'])); ?></small>
                                        </div>
                                        
                                        <div class="card-footer">
                                            <div class="btn-group btn-group-sm w-100">
                                                <?php if($item['youtube_url']): ?>
                                                    <a href="<?php echo $item['youtube_url']; ?>" target="_blank" 
                                                       class="btn btn-outline-primary" title="View on YouTube">
                                                        <i class="fab fa-youtube"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="media.php?action=toggle_featured&id=<?php echo $item['id']; ?>" 
                                                   class="btn btn-outline-<?php echo $item['is_featured'] ? 'warning' : 'success'; ?>" 
                                                   title="<?php echo $item['is_featured'] ? 'Remove from Featured' : 'Make Featured'; ?>">
                                                    <i class="fas fa-star"></i>
                                                </a>
                                                <a href="media.php?action=delete&id=<?php echo $item['id']; ?>" 
                                                   class="btn btn-outline-danger" title="Delete"
                                                   onclick="return confirmDelete('Are you sure you want to delete this media item?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-photo-video fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No media items found</h5>
                            <p class="text-muted">Add your first media item using the form above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
