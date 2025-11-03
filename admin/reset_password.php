<?php
require_once '../includes/config.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    redirect('dashboard.php');
}

$message = '';
$message_type = '';
$valid_token = false;
$admin_data = null;

// Check if token is provided and valid
if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = sanitize_input($_GET['token']);
    
    try {
        $stmt = $pdo->prepare("SELECT id, username, email, full_name FROM admin_accounts WHERE reset_token = ? AND reset_expires > NOW() AND status = 'active'");
        $stmt->execute([$token]);
        $admin_data = $stmt->fetch();
        
        if ($admin_data) {
            $valid_token = true;
        } else {
            $message = "Invalid or expired reset token. Please request a new password reset.";
            $message_type = "danger";
        }
    } catch(PDOException $e) {
        $message = "Error validating reset token.";
        $message_type = "danger";
    }
} else {
    $message = "No reset token provided.";
    $message_type = "danger";
}

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $valid_token) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (strlen($new_password) < 6) {
        $message = "Password must be at least 6 characters long.";
        $message_type = "danger";
    } elseif ($new_password !== $confirm_password) {
        $message = "Passwords do not match.";
        $message_type = "danger";
    } else {
        try {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE admin_accounts SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
            $stmt->execute([$hashed_password, $admin_data['id']]);
            
            $message = "Password reset successfully! You can now login with your new password.";
            $message_type = "success";
            $valid_token = false; // Prevent further resets
        } catch(PDOException $e) {
            $message = "Error resetting password. Please try again.";
            $message_type = "danger";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - <?php echo SITE_NAME; ?></title>
    
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
        
        .reset-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }
        
        .reset-header {
            background: linear-gradient(135deg, var(--navy-blue), var(--maroon));
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .reset-body {
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
        
        .btn-reset {
            background: linear-gradient(135deg, var(--navy-blue), var(--maroon));
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-reset:hover {
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
                <div class="reset-card">
                    <div class="reset-header">
                        <h3 class="mb-2">
                            <i class="fas fa-lock me-2"></i>
                            Reset Password
                        </h3>
                        <?php if($valid_token && $admin_data): ?>
                            <p class="mb-0">Set new password for <?php echo htmlspecialchars($admin_data['username']); ?></p>
                        <?php else: ?>
                            <p class="mb-0">Password Reset</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="reset-body">
                        <?php if($message): ?>
                            <div class="alert alert-<?php echo $message_type; ?>" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($valid_token && $admin_data): ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">
                                        <i class="fas fa-key me-2"></i>New Password
                                    </label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" 
                                           required minlength="6" placeholder="Enter new password">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">
                                        <i class="fas fa-key me-2"></i>Confirm Password
                                    </label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                           required minlength="6" placeholder="Confirm new password">
                                </div>
                                
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Password must be at least 6 characters long.
                                    </small>
                                </div>
                                
                                <button type="submit" class="btn btn-reset">
                                    <i class="fas fa-save me-2"></i>Reset Password
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <div class="text-center mt-4">
                            <a href="login.php" class="text-muted text-decoration-none">
                                <i class="fas fa-arrow-left me-2"></i>Back to Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
