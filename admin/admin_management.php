<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Create admin management table if it doesn't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS admin_accounts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        role ENUM('super_admin', 'admin', 'editor') DEFAULT 'admin',
        status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
        last_login TIMESTAMP NULL,
        reset_token VARCHAR(100) NULL,
        reset_expires TIMESTAMP NULL,
        created_by INT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (created_by) REFERENCES admin_accounts(id) ON DELETE SET NULL
    )");
    
    // Check if default admin exists in new table
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin_accounts WHERE username = 'admin'");
    $stmt->execute();
    $default_exists = $stmt->fetchColumn();
    
    // If no accounts exist, create the default admin
    if ($default_exists == 0) {
        $stmt = $pdo->prepare("INSERT INTO admin_accounts (username, email, password, full_name, role, status) VALUES (?, ?, ?, ?, 'super_admin', 'active')");
        $stmt->execute(['admin', 'admin@bridgewayschool.ac.ke', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Default Administrator']);
    }
    
} catch(PDOException $e) {
    // Continue if table creation fails
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_admin'])) {
        $username = sanitize_input($_POST['username']);
        $email = sanitize_input($_POST['email']);
        $full_name = sanitize_input($_POST['full_name']);
        $password = $_POST['password'];
        $role = sanitize_input($_POST['role']);
        
        if (strlen($password) < 6) {
            $message = "Password must be at least 6 characters long.";
            $message_type = "danger";
        } else {
            try {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO admin_accounts (username, email, password, full_name, role, created_by) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$username, $email, $hashed_password, $full_name, $role, $_SESSION['admin_id']]);
                
                // Check if this is the first new admin being created
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin_accounts WHERE username != 'admin'");
                $stmt->execute();
                $other_admins = $stmt->fetchColumn();
                
                // If this is the first new admin, deactivate default admin
                if ($other_admins == 1) {
                    $stmt = $pdo->prepare("UPDATE admin_accounts SET status = 'inactive' WHERE username = 'admin'");
                    $stmt->execute();
                    $message = "Admin account created successfully! Default admin account has been deactivated for security.";
                } else {
                    $message = "Admin account created successfully!";
                }
                $message_type = "success";
            } catch(PDOException $e) {
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $message = "Username or email already exists.";
                } else {
                    $message = "Error creating admin account.";
                }
                $message_type = "danger";
            }
        }
    }
    
    if (isset($_POST['toggle_status'])) {
        $admin_id = (int)$_POST['admin_id'];
        $new_status = $_POST['new_status'];
        
        // Prevent deactivating yourself
        if ($admin_id == $_SESSION['admin_id']) {
            $message = "You cannot change your own status.";
            $message_type = "warning";
        } else {
            try {
                $stmt = $pdo->prepare("UPDATE admin_accounts SET status = ? WHERE id = ?");
                $stmt->execute([$new_status, $admin_id]);
                $message = "Admin status updated successfully.";
                $message_type = "success";
            } catch(PDOException $e) {
                $message = "Error updating admin status.";
                $message_type = "danger";
            }
        }
    }
    
    if (isset($_POST['reactivate_default'])) {
        try {
            $stmt = $pdo->prepare("UPDATE admin_accounts SET status = 'active' WHERE username = 'admin'");
            $stmt->execute();
            $message = "Default admin account reactivated.";
            $message_type = "success";
        } catch(PDOException $e) {
            $message = "Error reactivating default admin.";
            $message_type = "danger";
        }
    }
}

// Get all admin accounts
try {
    $stmt = $pdo->prepare("SELECT aa.*, creator.username as created_by_username FROM admin_accounts aa 
                          LEFT JOIN admin_accounts creator ON aa.created_by = creator.id 
                          ORDER BY aa.created_at DESC");
    $stmt->execute();
    $admin_accounts = $stmt->fetchAll();
} catch(PDOException $e) {
    $admin_accounts = [];
}

// Get current admin info
try {
    $stmt = $pdo->prepare("SELECT * FROM admin_accounts WHERE id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    $current_admin = $stmt->fetch();
} catch(PDOException $e) {
    $current_admin = null;
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
                        <i class="fas fa-users-cog me-2"></i>Admin Management
                    </h1>
                </div>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Current Admin Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Current Session
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Logged in as:</strong> <?php echo htmlspecialchars(isset($current_admin['full_name']) ? $current_admin['full_name'] : 'Unknown'); ?></p>
                            <p><strong>Username:</strong> <?php echo htmlspecialchars(isset($current_admin['username']) ? $current_admin['username'] : 'Unknown'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Role:</strong> 
                                <span class="badge bg-<?php echo (isset($current_admin['role']) ? $current_admin['role'] : '') == 'super_admin' ? 'danger' : 'primary'; ?>">
                                    <?php echo ucwords(str_replace('_', ' ', isset($current_admin['role']) ? $current_admin['role'] : 'Unknown')); ?>
                                </span>
                            </p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars(isset($current_admin['email']) ? $current_admin['email'] : 'Unknown'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add New Admin -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>Add New Administrator
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username *</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-control" id="role" name="role">
                                    <option value="admin">Admin</option>
                                    <option value="editor">Editor</option>
                                    <?php if((isset($current_admin['role']) ? $current_admin['role'] : '') == 'super_admin'): ?>
                                        <option value="super_admin">Super Admin</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" class="form-control" id="password" name="password" required minlength="6">
                            <small class="text-muted">Minimum 6 characters</small>
                        </div>
                        
                        <button type="submit" name="add_admin" class="btn btn-primary">
                            <i class="fas fa-user-plus me-1"></i>Create Admin Account
                        </button>
                    </form>
                </div>
            </div>

            <!-- Admin Accounts List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Administrator Accounts (<?php echo count($admin_accounts); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($admin_accounts)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Admin Details</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Last Login</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($admin_accounts as $admin): ?>
                                        <tr class="<?php echo $admin['id'] == $_SESSION['admin_id'] ? 'table-info' : ''; ?>">
                                            <td>
                                                <strong><?php echo htmlspecialchars($admin['full_name']); ?></strong>
                                                <?php if($admin['id'] == $_SESSION['admin_id']): ?>
                                                    <span class="badge bg-info ms-2">You</span>
                                                <?php endif; ?>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($admin['username']); ?><br>
                                                    <i class="fas fa-envelope me-1"></i><?php echo htmlspecialchars($admin['email']); ?>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo $admin['role'] == 'super_admin' ? 'danger' : ($admin['role'] == 'admin' ? 'primary' : 'secondary'); ?>">
                                                    <?php echo ucwords(str_replace('_', ' ', $admin['role'])); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo $admin['status'] == 'active' ? 'success' : ($admin['status'] == 'inactive' ? 'secondary' : 'warning'); ?>">
                                                    <?php echo ucfirst($admin['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small>
                                                    <?php echo date('M j, Y', strtotime($admin['created_at'])); ?><br>
                                                    <?php if($admin['created_by_username']): ?>
                                                        <span class="text-muted">by <?php echo htmlspecialchars($admin['created_by_username']); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted">System Default</span>
                                                    <?php endif; ?>
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    <?php echo $admin['last_login'] ? date('M j, Y g:i A', strtotime($admin['last_login'])) : 'Never'; ?>
                                                </small>
                                            </td>
                                            <td>
                                                <?php if($admin['id'] != $_SESSION['admin_id']): ?>
                                                    <div class="btn-group btn-group-sm">
                                                        <?php if($admin['status'] == 'active'): ?>
                                                            <form method="POST" style="display: inline;">
                                                                <input type="hidden" name="admin_id" value="<?php echo $admin['id']; ?>">
                                                                <input type="hidden" name="new_status" value="inactive">
                                                                <button type="submit" name="toggle_status" class="btn btn-outline-warning" title="Deactivate">
                                                                    <i class="fas fa-pause"></i>
                                                                </button>
                                                            </form>
                                                        <?php else: ?>
                                                            <form method="POST" style="display: inline;">
                                                                <input type="hidden" name="admin_id" value="<?php echo $admin['id']; ?>">
                                                                <input type="hidden" name="new_status" value="active">
                                                                <button type="submit" name="toggle_status" class="btn btn-outline-success" title="Activate">
                                                                    <i class="fas fa-play"></i>
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <small class="text-muted">Current User</small>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Default Admin Management -->
                        <?php 
                        $default_admin = null;
                        foreach($admin_accounts as $admin) {
                            if($admin['username'] == 'admin') {
                                $default_admin = $admin;
                                break;
                            }
                        }
                        ?>
                        
                        <?php if($default_admin && $default_admin['status'] == 'inactive'): ?>
                            <div class="alert alert-warning mt-3">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Default Admin Account</h6>
                                <p class="mb-2">The default admin account has been deactivated for security. You can reactivate it if needed:</p>
                                <form method="POST" style="display: inline;">
                                    <button type="submit" name="reactivate_default" class="btn btn-sm btn-warning" 
                                            onclick="return confirm('Are you sure you want to reactivate the default admin account?')">
                                        <i class="fas fa-unlock me-1"></i>Reactivate Default Admin
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                        
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No admin accounts found</h5>
                            <p class="text-muted">Create your first admin account using the form above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
