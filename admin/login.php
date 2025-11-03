<?php
require_once '../includes/config.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    redirect('dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize_input($_POST['username']);
    $password = $_POST['password'];
    
    try {
        // Try new admin_accounts table first
        $stmt = $pdo->prepare("SELECT id, username, password, full_name, email, role, is_active FROM admin_accounts WHERE (username = ? OR email = ?) AND is_active = 1");
        $stmt->execute([$username, $username]);
        $admin = $stmt->fetch();
        
        // If not found in new table, try old admins table for backward compatibility
        if (!$admin) {
            $stmt = $pdo->prepare("SELECT id, username, password FROM admins WHERE username = ?");
            $stmt->execute([$username]);
            $old_admin = $stmt->fetch();
            
            if ($old_admin && password_verify($password, $old_admin['password'])) {
                // Migrate old admin to new table
                $stmt = $pdo->prepare("INSERT IGNORE INTO admin_accounts (username, email, password, full_name, role, is_active) VALUES (?, ?, ?, ?, 'super_admin', 1)");
                $stmt->execute([$old_admin['username'], $old_admin['username'] . '@bridgewayschool.ac.ke', $old_admin['password'], 'Migrated Admin']);
                
                // Get the migrated admin
                $stmt = $pdo->prepare("SELECT id, username, password, full_name, email, role FROM admin_accounts WHERE username = ?");
                $stmt->execute([$old_admin['username']]);
                $admin = $stmt->fetch();
            }
        }
        
        if ($admin && password_verify($password, $admin['password'])) {
            // Update last login
            $stmt = $pdo->prepare("UPDATE admin_accounts SET last_login = NOW() WHERE id = ?");
            $stmt->execute([$admin['id']]);
            
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_role'] = isset($admin['role']) ? $admin['role'] : 'admin';
            redirect('dashboard.php');
        } else {
            $error = "Invalid credentials or account is inactive.";
        }
    } catch(PDOException $e) {
        $error = "Login error. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo SITE_NAME; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    
    <style>
        body {
            background: linear-gradient(135deg, var(--navy-blue), var(--maroon));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--navy-blue), var(--maroon));
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .login-body {
            padding: 2rem;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
        }
        
        .form-control:focus {
            border-color: var(--navy-blue);
            box-shadow: 0 0 0 0.2rem rgba(0,31,63,0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--navy-blue), var(--maroon));
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                    <div class="login-header">
                        <h3 class="mb-2">
                            <i class="fas fa-user-shield me-2"></i>
                            Admin Login
                        </h3>
                        <p class="mb-0">Githunguri Bridgeway Preparatory School</p>
                    </div>
                    
                    <div class="login-body">
                        <?php if($error): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    <i class="fas fa-user me-2"></i>Username
                                </label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </form>
                        
                        <div class="text-center mt-4">
                            <a href="forgot_password.php" class="text-decoration-none me-3">
                                <i class="fas fa-key me-1"></i>Forgot Password?
                            </a>
                            <br><br>
                            <a href="<?php echo SITE_URL; ?>" class="text-muted text-decoration-none">
                                <i class="fas fa-arrow-left me-2"></i>Back to Website
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Login Credentials Info -->
                <?php
                // Check if default admin still exists
                try {
                    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM admin_accounts WHERE username != 'admin' AND is_active = 1");
                    $stmt->execute();
                    $custom_admins = $stmt->fetchColumn();
                    
                    if ($custom_admins > 0) {
                        // Custom admin accounts exist
                        echo '<div class="card mt-3" style="background-color: rgba(40,167,69,0.2); border: 1px solid rgba(40,167,69,0.3);">
                                <div class="card-body text-center text-white">
                                    <small>
                                        <i class="fas fa-check-circle me-1"></i>
                                        <strong>Admin Account Active</strong><br>
                                        Use your custom admin credentials to login
                                    </small>
                                </div>
                              </div>';
                    } else {
                        // Only default admin exists
                        echo '<div class="card mt-3" style="background-color: rgba(255,193,7,0.2); border: 1px solid rgba(255,193,7,0.3);">
                                <div class="card-body text-center text-white">
                                    <small>
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        <strong>Default Login:</strong><br>
                                        Username: admin<br>
                                        Password: admin123<br>
                                        <em>Please create a custom admin account</em>
                                    </small>
                                </div>
                              </div>';
                    }
                } catch(PDOException $e) {
                    // Fallback if database check fails
                    echo '<div class="card mt-3" style="background-color: rgba(255,255,255,0.1); border: none;">
                            <div class="card-body text-center text-white">
                                <small>
                                    <strong>Default Login:</strong><br>
                                    Username: admin<br>
                                    Password: admin123
                                </small>
                            </div>
                          </div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Password Toggle Script -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
