<nav class="admin-sidebar">
    <!-- Sidebar Brand -->
    <a href="dashboard.php" class="sidebar-brand d-flex align-items-center text-decoration-none">
        <img src="../assets/images/githunguri_bridgewaylogo.jpeg" alt="School Logo" 
             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px;">
        <div>
            <div class="fw-bold" style="font-size: 1.1rem;">BRIDGEWAY ADMIN</div>
            <div style="font-size: 0.8rem; opacity: 0.8;">Management Panel</div>
        </div>
    </a>
    
    <!-- Navigation Menu -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" 
               href="dashboard.php">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'content_verification.php' ? 'active' : ''; ?>" 
               href="content_verification.php">
                <i class="fas fa-check-circle"></i>
                Content Control Guide
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'banners.php' ? 'active' : ''; ?>" 
               href="banners.php">
                <i class="fas fa-images"></i>
                Homepage Banners
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'events.php' ? 'active' : ''; ?>" 
               href="events.php">
                <i class="fas fa-calendar-alt"></i>
                Events & News
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'gallery.php' ? 'active' : ''; ?>" 
               href="gallery.php">
                <i class="fas fa-images"></i>
                Gallery
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'content_sections.php' ? 'active' : ''; ?>" 
               href="content_sections.php">
                <i class="fas fa-edit"></i>
                Content Sections
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'downloads.php' ? 'active' : ''; ?>" 
               href="downloads.php">
                <i class="fas fa-download"></i>
                Downloads
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'media.php' ? 'active' : ''; ?>" 
               href="media.php">
                <i class="fas fa-photo-video"></i>
                Media & YouTube
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'enhanced_content.php' ? 'active' : ''; ?>" 
               href="enhanced_content.php">
                <i class="fas fa-edit"></i>
                Enhanced Content Manager
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'content.php' ? 'active' : ''; ?>" 
               href="content.php">
                <i class="fas fa-edit"></i>
                Website Content (Legacy)
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'leadership.php' ? 'active' : ''; ?>" 
               href="leadership.php">
                <i class="fas fa-user-tie"></i>
                Leadership Team
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'careers_admin.php' ? 'active' : ''; ?>" 
               href="careers_admin.php">
                <i class="fas fa-briefcase"></i>
                Career Management
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'notices.php' ? 'active' : ''; ?>" 
               href="notices.php">
                <i class="fas fa-bullhorn"></i>
                Notices
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'active' : ''; ?>" 
               href="messages.php">
                <i class="fas fa-envelope"></i>
                Messages
                <?php
                // Show unread message count
                try {
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM messages WHERE status = 'unread'");
                    $stmt->execute();
                    $unread_count = $stmt->fetchColumn();
                    if ($unread_count > 0) {
                        echo '<span class="badge bg-warning text-dark ms-2">' . $unread_count . '</span>';
                    }
                } catch(PDOException $e) {
                    // Ignore error
                }
                ?>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                View Website
            </a>
        </li>
        
        <hr style="border-color: rgba(255,255,255,0.1); margin: 1rem 0;">
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'admin_management.php' ? 'active' : ''; ?>" 
               href="admin_management.php">
                <i class="fas fa-users-cog"></i>
                Admin Management
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>" 
               href="settings.php">
                <i class="fas fa-cog"></i>
                Settings
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-danger" href="logout.php" 
               onclick="return confirm('Are you sure you want to logout?')">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </li>
    </ul>
    
    <!-- Admin Info -->
    <div class="mt-auto p-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
        <div class="text-center text-white">
            <small>
                <i class="fas fa-user-circle me-1"></i>
                <?php echo isset($_SESSION['admin_username']) ? htmlspecialchars($_SESSION['admin_username']) : 'Admin'; ?>
            </small>
        </div>
    </div>
</nav>

<div class="admin-content">
