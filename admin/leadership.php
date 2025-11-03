<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Create leadership table if it doesn't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS leadership (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        position VARCHAR(255) NOT NULL,
        bio TEXT,
        image VARCHAR(255) NULL,
        email VARCHAR(255) NULL,
        phone VARCHAR(20) NULL,
        is_active BOOLEAN DEFAULT TRUE,
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
    
    // Insert default director if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM leadership WHERE position = 'School Director'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $stmt = $pdo->prepare("INSERT INTO leadership (name, position, bio, sort_order, is_active) VALUES (?, ?, ?, 1, 1)");
        $stmt->execute([
            'Ms. Wa-Mwaura',
            'School Director',
            'Leading Githunguri Bridgeway Preparatory School with dedication to educational excellence and student development. Committed to providing quality education that nurtures young minds and builds strong foundations for future success.'
        ]);
    }
} catch(PDOException $e) {
    // Continue if table creation fails
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_leader'])) {
        $id = (int)$_POST['leader_id'];
        $name = sanitize_input($_POST['name']);
        $position = sanitize_input($_POST['position']);
        $bio = sanitize_input($_POST['bio']);
        $email = sanitize_input($_POST['email']);
        $phone = sanitize_input($_POST['phone']);
        
        // Handle image upload
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $upload_dir = '../uploads/leadership/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $new_filename = 'leader_' . $id . '_' . time() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $image_path = 'uploads/leadership/' . $new_filename;
            }
        }
        
        try {
            if ($image_path) {
                $stmt = $pdo->prepare("UPDATE leadership SET name = ?, position = ?, bio = ?, email = ?, phone = ?, image = ? WHERE id = ?");
                $stmt->execute([$name, $position, $bio, $email, $phone, $image_path, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE leadership SET name = ?, position = ?, bio = ?, email = ?, phone = ? WHERE id = ?");
                $stmt->execute([$name, $position, $bio, $email, $phone, $id]);
            }
            $message = "Leadership information updated successfully!";
            $message_type = "success";
        } catch(PDOException $e) {
            $message = "Error updating leadership information.";
            $message_type = "danger";
        }
    }
    
    if (isset($_POST['add_leader'])) {
        $name = sanitize_input($_POST['name']);
        $position = sanitize_input($_POST['position']);
        $bio = sanitize_input($_POST['bio']);
        $email = sanitize_input($_POST['email']);
        $phone = sanitize_input($_POST['phone']);
        $sort_order = (int)$_POST['sort_order'];
        
        try {
            $stmt = $pdo->prepare("INSERT INTO leadership (name, position, bio, email, phone, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $position, $bio, $email, $phone, $sort_order]);
            $message = "New leader added successfully!";
            $message_type = "success";
        } catch(PDOException $e) {
            $message = "Error adding new leader.";
            $message_type = "danger";
        }
    }
}

// Handle actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = (int)$_GET['id'];
    
    try {
        if ($action == 'toggle') {
            $stmt = $pdo->prepare("UPDATE leadership SET is_active = NOT is_active WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Leader status updated.";
            $message_type = "success";
        } elseif ($action == 'delete' && $id != 1) { // Don't allow deleting the director
            $stmt = $pdo->prepare("DELETE FROM leadership WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Leader removed successfully.";
            $message_type = "success";
        }
    } catch(PDOException $e) {
        $message = "Error performing action.";
        $message_type = "danger";
    }
}

// Get leadership team
try {
    $stmt = $pdo->prepare("SELECT * FROM leadership ORDER BY sort_order ASC, created_at ASC");
    $stmt->execute();
    $leaders = $stmt->fetchAll();
} catch(PDOException $e) {
    $leaders = [];
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
                        <i class="fas fa-users-cog me-2"></i>Leadership Management
                    </h1>
                </div>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Current Leadership Team -->
            <div class="row">
                <?php foreach($leaders as $leader): ?>
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><?php echo htmlspecialchars($leader['name']); ?></h5>
                                <div>
                                    <span class="badge bg-<?php echo $leader['is_active'] ? 'success' : 'secondary'; ?>">
                                        <?php echo $leader['is_active'] ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="leader_id" value="<?php echo $leader['id']; ?>">
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name_<?php echo $leader['id']; ?>" class="form-label">Name *</label>
                                            <input type="text" class="form-control" id="name_<?php echo $leader['id']; ?>" name="name" 
                                                   value="<?php echo htmlspecialchars($leader['name']); ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="position_<?php echo $leader['id']; ?>" class="form-label">Position *</label>
                                            <input type="text" class="form-control" id="position_<?php echo $leader['id']; ?>" name="position" 
                                                   value="<?php echo htmlspecialchars($leader['position']); ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="bio_<?php echo $leader['id']; ?>" class="form-label">Biography</label>
                                        <textarea class="form-control" id="bio_<?php echo $leader['id']; ?>" name="bio" rows="3"><?php echo htmlspecialchars($leader['bio']); ?></textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="email_<?php echo $leader['id']; ?>" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email_<?php echo $leader['id']; ?>" name="email" 
                                                   value="<?php echo htmlspecialchars(isset($leader['email']) ? $leader['email'] : ''); ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="phone_<?php echo $leader['id']; ?>" class="form-label">Phone</label>
                                            <input type="tel" class="form-control" id="phone_<?php echo $leader['id']; ?>" name="phone" 
                                                   value="<?php echo htmlspecialchars(isset($leader['phone']) ? $leader['phone'] : ''); ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="image_<?php echo $leader['id']; ?>" class="form-label">Photo</label>
                                        <?php if($leader['image']): ?>
                                            <div class="mb-2">
                                                <img src="<?php echo SITE_URL . '/' . $leader['image']; ?>" alt="Current photo" 
                                                     class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control" id="image_<?php echo $leader['id']; ?>" name="image" accept="image/*">
                                        <small class="text-muted">Upload a professional photo (JPG, PNG). Leave empty to keep current photo.</small>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="submit" name="update_leader" class="btn btn-primary btn-sm">
                                            <i class="fas fa-save me-1"></i>Update
                                        </button>
                                        <?php if($leader['id'] != 1): ?>
                                            <a href="leadership.php?action=toggle&id=<?php echo $leader['id']; ?>" 
                                               class="btn btn-outline-<?php echo $leader['is_active'] ? 'warning' : 'success'; ?> btn-sm">
                                                <i class="fas fa-<?php echo $leader['is_active'] ? 'eye-slash' : 'eye'; ?> me-1"></i>
                                                <?php echo $leader['is_active'] ? 'Deactivate' : 'Activate'; ?>
                                            </a>
                                            <a href="leadership.php?action=delete&id=<?php echo $leader['id']; ?>" 
                                               class="btn btn-outline-danger btn-sm"
                                               onclick="return confirm('Are you sure you want to remove this leader?')">
                                                <i class="fas fa-trash me-1"></i>Remove
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Add New Leader -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>Add New Leader
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="new_name" class="form-label">Name *</label>
                                <input type="text" class="form-control" id="new_name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="new_position" class="form-label">Position *</label>
                                <input type="text" class="form-control" id="new_position" name="position" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_bio" class="form-label">Biography</label>
                            <textarea class="form-control" id="new_bio" name="bio" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="new_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="new_email" name="email">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="new_phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="new_phone" name="phone">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="new_sort_order" class="form-label">Display Order</label>
                                <input type="number" class="form-control" id="new_sort_order" name="sort_order" value="<?php echo count($leaders) + 1; ?>">
                            </div>
                        </div>
                        
                        <button type="submit" name="add_leader" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i>Add Leader
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
