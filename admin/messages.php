<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Handle actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = (int)$_GET['id'];
    
    try {
        if ($action == 'delete') {
            $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Message deleted successfully.";
            $message_type = "success";
        } elseif ($action == 'mark_read') {
            $stmt = $pdo->prepare("UPDATE messages SET status = 'read' WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Message marked as read.";
            $message_type = "success";
        }
    } catch(PDOException $e) {
        $message = "Error performing action.";
        $message_type = "danger";
    }
}

// Get filter parameters
$filter_type = isset($_GET['type']) ? $_GET['type'] : 'all';
$filter_status = isset($_GET['status']) ? $_GET['status'] : 'all';

// Build query
$where_conditions = [];
$params = [];

if ($filter_type != 'all') {
    $where_conditions[] = "type = ?";
    $params[] = $filter_type;
}

if ($filter_status != 'all') {
    $where_conditions[] = "status = ?";
    $params[] = $filter_status;
}

$where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

try {
    $stmt = $pdo->prepare("SELECT * FROM messages $where_clause ORDER BY created_at DESC");
    $stmt->execute($params);
    $messages = $stmt->fetchAll();
} catch(PDOException $e) {
    $messages = [];
}

// View specific message
$view_message = null;
if (isset($_GET['view'])) {
    $view_id = (int)$_GET['view'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM messages WHERE id = ?");
        $stmt->execute([$view_id]);
        $view_message = $stmt->fetch();
        
        // Mark as read when viewing
        if ($view_message && $view_message['status'] == 'unread') {
            $stmt = $pdo->prepare("UPDATE messages SET status = 'read' WHERE id = ?");
            $stmt->execute([$view_id]);
        }
    } catch(PDOException $e) {
        $view_message = null;
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
                        <i class="fas fa-envelope me-2"></i>Messages
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="dashboard.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($view_message): ?>
                <!-- View Message Modal -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-envelope-open me-2"></i>Message Details
                        </h5>
                        <a href="messages.php" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times"></i> Close
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>From:</strong> <?php echo htmlspecialchars($view_message['name']); ?><br>
                                <strong>Email:</strong> <?php echo htmlspecialchars($view_message['email']); ?><br>
                                <?php if($view_message['phone']): ?>
                                    <strong>Phone:</strong> <?php echo htmlspecialchars($view_message['phone']); ?><br>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <strong>Type:</strong> 
                                <span class="badge bg-<?php echo $view_message['type'] == 'admission' ? 'success' : 'info'; ?>">
                                    <?php echo ucfirst($view_message['type']); ?>
                                </span><br>
                                <strong>Date:</strong> <?php echo date('F j, Y g:i A', strtotime($view_message['created_at'])); ?><br>
                                <strong>Status:</strong> 
                                <span class="badge bg-<?php echo $view_message['status'] == 'unread' ? 'warning' : 'secondary'; ?>">
                                    <?php echo ucfirst($view_message['status']); ?>
                                </span>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <strong>Message:</strong>
                            <div class="mt-2 p-3" style="background-color: #f8f9fa; border-radius: 5px;">
                                <?php echo nl2br(htmlspecialchars($view_message['message'])); ?>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="mailto:<?php echo $view_message['email']; ?>" class="btn btn-primary">
                                <i class="fas fa-reply me-1"></i>Reply via Email
                            </a>
                            <a href="tel:<?php echo $view_message['phone']; ?>" class="btn btn-success">
                                <i class="fas fa-phone me-1"></i>Call
                            </a>
                            <a href="messages.php?action=delete&id=<?php echo $view_message['id']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirmDelete('Are you sure you want to delete this message?')">
                                <i class="fas fa-trash me-1"></i>Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="type" class="form-label">Message Type</label>
                            <select name="type" id="type" class="form-select">
                                <option value="all" <?php echo $filter_type == 'all' ? 'selected' : ''; ?>>All Types</option>
                                <option value="contact" <?php echo $filter_type == 'contact' ? 'selected' : ''; ?>>Contact Messages</option>
                                <option value="admission" <?php echo $filter_type == 'admission' ? 'selected' : ''; ?>>Admission Applications</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="all" <?php echo $filter_status == 'all' ? 'selected' : ''; ?>>All Status</option>
                                <option value="unread" <?php echo $filter_status == 'unread' ? 'selected' : ''; ?>>Unread</option>
                                <option value="read" <?php echo $filter_status == 'read' ? 'selected' : ''; ?>>Read</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-1"></i>Filter
                                </button>
                                <a href="messages.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Messages List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        All Messages (<?php echo count($messages); ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($messages)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name & Contact</th>
                                        <th>Type</th>
                                        <th>Message Preview</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($messages as $msg): ?>
                                        <tr class="<?php echo $msg['status'] == 'unread' ? 'table-warning' : ''; ?>">
                                            <td>
                                                <strong><?php echo htmlspecialchars($msg['name']); ?></strong><br>
                                                <small class="text-muted">
                                                    <i class="fas fa-envelope me-1"></i><?php echo htmlspecialchars($msg['email']); ?>
                                                </small>
                                                <?php if($msg['phone']): ?>
                                                    <br><small class="text-muted">
                                                        <i class="fas fa-phone me-1"></i><?php echo htmlspecialchars($msg['phone']); ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo $msg['type'] == 'admission' ? 'success' : 'info'; ?>">
                                                    <?php echo ucfirst($msg['type']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small><?php echo htmlspecialchars(substr($msg['message'], 0, 100)) . (strlen($msg['message']) > 100 ? '...' : ''); ?></small>
                                            </td>
                                            <td>
                                                <small><?php echo date('M j, Y', strtotime($msg['created_at'])); ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo $msg['status'] == 'unread' ? 'warning' : 'secondary'; ?>">
                                                    <?php echo ucfirst($msg['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="messages.php?view=<?php echo $msg['id']; ?>" 
                                                       class="btn btn-outline-primary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php if($msg['status'] == 'unread'): ?>
                                                        <a href="messages.php?action=mark_read&id=<?php echo $msg['id']; ?>" 
                                                           class="btn btn-outline-success" title="Mark as Read">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <a href="messages.php?action=delete&id=<?php echo $msg['id']; ?>" 
                                                       class="btn btn-outline-danger" title="Delete"
                                                       onclick="return confirmDelete('Are you sure you want to delete this message?')">
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
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No messages found</h5>
                            <p class="text-muted">Messages from the contact and admission forms will appear here.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
