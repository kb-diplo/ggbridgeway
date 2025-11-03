<?php
require_once 'includes/config.php';

// Auto-initialize database on first visit (inline)
try {
    // Check if initialization is needed
    $init_needed = false;
    
    // Check if admin_accounts table exists and has data
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM admin_accounts");
        $admin_count = $stmt->fetchColumn();
        if ($admin_count == 0) {
            $init_needed = true;
        }
    } catch(PDOException $e) {
        $init_needed = true;
    }
    
    if ($init_needed) {
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
        
        // Create notices table
        $pdo->exec("CREATE TABLE IF NOT EXISTS notices (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            content TEXT NOT NULL,
            type ENUM('info', 'warning', 'success', 'danger') DEFAULT 'info',
            is_active BOOLEAN DEFAULT TRUE,
            show_on_homepage BOOLEAN DEFAULT FALSE,
            start_date DATE NULL,
            end_date DATE NULL,
            created_by INT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
        
        // Create banners table
        $pdo->exec("CREATE TABLE IF NOT EXISTS banners (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            image VARCHAR(255),
            button_text VARCHAR(100),
            button_link VARCHAR(255),
            sort_order INT DEFAULT 0,
            is_active BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Create default admin account
        $default_password = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT IGNORE INTO admin_accounts (username, password, email, full_name, role, is_active) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->execute(['admin', $default_password, 'admin@bridgewayschool.ac.ke', 'Default Administrator', 'super_admin']);
        
        // Add sample notices
        $stmt = $pdo->prepare("INSERT IGNORE INTO notices (title, content, type, show_on_homepage, is_active) VALUES (?, ?, ?, ?, 1)");
        $stmt->execute(['Welcome to Our School Website', 'We are excited to share our new website with the community. Stay updated with school news and events.', 'success', 1]);
        
        // Add sample banners
        $stmt = $pdo->prepare("INSERT IGNORE INTO banners (title, description, image, button_text, button_link, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, 1)");
        $stmt->execute(['Welcome to Githunguri Bridgeway Preparatory School', 'Building Bright Futures with Strong Foundations - Excellence and Integrity, Lead with Values', 'assets/images/githunguri_bridgewaystudents.jpeg', 'Learn More', 'about.php', 1]);
    }
} catch(PDOException $e) {
    // Silent fail - initialization will be attempted again on next visit
}

$page_title = 'Home';
$page_description = 'Githunguri Bridgeway Preparatory School - Building Bright Futures with Strong Foundations. Quality primary education in Githunguri, Kiambu County following KCPE curriculum.';

// Fetch dynamic content
$content = [];
try {
    $stmt = $pdo->prepare("SELECT content_key, content_value FROM site_content");
    $stmt->execute();
    $results = $stmt->fetchAll();
    foreach ($results as $row) {
        $content[$row['content_key']] = $row['content_value'];
    }
} catch(PDOException $e) {
    // Default content if database fails
    $content = [
        'hero_title' => 'Building Bright Futures with Strong Foundations',
        'hero_subtitle' => 'Excellence and Integrity - Lead with Values',
        'hero_description' => 'Nurturing young minds through quality education and strong values at Githunguri Bridgeway Preparatory School.',
        'total_students' => '40',
        'qualified_teachers' => '8',
        'years_experience' => '5',
        'success_rate' => '95'
    ];
}

// Fetch banners for hero slider
try {
    $stmt = $pdo->prepare("SELECT * FROM banners WHERE is_active = 1 ORDER BY sort_order ASC");
    $stmt->execute();
    $banners = $stmt->fetchAll();
} catch(PDOException $e) {
    $banners = [];
}

// Fetch featured events
try {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE is_featured = 1 ORDER BY date DESC LIMIT 3");
    $stmt->execute();
    $featured_events = $stmt->fetchAll();
} catch(PDOException $e) {
    $featured_events = [];
}

// Fetch gallery images for preview
try {
    $stmt = $pdo->prepare("SELECT * FROM gallery ORDER BY created_at DESC LIMIT 6");
    $stmt->execute();
    $gallery_preview = $stmt->fetchAll();
} catch(PDOException $e) {
    $gallery_preview = [];
}

// Fetch active notices for homepage
try {
    $stmt = $pdo->prepare("SELECT * FROM notices WHERE is_active = 1 AND show_on_homepage = 1 AND (start_date IS NULL OR start_date <= CURDATE()) AND (end_date IS NULL OR end_date >= CURDATE()) ORDER BY created_at DESC LIMIT 3");
    $stmt->execute();
    $homepage_notices = $stmt->fetchAll();
} catch(PDOException $e) {
    $homepage_notices = [];
}

include 'includes/header.php';
?>

<!-- Hero Section with Carousel -->
<section class="hero-section">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <?php for($i = 0; $i < count($banners); $i++): ?>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?php echo $i; ?>" 
                        <?php echo $i === 0 ? 'class="active"' : ''; ?>></button>
            <?php endfor; ?>
        </div>
        
        <div class="carousel-inner">
            <?php if(empty($banners)): ?>
                <!-- Default slide with dynamic content -->
                <div class="carousel-item active" style="background-image: linear-gradient(45deg, rgba(0,31,63,0.8), rgba(128,0,0,0.6)), url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');">
                    <div class="carousel-overlay">
                        <div class="hero-content">
                            <div class="hero-tagline">#ExcellenceAndIntegrity #LeadWithValues</div>
                            <h1><?php echo htmlspecialchars(isset($content['hero_title']) ? $content['hero_title'] : 'Building Bright Futures with Strong Foundations'); ?></h1>
                            <p><?php echo htmlspecialchars(isset($content['hero_description']) ? $content['hero_description'] : 'Nurturing young minds through quality education and strong values at Githunguri Bridgeway Preparatory School.'); ?></p>
                            <div class="hero-buttons">
                                <a href="<?php echo SITE_URL; ?>/admissions.php" class="btn-primary-custom">
                                    <i class="fas fa-graduation-cap me-2"></i>ENROLL TODAY
                                </a>
                                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn-outline-custom">
                                    <i class="fas fa-phone me-2"></i>CONTACT US
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach($banners as $index => $banner): ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>" 
                         style="background-image: linear-gradient(45deg, rgba(0,31,63,0.8), rgba(128,0,0,0.6)), url('<?php echo SITE_URL . '/' . $banner['image']; ?>');">
                        <div class="carousel-overlay">
                            <div class="hero-content">
                                <div class="hero-tagline">#ExcellenceAndIntegrity #LeadWithValues</div>
                                <h1><?php echo htmlspecialchars($banner['title']); ?></h1>
                                <p><?php echo htmlspecialchars($banner['description']); ?></p>
                                <div class="hero-buttons">
                                    <?php if(!empty($banner['youtube_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($banner['youtube_url']); ?>" target="_blank" class="btn-primary-custom">
                                            <i class="fab fa-youtube me-2"></i>WATCH VIDEO
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($banner['button_link'])): ?>
                                        <a href="<?php echo htmlspecialchars($banner['button_link']); ?>" class="btn-outline-custom">
                                            <i class="fas fa-arrow-right me-2"></i><?php echo strtoupper(!empty($banner['button_text']) ? $banner['button_text'] : 'LEARN MORE'); ?>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo SITE_URL; ?>/admissions.php" class="btn-outline-custom">
                                            <i class="fas fa-graduation-cap me-2"></i>ENROLL TODAY
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Carousel controls removed for cleaner design -->
    </div>
</section>

<!-- Notices Section - Always Visible and Stable -->
<section class="notices-section py-4" id="notices-section" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); position: relative; z-index: 1;">
    <div class="container">
        <div class="text-center mb-4">
            <h4 style="color: var(--navy-blue); font-weight: 600;">
                <i class="fas fa-bullhorn me-2"></i>School Notices & Announcements
            </h4>
            <p class="text-muted mb-0">Stay updated with the latest news from Githunguri Bridgeway Preparatory School</p>
        </div>
        
        <?php if(!empty($homepage_notices)): ?>
            <div class="row">
                <?php foreach($homepage_notices as $notice): ?>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="alert alert-<?php echo $notice['type']; ?> mb-0 shadow-sm border-0" style="border-radius: 15px; transition: all 0.3s ease;">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <?php
                                    $icons = [
                                        'info' => 'fas fa-info-circle',
                                        'success' => 'fas fa-check-circle',
                                        'warning' => 'fas fa-exclamation-triangle',
                                        'danger' => 'fas fa-exclamation-circle'
                                    ];
                                    ?>
                                    <i class="<?php echo isset($icons[$notice['type']]) ? $icons[$notice['type']] : 'fas fa-bullhorn'; ?> fa-lg"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="alert-heading mb-2 fw-bold"><?php echo htmlspecialchars($notice['title']); ?></h6>
                                    <p class="mb-0" style="font-size: 0.9rem; line-height: 1.4;"><?php echo htmlspecialchars($notice['content']); ?></p>
                                    <small class="text-muted mt-2 d-block">
                                        <i class="fas fa-clock me-1"></i>
                                        <?php echo date('M j, Y', strtotime($notice['created_at'])); ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Default notices when none are posted -->
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="alert alert-info mb-0 shadow-sm border-0" style="border-radius: 15px;">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="fas fa-graduation-cap fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-2 fw-bold">Welcome to Our School</h6>
                                <p class="mb-0" style="font-size: 0.9rem;">We provide quality primary education following the KCPE curriculum. Contact us for more information about enrollment.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="alert alert-success mb-0 shadow-sm border-0" style="border-radius: 15px;">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="fas fa-phone fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-2 fw-bold">Contact Information</h6>
                                <p class="mb-0" style="font-size: 0.9rem;">Call us at <?php echo SCHOOL_PHONE; ?> or visit us behind Githunguri Holy Family Catholic Church.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="alert alert-warning mb-0 shadow-sm border-0" style="border-radius: 15px;">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="fas fa-calendar fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-2 fw-bold">School Hours</h6>
                                <p class="mb-0" style="font-size: 0.9rem;">Monday - Friday: 7:00 AM - 5:00 PM. Saturday: 8:00 AM - 12:00 PM for special programs.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="text-center mt-3">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                For more information, please contact the school office at <?php echo SCHOOL_PHONE; ?>
            </small>
        </div>
    </div>
</section>

<!-- Welcome Section -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in">
                <div class="section-title text-start">
                    <h2>Welcome to Our School</h2>
                    <p class="text-start">At Githunguri Bridgeway Preparatory School, we are committed to providing quality education that nurtures young minds and builds character. Our dedicated team of educators ensures every child receives personalized attention in a safe and supportive environment.</p>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3" style="color: var(--navy-blue); font-size: 2rem;">
                                <i class="fas fa-award"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Excellence in Education</h6>
                                <small class="text-muted">KCPE focused curriculum</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3" style="color: var(--maroon); font-size: 2rem;">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Caring Environment</h6>
                                <small class="text-muted">Nurturing young minds</small>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo SITE_URL; ?>/about.php" class="btn-primary-custom mt-3">Learn More About Us</a>
            </div>
            <div class="col-lg-6 fade-in">
                <img src="https://images.unsplash.com/photo-1497486751825-1233686d5d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Students in classroom" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="stats-section section-padding">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 fade-in">
                <div class="stat-item">
                    <span class="stat-number" data-target="<?php echo isset($content['total_students']) ? $content['total_students'] : '40'; ?>">0</span>
                    <div class="stat-label">Happy Students</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 fade-in">
                <div class="stat-item">
                    <span class="stat-number" data-target="<?php echo isset($content['qualified_teachers']) ? $content['qualified_teachers'] : '8'; ?>">0</span>
                    <div class="stat-label">Qualified Teachers</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 fade-in">
                <div class="stat-item">
                    <span class="stat-number" data-target="<?php echo isset($content['years_experience']) ? $content['years_experience'] : '5'; ?>">0</span>
                    <div class="stat-label">Years of Excellence</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 fade-in">
                <div class="stat-item">
                    <span class="stat-number" data-target="<?php echo isset($content['success_rate']) ? $content['success_rate'] : '95'; ?>">0</span>
                    <div class="stat-label">% Success Rate</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Why Choose Githunguri Bridgeway?</h2>
            <p>We provide a comprehensive educational experience that prepares students for academic success and life beyond the classroom.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body text-center">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h5>KCPE Curriculum</h5>
                        <p>Our curriculum is aligned with the Kenya Certificate of Primary Education (KCPE) standards, ensuring students are well-prepared for national examinations.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body text-center">
                        <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5>Small Class Sizes</h5>
                        <p>We maintain small class sizes to ensure personalized attention for each student, fostering better learning outcomes and individual growth.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body text-center">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-medal"></i>
                        </div>
                        <h5>Experienced Teachers</h5>
                        <p>Our team of qualified and experienced educators are passionate about teaching and committed to student success.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body text-center">
                        <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h5>Modern Facilities</h5>
                        <p>State-of-the-art classrooms, computer lab, library, and sports facilities provide a conducive learning environment.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body text-center">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>Safe Environment</h5>
                        <p>We prioritize student safety and well-being with secure premises, trained staff, and comprehensive safety protocols.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body text-center">
                        <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                            <i class="fas fa-star"></i>
                        </div>
                        <h5>Holistic Development</h5>
                        <p>Beyond academics, we focus on character building, leadership skills, and co-curricular activities for well-rounded development.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Events Section -->
<?php if(!empty($featured_events)): ?>
<section class="section-padding">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Upcoming Events</h2>
            <p>Stay updated with our latest school events and activities.</p>
        </div>
        
        <div class="row">
            <?php foreach($featured_events as $event): ?>
                <div class="col-lg-4 col-md-6 mb-4 fade-in">
                    <div class="card-custom h-100">
                        <?php if($event['image']): ?>
                            <img src="<?php echo SITE_URL . '/' . UPLOAD_PATH . $event['image']; ?>" 
                                 class="card-img-top" alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                 style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    <?php echo date('F j, Y', strtotime($event['date'])); ?>
                                </small>
                            </div>
                            <h5><?php echo htmlspecialchars($event['title']); ?></h5>
                            <p><?php echo htmlspecialchars(substr($event['details'], 0, 100)) . '...'; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center">
            <a href="<?php echo SITE_URL; ?>/student-life.php#events" class="btn-primary-custom">View All Events</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Gallery Preview Section -->
<?php if(!empty($gallery_images)): ?>
<section class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>School Life Gallery</h2>
            <p>Glimpses of our vibrant school community and activities.</p>
        </div>
        
        <div class="row">
            <?php foreach(array_slice($gallery_images, 0, 6) as $image): ?>
                <div class="col-lg-4 col-md-6 mb-4 fade-in">
                    <div class="gallery-item">
                        <img src="<?php echo SITE_URL . '/' . UPLOAD_PATH . $image['image']; ?>" 
                             alt="<?php echo htmlspecialchars($image['caption']); ?>" 
                             class="img-fluid">
                        <div class="gallery-overlay">
                            <span><?php echo htmlspecialchars($image['caption']); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center">
            <a href="<?php echo SITE_URL; ?>/student-life.php#gallery" class="btn-primary-custom">View Full Gallery</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Call to Action Section -->
<section class="section-padding" style="background: linear-gradient(135deg, var(--navy-blue), var(--maroon)); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 fade-in">
                <h2 class="mb-3" style="color: white;">Ready to Join Our School Family?</h2>
                <p class="mb-0" style="font-size: 1.1rem;">Give your child the best start in life with quality education at Githunguri Bridgeway Preparatory School. Our admissions are now open for the new academic year.</p>
            </div>
            <div class="col-lg-4 text-lg-end fade-in">
                <a href="<?php echo SITE_URL; ?>/admissions.php" class="btn-primary-custom me-2 mb-2">Apply Now</a>
                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn-outline-custom mb-2">Schedule Visit</a>
            </div>
        </div>
    </div>
</section>

<div id="alert-container"></div>

<?php include 'includes/footer.php'; ?>
