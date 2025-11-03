<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Setup - Githunguri Bridgeway Preparatory School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #001F3F 0%, #800000 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .setup-container {
            max-width: 600px;
            margin: 50px auto;
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .setup-header {
            background: linear-gradient(135deg, #001F3F, #800000);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .setup-body {
            padding: 40px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #001F3F, #800000);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-weight: bold;
        }
        .step.active {
            background: linear-gradient(135deg, #001F3F, #800000);
            color: white;
        }
        .step.completed {
            background: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="setup-header">
            <h1><i class="fas fa-graduation-cap me-2"></i>Admin Setup</h1>
            <p class="mb-0">Githunguri Bridgeway Preparatory School</p>
        </div>
        
        <div class="setup-body">
            <?php
            require_once 'includes/config.php';
            
            $step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
            $message = '';
            $message_type = '';
            
            // Initialize database tables
            try {
                // Create admin_accounts table
                $pdo->exec("CREATE TABLE IF NOT EXISTS admin_accounts (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) UNIQUE NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(100),
                    full_name VARCHAR(100),
                    role ENUM('admin', 'editor', 'super_admin') DEFAULT 'admin',
                    is_active BOOLEAN DEFAULT TRUE,
                    last_login TIMESTAMP NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )");
                
                // Check current admin status
                $stmt = $pdo->prepare("SELECT COUNT(*) as total, SUM(CASE WHEN username = 'admin' THEN 1 ELSE 0 END) as default_count FROM admin_accounts WHERE is_active = 1");
                $stmt->execute();
                $admin_status = $stmt->fetch();
                
                $has_default = $admin_status['default_count'] > 0;
                $has_custom = ($admin_status['total'] - $admin_status['default_count']) > 0;
                
            } catch(PDOException $e) {
                $message = "Database error: " . $e->getMessage();
                $message_type = "danger";
            }
            
            // Handle form submissions
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['create_default'])) {
                    try {
                        $default_password = password_hash('admin123', PASSWORD_DEFAULT);
                        $stmt = $pdo->prepare("INSERT IGNORE INTO admin_accounts (username, password, email, full_name, role, is_active) VALUES (?, ?, ?, ?, ?, 1)");
                        $stmt->execute(['admin', $default_password, 'admin@bridgewayschool.ac.ke', 'Default Administrator', 'super_admin']);
                        $message = "Default admin account created successfully!";
                        $message_type = "success";
                        $has_default = true;
                    } catch(PDOException $e) {
                        $message = "Error creating default admin: " . $e->getMessage();
                        $message_type = "danger";
                    }
                }
                
                if (isset($_POST['create_main_admin'])) {
                    $username = trim($_POST['username']);
                    $password = $_POST['password'];
                    $email = trim($_POST['email']);
                    $full_name = trim($_POST['full_name']);
                    
                    if (strlen($password) < 6) {
                        $message = "Password must be at least 6 characters long.";
                        $message_type = "danger";
                    } else {
                        try {
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            $stmt = $pdo->prepare("INSERT INTO admin_accounts (username, password, email, full_name, role, is_active) VALUES (?, ?, ?, ?, 'super_admin', 1)");
                            $stmt->execute([$username, $hashed_password, $email, $full_name]);
                            
                            // Deactivate default admin
                            $stmt = $pdo->prepare("UPDATE admin_accounts SET is_active = 0 WHERE username = 'admin'");
                            $stmt->execute();
                            
                            $message = "Main admin account created successfully! Default admin has been deactivated.";
                            $message_type = "success";
                            $has_custom = true;
                            $has_default = false;
                            $step = 3;
                        } catch(PDOException $e) {
                            if ($e->getCode() == 23000) {
                                $message = "Username already exists. Please choose a different username.";
                                $message_type = "danger";
                            } else {
                                $message = "Error creating admin account: " . $e->getMessage();
                                $message_type = "danger";
                            }
                        }
                    }
                }
            }
            
            // Determine current step
            if (!$has_default && !$has_custom) {
                $step = 1; // Need to create default admin
            } elseif ($has_default && !$has_custom) {
                $step = 2; // Need to create main admin
            } else {
                $step = 3; // Setup complete
            }
            ?>
            
            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step <?php echo $step >= 1 ? ($step > 1 ? 'completed' : 'active') : ''; ?>">1</div>
                <div class="step <?php echo $step >= 2 ? ($step > 2 ? 'completed' : 'active') : ''; ?>">2</div>
                <div class="step <?php echo $step >= 3 ? 'active' : ''; ?>">3</div>
            </div>
            
            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if ($step == 1): ?>
                <!-- Step 1: Create Default Admin -->
                <div class="text-center">
                    <h3><i class="fas fa-user-shield me-2"></i>Step 1: Initialize Default Admin</h3>
                    <p class="text-muted">Create a temporary default admin account to get started.</p>
                    
                    <form method="POST">
                        <div class="alert alert-info">
                            <strong>Default Credentials:</strong><br>
                            Username: admin<br>
                            Password: admin123
                        </div>
                        
                        <button type="submit" name="create_default" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Create Default Admin
                        </button>
                    </form>
                </div>
                
            <?php elseif ($step == 2): ?>
                <!-- Step 2: Create Main Admin -->
                <div>
                    <h3><i class="fas fa-user-cog me-2"></i>Step 2: Create Your Main Admin Account</h3>
                    <p class="text-muted">Create your personal admin account. The default admin will be deactivated.</p>
                    
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username *</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password * (minimum 6 characters)</label>
                            <input type="password" class="form-control" id="password" name="password" required minlength="6">
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Important:</strong> After creating this account, the default admin (admin/admin123) will be deactivated for security.
                        </div>
                        
                        <button type="submit" name="create_main_admin" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-user-plus me-2"></i>Create Main Admin Account
                        </button>
                    </form>
                </div>
                
            <?php else: ?>
                <!-- Step 3: Setup Complete -->
                <div class="text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="text-success">Setup Complete!</h3>
                    <p class="text-muted">Your admin account is ready. You can now access the admin panel.</p>
                    
                    <div class="alert alert-success">
                        <i class="fas fa-info-circle me-2"></i>
                        The default admin account has been deactivated for security. Use your custom credentials to login.
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="custom-admin.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Go to Admin Login
                        </a>
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>Back to Website
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($step < 3): ?>
                <div class="text-center mt-4">
                    <a href="index.php" class="text-muted text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>Back to Website
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
