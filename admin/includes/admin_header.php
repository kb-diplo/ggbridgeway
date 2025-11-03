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
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .admin-content {
            margin-left: 250px;
            padding: 0;
        }
        
        .admin-header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 2rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            color: white;
            text-decoration: none;
        }
        
        .sidebar-brand:hover {
            color: white;
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
    <!-- Mobile Menu Button -->
    <button class="btn btn-primary mobile-menu-btn position-fixed" 
            style="top: 10px; left: 10px; z-index: 1001;" 
            onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

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
