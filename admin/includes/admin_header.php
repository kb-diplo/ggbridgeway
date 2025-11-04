<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo SITE_NAME; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    
    <style>
        .admin-sidebar {
            background-color: var(--navy-blue);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            overflow-y: hidden; /* Remove scrollbar */
            padding-bottom: 0;
        }
        
        .admin-content {
            margin-left: 250px;
            padding: 0;
            min-height: 100vh;
        }
        
        .admin-content main {
            padding: 80px 2rem 2rem 2rem; /* Top padding for header, left/right padding for content */
        }
        
        .nav-link {
            color: #ccc !important;
            padding: 1rem 1.5rem;
            border-radius: 0;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .nav-link:hover,
        .nav-link.active {
            background-color: var(--maroon) !important;
            color: white !important;
            border-left-color: white;
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background-color: var(--navy-blue);
            border-color: var(--navy-blue);
        }
        
        .btn-primary:hover {
            background-color: var(--maroon);
            border-color: var(--maroon);
        }
        
        .text-primary {
            color: var(--navy-blue) !important;
        }
        
        .bg-primary {
            background-color: var(--navy-blue) !important;
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                margin-left: -250px;
                transition: margin-left 0.3s ease;
            }
            
            .admin-sidebar.show {
                margin-left: 0;
            }
            
            .admin-content {
                margin-left: 0;
            }
            
            .mobile-menu-btn {
                display: block !important;
            }
        }
        
        .mobile-menu-btn {
            display: none;
        }
    </style>
</head>
<body>
    <script>
        function toggleSidebar() {
            document.querySelector('.admin-sidebar').classList.toggle('show');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.querySelector('.admin-sidebar');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !menuBtn.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>

    <!-- Admin Top Header -->
    <div class="admin-top-header" style="background: white; border-bottom: 1px solid #dee2e6; padding: 0.75rem 1rem; position: fixed; top: 0; left: 250px; right: 0; z-index: 999; height: 60px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-secondary btn-sm me-3 d-md-none" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h6 class="mb-0 text-muted">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Admin Dashboard - <?php echo SITE_NAME; ?>
                </h6>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-3 text-muted">
                    <i class="fas fa-user-circle me-1"></i>
                    Welcome, <?php echo isset($_SESSION['admin_username']) ? htmlspecialchars($_SESSION['admin_username']) : 'Admin'; ?>
                </span>
                <a href="<?php echo SITE_URL; ?>" target="_blank" class="btn btn-outline-primary btn-sm me-2" title="View Website">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                <a href="logout.php" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to logout?')" title="Logout">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            </div>
        </div>
    </div>
