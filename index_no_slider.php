<?php
require_once 'includes/config.php';

$page_title = 'Home - Githunguri Bridgeway Preparatory School';
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

// Fetch active notices for homepage (remaining notices after top notification)
try {
    $stmt = $pdo->prepare("SELECT * FROM notices WHERE is_active = 1 AND show_on_homepage = 1 AND (start_date IS NULL OR start_date <= CURDATE()) AND (end_date IS NULL OR end_date >= CURDATE()) ORDER BY created_at DESC LIMIT 3 OFFSET 1");
    $stmt->execute();
    $homepage_notices = $stmt->fetchAll();
} catch(PDOException $e) {
    $homepage_notices = [];
}

include 'includes/header.php';
?>

<style>
/* Unique Hero Section - No Slider */
.hero-unique {
    min-height: 90vh;
    background: linear-gradient(135deg, 
        rgba(0,31,63,0.9) 0%, 
        rgba(128,0,0,0.8) 50%, 
        rgba(0,31,63,0.9) 100%),
        url('assets/images/githunguri_bridgewaystudents.jpeg') center/cover fixed;
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.floating-elements {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
}

.floating-shape {
    position: absolute;
    background: rgba(255,215,0,0.1);
    border-radius: 50%;
    animation: float 8s ease-in-out infinite;
}

.shape-1 {
    width: 100px;
    height: 100px;
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 150px;
    height: 150px;
    top: 60%;
    right: 15%;
    animation-delay: 3s;
}

.shape-3 {
    width: 80px;
    height: 80px;
    bottom: 30%;
    left: 70%;
    animation-delay: 6s;
}

@keyframes float {
    0%, 100% { 
        transform: translateY(0px) rotate(0deg) scale(1); 
        opacity: 0.3;
    }
    33% { 
        transform: translateY(-30px) rotate(120deg) scale(1.1); 
        opacity: 0.6;
    }
    66% { 
        transform: translateY(-15px) rotate(240deg) scale(0.9); 
        opacity: 0.4;
    }
}

.hero-content-unique {
    position: relative;
    z-index: 3;
    color: white;
    text-align: center;
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
}

.hero-title-unique {
    font-size: 3.8rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    text-shadow: 3px 3px 6px rgba(0,0,0,0.5);
    animation: slideInUp 1.2s ease-out;
    background: linear-gradient(45deg, #fff, #ffd700);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle-unique {
    font-size: 1.4rem;
    margin-bottom: 2rem;
    color: #ffd700;
    font-weight: 600;
    animation: slideInUp 1.2s ease-out 0.3s both;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.hero-description-unique {
    font-size: 1.2rem;
    margin-bottom: 3rem;
    line-height: 1.7;
    animation: slideInUp 1.2s ease-out 0.6s both;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.stats-container-unique {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin: 3rem 0;
    animation: slideInUp 1.2s ease-out 0.9s both;
}

.stat-card-unique {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 20px;
    padding: 2rem 1.5rem;
    text-align: center;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.stat-card-unique::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255,215,0,0.1), transparent);
    transform: rotate(45deg);
    transition: all 0.6s ease;
    opacity: 0;
}

.stat-card-unique:hover::before {
    opacity: 1;
    animation: shimmer 1.5s ease-in-out;
}

.stat-card-unique:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    border-color: rgba(255,215,0,0.4);
}

.stat-number-unique {
    font-size: 3rem;
    font-weight: 900;
    color: #ffd700;
    display: block;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    margin-bottom: 0.5rem;
}

.stat-label-unique {
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.cta-buttons-unique {
    animation: slideInUp 1.2s ease-out 1.2s both;
    margin-top: 3rem;
}

.btn-unique-primary {
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    color: #001F3F;
    padding: 18px 40px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    text-decoration: none;
    display: inline-block;
    margin: 0 15px 15px 0;
    transition: all 0.4s ease;
    box-shadow: 0 8px 25px rgba(255,215,0,0.3);
    position: relative;
    overflow: hidden;
}

.btn-unique-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.6s ease;
}

.btn-unique-primary:hover::before {
    left: 100%;
}

.btn-unique-primary:hover {
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 15px 35px rgba(255,215,0,0.5);
    color: #001F3F;
    text-decoration: none;
}

.btn-unique-outline {
    border: 3px solid white;
    color: white;
    padding: 15px 37px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    text-decoration: none;
    display: inline-block;
    margin: 0 15px 15px 0;
    transition: all 0.4s ease;
    background: transparent;
    position: relative;
    overflow: hidden;
}

.btn-unique-outline::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 100%;
    background: white;
    transition: width 0.4s ease;
    z-index: -1;
}

.btn-unique-outline:hover::before {
    width: 100%;
}

.btn-unique-outline:hover {
    color: #001F3F;
    transform: translateY(-5px);
    text-decoration: none;
    box-shadow: 0 10px 25px rgba(255,255,255,0.2);
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shimmer {
    0% { transform: translateX(-100%) rotate(45deg); }
    100% { transform: translateX(100%) rotate(45deg); }
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .hero-title-unique {
        font-size: 2.5rem;
    }
    
    .stats-container-unique {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .stat-card-unique {
        padding: 1.5rem 1rem;
    }
    
    .stat-number-unique {
        font-size: 2.2rem;
    }
    
    .btn-unique-primary,
    .btn-unique-outline {
        display: block;
        margin: 10px auto;
        max-width: 280px;
        text-align: center;
    }
}
</style>

<!-- Unique Hero Section (No Slider) -->
<section class="hero-unique">
    <div class="floating-elements">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
    </div>
    
    <div class="container">
        <div class="hero-content-unique">
            <h1 class="hero-title-unique">
                <?php echo htmlspecialchars(isset($content['hero_title']) ? $content['hero_title'] : 'Building Bright Futures with Strong Foundations'); ?>
            </h1>
            
            <p class="hero-subtitle-unique">
                Excellence and Integrity - Lead with Values
            </p>
            
            <p class="hero-description-unique">
                <?php echo htmlspecialchars(isset($content['hero_description']) ? $content['hero_description'] : 'Nurturing young minds through quality education and strong values at Githunguri Bridgeway Preparatory School in Kiambu County.'); ?>
            </p>
            
            <div class="stats-container-unique">
                <div class="stat-card-unique">
                    <span class="stat-number-unique"><?php echo isset($content['total_students']) ? $content['total_students'] : '40'; ?></span>
                    <div class="stat-label-unique">Happy Students</div>
                </div>
                <div class="stat-card-unique">
                    <span class="stat-number-unique"><?php echo isset($content['qualified_teachers']) ? $content['qualified_teachers'] : '8'; ?></span>
                    <div class="stat-label-unique">Qualified Teachers</div>
                </div>
                <div class="stat-card-unique">
                    <span class="stat-number-unique"><?php echo isset($content['success_rate']) ? $content['success_rate'] : '95'; ?>%</span>
                    <div class="stat-label-unique">Success Rate</div>
                </div>
                <div class="stat-card-unique">
                    <span class="stat-number-unique"><?php echo isset($content['years_experience']) ? $content['years_experience'] : '5'; ?>+</span>
                    <div class="stat-label-unique">Years Excellence</div>
                </div>
            </div>
            
            <div class="cta-buttons-unique">
                <a href="<?php echo SITE_URL; ?>/admissions.php" class="btn-unique-primary">
                    <i class="fas fa-graduation-cap me-2"></i>Enroll Your Child
                </a>
                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn-unique-outline">
                    <i class="fas fa-phone me-2"></i>Visit Our School
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Remaining Notices Section -->
<?php if(!empty($homepage_notices)): ?>
<section class="notices-section py-4" id="notices-section" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
    <div class="container">
        <div class="text-center mb-4">
            <h4 style="color: var(--navy-blue); font-weight: 600;">
                <i class="fas fa-bullhorn me-2"></i>More School Announcements
            </h4>
        </div>
        
        <div class="row">
            <?php foreach($homepage_notices as $notice): ?>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="alert alert-<?php echo $notice['type']; ?> mb-0 shadow-sm border-0" style="border-radius: 15px;">
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
                                <p class="mb-0" style="font-size: 0.9rem;"><?php echo htmlspecialchars($notice['content']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Why Choose Us Section -->
<section class="section-padding" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Why Choose Githunguri Bridgeway?</h2>
            <p>Discover what makes our school special and why parents trust us with their children's education.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="feature-card">
                    <div class="feature-icon academics">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h5 style="color: var(--navy-blue);">Academic Excellence</h5>
                    <p>Following the KCPE curriculum with proven results. Our students consistently achieve outstanding performance.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="feature-card">
                    <div class="feature-icon community">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h5 style="color: var(--navy-blue);">Caring Community</h5>
                    <p>Small class sizes ensure personalized attention and a supportive learning environment for every child.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="feature-card">
                    <div class="feature-icon excellence">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h5 style="color: var(--navy-blue);">Values-Based Education</h5>
                    <p>Excellence and Integrity - We develop not just academic skills but also character and leadership.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section-padding" style="background: linear-gradient(135deg, var(--navy-blue), var(--maroon)); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 fade-in">
                <h2 class="mb-3" style="color: white;">Ready to Join Our School Family?</h2>
                <p class="mb-0" style="font-size: 1.1rem;">Give your child the best start in life with quality education at Githunguri Bridgeway Preparatory School.</p>
            </div>
            <div class="col-lg-4 text-lg-end fade-in">
                <a href="<?php echo SITE_URL; ?>/admissions.php" class="btn-unique-primary me-2 mb-2">Apply Now</a>
                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn-unique-outline mb-2">Visit Us</a>
            </div>
        </div>
    </div>
</section>

<!-- Add notification close functionality -->
<script>
function closeNotification() {
    const notificationBar = document.getElementById('notificationBar');
    if (notificationBar) {
        notificationBar.style.animation = 'slideUp 0.5s ease-out';
        setTimeout(() => {
            notificationBar.style.display = 'none';
        }, 500);
    }
}

// Add slideUp animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideUp {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(-100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>

<?php include 'includes/footer.php'; ?>
