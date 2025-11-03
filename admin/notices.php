<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Create notices table if it doesn't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS notices (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        type ENUM('info', 'warning', 'success', 'danger') DEFAULT 'info',
        is_active BOOLEAN DEFAULT TRUE,
        show_on_homepage BOOLEAN DEFAULT FALSE,
        start_date DATE NULL,
        end_date DATE NULL,
        created_by INT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
} catch(PDOException $e) {
    // Continue if table creation fails
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_notice'])) {
        $title = sanitize_input($_POST['title']);
        $content = sanitize_input($_POST['content']);
        $type = sanitize_input($_POST['type']);
        $show_on_homepage = isset($_POST['show_on_homepage']) ? 1 : 0;
        $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
        $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
        
        try {
            $stmt = $pdo->prepare("INSERT INTO notices (title, content, type, show_on_homepage, start_date, end_date, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $content, $type, $show_on_homepage, $start_date, $end_date, $_SESSION['admin_id']]);
            $message = "Notice added successfully!";
            $message_type = "success";
        } catch(PDOException $e) {
            $message = "Error adding notice.";
            $message_type = "danger";
        }
    }
    
    if (isset($_POST['update_notice'])) {
        $id = (int)$_POST['notice_id'];
        $title = sanitize_input($_POST['title']);
        $content = sanitize_input($_POST['content']);
        $type = sanitize_input($_POST['type']);
        $show_on_homepage = isset($_POST['show_on_homepage']) ? 1 : 0;
        $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
        $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
        
        try {
            $stmt = $pdo->prepare("UPDATE notices SET title = ?, content = ?, type = ?, show_on_homepage = ?, start_date = ?, end_date = ? WHERE id = ?");
            $stmt->execute([$title, $content, $type, $show_on_homepage, $start_date, $end_date, $id]);
            $message = "Notice updated successfully!";
            $message_type = "success";
        } catch(PDOException $e) {
            $message = "Error updating notice.";
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
            $stmt = $pdo->prepare("DELETE FROM notices WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Notice deleted successfully.";
            $message_type = "success";
        } elseif ($action == 'toggle') {
            $stmt = $pdo->prepare("UPDATE notices SET is_active = NOT is_active WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Notice status updated.";
            $message_type = "success";
        }
    } catch(PDOException $e) {
        $message = "Error performing action.";
        $message_type = "danger";
    }
}

// Get notices
try {
    $stmt = $pdo->prepare("SELECT * FROM notices ORDER BY created_at DESC");
    $stmt->execute();
    $notices = $stmt->fetchAll();
} catch(PDOException $e) {
    $notices = [];
}

// Get notice for editing
$edit_notice = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM notices WHERE id = ?");
        $stmt->execute([(int)$_GET['edit']]);
        $edit_notice = $stmt->fetch();
    } catch(PDOException $e) {
        // Continue if fetch fails
    }
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
                        <i class="fas fa-bullhorn me-2"></i>Notices Management
                    </h1>
                </div>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Add/Edit Notice Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-<?php echo $edit_notice ? 'edit' : 'plus'; ?> me-2"></i>
                        <?php echo $edit_notice ? 'Edit Notice' : 'Add New Notice'; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <?php if($edit_notice): ?>
                            <input type="hidden" name="notice_id" value="<?php echo $edit_notice['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="title" class="form-label">Notice Title *</label>
                                <input type="text" class="form-control" id="title" name="title" 
                                       value="<?php echo $edit_notice ? htmlspecialchars($edit_notice['title']) : ''; ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="type" class="form-label">Notice Type</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="info" <?php echo ($edit_notice && $edit_notice['type'] == 'info') ? 'selected' : ''; ?>>Info (Blue)</option>
                                    <option value="success" <?php echo ($edit_notice && $edit_notice['type'] == 'success') ? 'selected' : ''; ?>>Success (Green)</option>
                                    <option value="warning" <?php echo ($edit_notice && $edit_notice['type'] == 'warning') ? 'selected' : ''; ?>>Warning (Yellow)</option>
                                    <option value="danger" <?php echo ($edit_notice && $edit_notice['type'] == 'danger') ? 'selected' : ''; ?>>Important (Red)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Notice Content *</label>
                            <textarea class="form-control" id="content" name="content" rows="4" required><?php echo $edit_notice ? htmlspecialchars($edit_notice['content']) : ''; ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Start Date (Optional)</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                       value="<?php echo $edit_notice ? $edit_notice['start_date'] : ''; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date (Optional)</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                       value="<?php echo $edit_notice ? $edit_notice['end_date'] : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="show_on_homepage" name="show_on_homepage" 
                                       <?php echo ($edit_notice && $edit_notice['show_on_homepage']) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="show_on_homepage">
                                    Show on Homepage
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" name="<?php echo $edit_notice ? 'update_notice' : 'add_notice'; ?>" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i><?php echo $edit_notice ? 'Update Notice' : 'Add Notice'; ?>
                            </button>
                            <?php if($edit_notice): ?>
                                <a href="notices.php" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Cancel Edit
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notices List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">All Notices (<?php echo count($notices); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($notices)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Notice</th>
                                        <th>Type</th>
                                        <th>Display Period</th>
                                        <th>Status</th>
                                        <th>Homepage</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($notices as $notice): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($notice['title']); ?></strong><br>
                                                <small class="text-muted"><?php echo htmlspecialchars(substr($notice['content'], 0, 100)) . (strlen($notice['content']) > 100 ? '...' : ''); ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo $notice['type']; ?>">
                                                    <?php echo ucfirst($notice['type']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small>
                                                    <?php if($notice['start_date'] || $notice['end_date']): ?>
                                                        <?php echo $notice['start_date'] ? date('M j, Y', strtotime($notice['start_date'])) : 'No start'; ?>
                                                        <br>to<br>
                                                        <?php echo $notice['end_date'] ? date('M j, Y', strtotime($notice['end_date'])) : 'No end'; ?>
                                                    <?php else: ?>
                                                        Always Active
                                                    <?php endif; ?>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo $notice['is_active'] ? 'success' : 'secondary'; ?>">
                                                    <?php echo $notice['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if($notice['show_on_homepage']): ?>
                                                    <i class="fas fa-home text-success" title="Shown on Homepage"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-home text-muted" title="Not on Homepage"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="notices.php?edit=<?php echo $notice['id']; ?>" class="btn btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="notices.php?action=toggle&id=<?php echo $notice['id']; ?>" 
                                                       class="btn btn-outline-<?php echo $notice['is_active'] ? 'warning' : 'success'; ?>" 
                                                       title="<?php echo $notice['is_active'] ? 'Deactivate' : 'Activate'; ?>">
                                                        <i class="fas fa-<?php echo $notice['is_active'] ? 'eye-slash' : 'eye'; ?>"></i>
                                                    </a>
                                                    <a href="notices.php?action=delete&id=<?php echo $notice['id']; ?>" 
                                                       class="btn btn-outline-danger" title="Delete"
                                                       onclick="return confirm('Are you sure you want to delete this notice?')">
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
                            <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No notices created</h5>
                            <p class="text-muted">Create your first notice using the form above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
