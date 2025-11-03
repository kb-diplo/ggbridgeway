<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Githunguri Bridgeway Preparatory School - Excellence and Integrity, Lead with Values. Quality KCPE curriculum education in Githunguri, Kiambu County, Kenya.'; ?>">
    <meta name="keywords" content="primary school, KCPE, Githunguri, Kiambu, Kenya, education, preparatory school">
    <meta name="author" content="Githunguri Bridgeway Preparatory School">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?>">
    <meta property="og:description" content="<?php echo isset($page_description) ? $page_description : 'Excellence and Integrity - Lead with Values'; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo SITE_URL; ?>/assets/images/favicon.ico">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <!-- Logo and School Name -->
            <a class="navbar-brand d-flex align-items-center" href="<?php echo SITE_URL; ?>">
                <img src="<?php echo SITE_URL; ?>/assets/images/githunguri_bridgewaylogo.jpeg" alt="Githunguri Bridgeway Preparatory School Logo" height="50" class="me-2" style="border-radius: 8px;">
                <div>
                    <div class="brand-name">GITHUNGURI BRIDGEWAY</div>
                    <div class="brand-subtitle">PREPARATORY SCHOOL</div>
                </div>
            </a>

            <!-- Mobile Menu Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>">HOME</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown">
                            ABOUT
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/about.php">About Us</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/about.php#mission">Mission & Vision</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/about.php#history">Our History</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'academics.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/academics.php">ACADEMICS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'admissions.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/admissions.php">ADMISSIONS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'student-life.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/student-life.php">STUDENT LIFE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'careers.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/careers.php">CAREERS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/contact.php">CONTACT</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="<?php echo SITE_URL; ?>/admissions.php" class="btn-apply">APPLY ONLINE</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Top Notification Bar - Simplified -->
    <?php
    // Fetch active notices for top notification
    try {
        $stmt = $pdo->prepare("SELECT * FROM notices WHERE is_active = 1 AND show_on_homepage = 1 AND (start_date IS NULL OR start_date <= CURDATE()) AND (end_date IS NULL OR end_date >= CURDATE()) ORDER BY created_at DESC LIMIT 1");
        $stmt->execute();
        $top_notice = $stmt->fetch();
    } catch(PDOException $e) {
        $top_notice = null;
    }
    ?>
    
    <?php if($top_notice): ?>
    <div class="notification-bar-simple" id="notificationBar">
        <div class="container">
            <div class="text-center">
                <i class="fas fa-bullhorn me-2"></i>
                <strong><?php echo htmlspecialchars($top_notice['title']); ?></strong>
                <span class="ms-2"><?php echo htmlspecialchars($top_notice['content']); ?></span>
                <button class="btn-close-notification ms-3" onclick="closeNotification()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Reduced top padding for better image coverage -->
    <div style="padding-top: 60px;"></div>
