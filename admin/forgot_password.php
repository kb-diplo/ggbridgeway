<?php
require_once '../includes/config.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    redirect('dashboard.php');
}

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['send_reset'])) {
        $email_or_username = sanitize_input($_POST['email_or_username']);
        
        try {
            // Check if admin exists by email or username
            $stmt = $pdo->prepare("SELECT id, username, email, full_name FROM admin_accounts WHERE (email = ? OR username = ?) AND status = 'active'");
            $stmt->execute([$email_or_username, $email_or_username]);
            $admin = $stmt->fetch();
            
            if ($admin) {
                // Generate reset token
                $reset_token = bin2hex(random_bytes(32));
                $reset_expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                // Save reset token
                $stmt = $pdo->prepare("UPDATE admin_accounts SET reset_token = ?, reset_expires = ? WHERE id = ?");
                $stmt->execute([$reset_token, $reset_expires, $admin['id']]);
                
                // In a real application, you would send an email here
                // For now, we'll show the reset link
                $reset_link = SITE_URL . "/admin/reset_password.php?token=" . $reset_token;
                
                $message = "Password reset instructions have been sent. <br><br>
                          <strong>For development purposes, here's your reset link:</strong><br>
                          <a href='$reset_link' class='btn btn-sm btn-primary mt-2'>Reset Password</a><br><br>
                          <small class='text-muted'>In production, this would be sent to: " . htmlspecialchars($admin['email']) . "</small>";
                $message_type = "success";
            } else {
                $message = "No active admin account found with that email or username.";
                $message_type = "danger";
            }
        } catch(PDOException $e) {
            $message = "Error processing request. Please try again.";
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
    <title>Forgot Password - <?php echo SITE_NAME; ?></title>
    
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
        
        .forgot-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }
        
        .forgot-header {
            background: linear-gradient(135deg, var(--navy-blue), var(--maroon));
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .forgot-body {
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
                <div class="forgot-card">
                    <div class="forgot-header">
                        <h3 class="mb-2">
                            <i class="fas fa-key me-2"></i>
                            Forgot Password
                        </h3>
                        <p class="mb-0">Reset your admin password</p>
                    </div>
                    
                    <div class="forgot-body">
                        <?php if($message): ?>
                            <div class="alert alert-<?php echo $message_type; ?>" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="email_or_username" class="form-label">
                                    <i class="fas fa-user me-2"></i>Email or Username
                                </label>
                                <input type="text" class="form-control" id="email_or_username" name="email_or_username" 
                                       placeholder="Enter your email or username" required>
                                <small class="text-muted">Enter the email address or username associated with your admin account.</small>
                            </div>
                            
                            <button type="submit" name="send_reset" class="btn btn-reset">
                                <i class="fas fa-paper-plane me-2"></i>Send Reset Instructions
                            </button>
                        </form>
                        
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
