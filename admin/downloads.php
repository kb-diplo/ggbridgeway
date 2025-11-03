<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Create downloads table if it doesn't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS downloads (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        file_path VARCHAR(500) NOT NULL,
        file_size VARCHAR(50),
        category VARCHAR(100) DEFAULT 'General',
        sort_order INT DEFAULT 0,
        is_active BOOLEAN DEFAULT TRUE,
        download_count INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
} catch(PDOException $e) {
    $message = "Database error: " . $e->getMessage();
    $message_type = "danger";
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_download'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $sort_order = (int)$_POST['sort_order'];
    
    // Handle file upload
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
        $upload_dir = '../uploads/downloads/';
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $file_info = pathinfo($_FILES['pdf_file']['name']);
        $file_extension = strtolower($file_info['extension']);
        
        // Check if file is PDF
        if ($file_extension == 'pdf') {
            $new_filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file_info['filename']) . '.pdf';
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path)) {
                $file_size = round($_FILES['pdf_file']['size'] / 1024, 1) . ' KB';
                if ($_FILES['pdf_file']['size'] > 1048576) {
                    $file_size = round($_FILES['pdf_file']['size'] / 1048576, 1) . ' MB';
                }
                
                try {
                    $stmt = $pdo->prepare("INSERT INTO downloads (title, description, file_path, file_size, category, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$title, $description, 'uploads/downloads/' . $new_filename, $file_size, $category, $sort_order]);
                    $message = "Download added successfully!";
                    $message_type = "success";
                } catch(PDOException $e) {
                    $message = "Error saving to database: " . $e->getMessage();
                    $message_type = "danger";
                }
            } else {
                $message = "Error uploading file.";
                $message_type = "danger";
            }
        } else {
            $message = "Only PDF files are allowed.";
            $message_type = "danger";
        }
    } else {
        $message = "Please select a PDF file to upload.";
        $message_type = "danger";
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        // Get file path before deleting
        $stmt = $pdo->prepare("SELECT file_path FROM downloads WHERE id = ?");
        $stmt->execute([$id]);
        $download = $stmt->fetch();
        
        if ($download) {
            // Delete file
            $file_path = '../' . $download['file_path'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            
            // Delete from database
            $stmt = $pdo->prepare("DELETE FROM downloads WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Download deleted successfully!";
            $message_type = "success";
        }
    } catch(PDOException $e) {
        $message = "Error deleting download: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Handle toggle active status
if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    try {
        $stmt = $pdo->prepare("UPDATE downloads SET is_active = NOT is_active WHERE id = ?");
        $stmt->execute([$id]);
        $message = "Download status updated!";
        $message_type = "success";
    } catch(PDOException $e) {
        $message = "Error updating status: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Fetch all downloads
try {
    $stmt = $pdo->prepare("SELECT * FROM downloads ORDER BY category, sort_order, created_at DESC");
    $stmt->execute();
    $downloads = $stmt->fetchAll();
} catch(PDOException $e) {
    $downloads = [];
}

include 'includes/admin_header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/admin_sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-download me-2"></i>Downloads Management
                </h1>
                <a href="../downloads.php" target="_blank" class="btn btn-outline-primary">
                    <i class="fas fa-external-link-alt me-1"></i>View Downloads Page
                </a>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Add New Download -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>Add New Download
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Title *</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="General">General</option>
                                    <option value="Admission Forms">Admission Forms</option>
                                    <option value="Academic Documents">Academic Documents</option>
                                    <option value="School Policies">School Policies</option>
                                    <option value="Fee Structure">Fee Structure</option>
                                    <option value="Newsletters">Newsletters</option>
                                    <option value="Events">Events</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Brief description of the document..."></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="pdf_file" class="form-label">PDF File *</label>
                                <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf" required>
                                <small class="form-text text-muted">Only PDF files are allowed. Maximum size: 10MB</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="0" min="0">
                                <small class="form-text text-muted">Lower numbers appear first</small>
                            </div>
                        </div>
                        
                        <button type="submit" name="add_download" class="btn btn-primary">
                            <i class="fas fa-upload me-1"></i>Upload Download
                        </button>
                    </form>
                </div>
            </div>

            <!-- Downloads List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Current Downloads (<?php echo count($downloads); ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($downloads)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>File Size</th>
                                        <th>Downloads</th>
                                        <th>Status</th>
                                        <th>Date Added</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($downloads as $download): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($download['title']); ?></strong>
                                                <?php if (!empty($download['description'])): ?>
                                                    <br><small class="text-muted"><?php echo htmlspecialchars(substr($download['description'], 0, 100)) . (strlen($download['description']) > 100 ? '...' : ''); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary"><?php echo htmlspecialchars($download['category']); ?></span>
                                            </td>
                                            <td><?php echo $download['file_size']; ?></td>
                                            <td>
                                                <span class="badge bg-info"><?php echo $download['download_count']; ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo $download['is_active'] ? 'success' : 'secondary'; ?>">
                                                    <?php echo $download['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M j, Y', strtotime($download['created_at'])); ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="../<?php echo $download['file_path']; ?>" target="_blank" class="btn btn-outline-primary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="?toggle=<?php echo $download['id']; ?>" class="btn btn-outline-warning" title="Toggle Status">
                                                        <i class="fas fa-toggle-<?php echo $download['is_active'] ? 'on' : 'off'; ?>"></i>
                                                    </a>
                                                    <a href="?delete=<?php echo $download['id']; ?>" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this download?')">
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
                        <div class="text-center py-4">
                            <div class="mb-3" style="font-size: 3rem; color: #6c757d;">
                                <i class="fas fa-download"></i>
                            </div>
                            <h5 class="text-muted">No Downloads Yet</h5>
                            <p class="text-muted">Upload your first PDF document using the form above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
