<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

// Get dashboard statistics
try {
    // Count messages
    $stmt = $pdo->prepare("SELECT COUNT(*) as total, 
                          SUM(CASE WHEN type = 'contact' THEN 1 ELSE 0 END) as contact_messages,
                          SUM(CASE WHEN type = 'admission' THEN 1 ELSE 0 END) as admission_messages,
                          SUM(CASE WHEN status = 'unread' THEN 1 ELSE 0 END) as unread_messages
                          FROM messages");
    $stmt->execute();
    $message_stats = $stmt->fetch();
    
    // Count banners
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM banners WHERE is_active = 1");
    $stmt->execute();
    $banner_count = $stmt->fetchColumn();
    
    // Count events
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM events");
    $stmt->execute();
    $event_count = $stmt->fetchColumn();
    
    // Count gallery images
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM gallery");
    $stmt->execute();
    $gallery_count = $stmt->fetchColumn();
    
    // Get recent messages
    $stmt = $pdo->prepare("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5");
    $stmt->execute();
    $recent_messages = $stmt->fetchAll();
    
} catch(PDOException $e) {
    $message_stats = ['total' => 0, 'contact_messages' => 0, 'admission_messages' => 0, 'unread_messages' => 0];
    $banner_count = 0;
    $event_count = 0;
    $gallery_count = 0;
    $recent_messages = [];
}

include 'includes/admin_header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/admin_sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="admin-header">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-calendar me-1"></i>
                                <?php echo date('F j, Y'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Messages
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $message_stats['total']; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-envelope fa-2x" style="color: var(--navy-blue);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Unread Messages
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $message_stats['unread_messages']; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-envelope-open fa-2x" style="color: var(--maroon);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Active Banners
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $banner_count; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-images fa-2x" style="color: var(--navy-blue);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Events
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $event_count; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-alt fa-2x" style="color: var(--maroon);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-bolt me-2"></i>Quick Actions
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="banners.php" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-plus-circle me-2"></i>Add Banner
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="events.php" class="btn btn-outline-success w-100">
                                        <i class="fas fa-calendar-plus me-2"></i>Add Event
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="gallery.php" class="btn btn-outline-info w-100">
                                        <i class="fas fa-image me-2"></i>Add Photo
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="messages.php" class="btn btn-outline-warning w-100">
                                        <i class="fas fa-envelope me-2"></i>View Messages
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Messages -->
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-envelope me-2"></i>Recent Messages
                            </h5>
                            <a href="messages.php" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <?php if(!empty($recent_messages)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($recent_messages as $message): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?php echo htmlspecialchars($message['name']); ?></strong><br>
                                                        <small class="text-muted"><?php echo htmlspecialchars($message['email']); ?></small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-<?php echo $message['type'] == 'admission' ? 'success' : 'info'; ?>">
                                                            <?php echo ucfirst($message['type']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small><?php echo date('M j, Y', strtotime($message['created_at'])); ?></small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-<?php echo $message['status'] == 'unread' ? 'warning' : 'secondary'; ?>">
                                                            <?php echo ucfirst($message['status']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="messages.php?view=<?php echo $message['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No messages yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Message Type Breakdown -->
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-chart-pie me-2"></i>Message Breakdown
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Contact Messages</span>
                                    <span class="badge bg-info"><?php echo $message_stats['contact_messages']; ?></span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: <?php echo $message_stats['total'] > 0 ? ($message_stats['contact_messages'] / $message_stats['total']) * 100 : 0; ?>%"></div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Admission Applications</span>
                                    <span class="badge bg-success"><?php echo $message_stats['admission_messages']; ?></span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: <?php echo $message_stats['total'] > 0 ? ($message_stats['admission_messages'] / $message_stats['total']) * 100 : 0; ?>%"></div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Total Messages</strong>
                                <span class="badge bg-primary"><?php echo $message_stats['total']; ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Gallery Stats -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-images me-2"></i>Content Stats
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <h4 style="color: var(--navy-blue);"><?php echo $gallery_count; ?></h4>
                                    <small class="text-muted">Gallery Photos</small>
                                </div>
                                <div class="col-6">
                                    <h4 style="color: var(--maroon);"><?php echo $event_count; ?></h4>
                                    <small class="text-muted">Events</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Admin Creation -->
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h6 class="m-0"><i class="fas fa-user-plus me-2"></i>Quick Admin Creation</h6>
                            </div>
                            <div class="card-body">
                                <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_admin'])) {
                                    $username = trim($_POST['username']);
                                    $password = $_POST['password'];
                                    $email = trim($_POST['email']);
                                    $full_name = trim($_POST['full_name']);
                                    
                                    if (strlen($password) >= 6) {
                                        try {
                                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                                            $stmt = $pdo->prepare("INSERT INTO admin_accounts (username, password, email, full_name, role, is_active) VALUES (?, ?, ?, ?, 'admin', 1)");
                                            $stmt->execute([$username, $hashed_password, $email, $full_name]);
                                            echo "<div class='alert alert-success'>Admin account created successfully!</div>";
                                        } catch(PDOException $e) {
                                            if ($e->getCode() == 23000) {
                                                echo "<div class='alert alert-danger'>Username already exists.</div>";
                                            } else {
                                                echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
                                            }
                                        }
                                    } else {
                                        echo "<div class='alert alert-danger'>Password must be at least 6 characters.</div>";
                                    }
                                }
                                ?>
                                <form method="POST">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" name="email" placeholder="Email">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="password" placeholder="Password (min 6 chars)" required minlength="6">
                                    </div>
                                    <button type="submit" name="create_admin" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i>Create Admin
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-info text-white">
                                <h6 class="m-0"><i class="fas fa-users me-2"></i>Current Admins</h6>
                            </div>
                            <div class="card-body">
                                <?php
                                try {
                                    $stmt = $pdo->prepare("SELECT username, full_name, role, is_active FROM admin_accounts ORDER BY created_at DESC LIMIT 5");
                                    $stmt->execute();
                                    $admins = $stmt->fetchAll();
                                    
                                    if ($admins) {
                                        foreach ($admins as $admin) {
                                            $status_color = $admin['is_active'] ? 'success' : 'secondary';
                                            $status_text = $admin['is_active'] ? 'Active' : 'Inactive';
                                            echo "<div class='d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded'>";
                                            echo "<div>";
                                            echo "<strong>" . htmlspecialchars($admin['full_name']) . "</strong><br>";
                                            echo "<small class='text-muted'>@" . htmlspecialchars($admin['username']) . " (" . ucfirst($admin['role']) . ")</small>";
                                            echo "</div>";
                                            echo "<span class='badge bg-$status_color'>$status_text</span>";
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<p class='text-muted'>No admin accounts found.</p>";
                                    }
                                } catch(PDOException $e) {
                                    echo "<p class='text-danger'>Error loading admins.</p>";
                                }
                                ?>
                                <div class="mt-3">
                                    <a href="admin_management.php" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-cog me-1"></i>Manage All Admins
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
