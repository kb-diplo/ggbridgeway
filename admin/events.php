<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
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
                        <i class="fas fa-calendar-alt me-2"></i>Events & News
                    </h1>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Events Management</h5>
                    <p class="text-muted">This page will allow you to manage school events and news.<br>
                    Full implementation available in the complete version.</p>
                    <a href="dashboard.php" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
