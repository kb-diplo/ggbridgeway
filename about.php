<?php
require_once 'includes/config.php';

$page_title = 'About Us';
$page_description = 'Learn about Githunguri Bridgeway Preparatory School - our history, mission, vision, values, and commitment to educational excellence in Kiambu County.';

// Fetch leadership team
try {
    $stmt = $pdo->prepare("SELECT * FROM leadership WHERE is_active = 1 ORDER BY sort_order ASC, created_at ASC");
    $stmt->execute();
    $leadership_team = $stmt->fetchAll();
} catch(PDOException $e) {
    $leadership_team = [];
}

include 'includes/header.php';
?>

<!-- Breadcrumb Section -->
<section class="breadcrumb-section">
    <div class="container">
        <h1>About Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">About Us</li>
            </ol>
        </nav>
    </div>
</section>

<!-- About Introduction -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in">
                <div class="section-title text-start">
                    <h2>Excellence and Integrity - Lead with Values</h2>
                    <p class="text-start">Githunguri Bridgeway Preparatory School is a premier educational institution located in the heart of Githunguri, Kiambu County, Kenya. We are dedicated to providing quality education that nurtures young minds and builds character for future leaders.</p>
                </div>
                
                <p>Founded on the principles of excellence and integrity, our school has been a beacon of quality education in the community. We believe that every child has unique potential, and our role is to unlock that potential through innovative teaching methods, personalized attention, and a supportive learning environment.</p>
                
                <p>Our commitment goes beyond academic achievement. We strive to develop well-rounded individuals who are not only academically competent but also morally upright, socially responsible, and ready to face the challenges of tomorrow.</p>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle text-success me-3" style="font-size: 1.5rem;"></i>
                            <span>KCPE Curriculum Excellence</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle text-success me-3" style="font-size: 1.5rem;"></i>
                            <span>Qualified Teaching Staff</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle text-success me-3" style="font-size: 1.5rem;"></i>
                            <span>Modern Learning Facilities</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle text-success me-3" style="font-size: 1.5rem;"></i>
                            <span>Character Development Focus</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 fade-in">
                <div class="about-image-container" style="position: relative; height: 500px; overflow: hidden; border-radius: 15px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                    <img src="assets/images/githunguri_bridgewaystudents.jpeg" 
                         alt="Our Students" 
                         style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                    <div class="image-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,31,63,0.8)); color: white; padding: 20px;">
                        <h5 class="mb-1">Our Learning Environment</h5>
                        <p class="mb-0" style="font-size: 0.9rem;">Students engaged in quality education at Githunguri Bridgeway Preparatory School</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission, Vision, Values -->
<section id="mission" class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Our Mission, Vision & Values</h2>
            <p>The guiding principles that drive our commitment to educational excellence.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 mb-4 fade-in">
                <div class="card-custom h-100 text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h4 style="color: var(--navy-blue);">Our Mission</h4>
                        <p>To provide quality, holistic education that nurtures young minds, builds character, and prepares students for academic excellence and responsible citizenship in a rapidly changing world.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4 fade-in">
                <div class="card-custom h-100 text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h4 style="color: var(--maroon);">Our Vision</h4>
                        <p>To be the leading preparatory school in Kenya, recognized for academic excellence, character development, and producing confident, competent, and compassionate global citizens.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4 fade-in">
                <div class="card-custom h-100 text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4 style="color: var(--navy-blue);">Our Values</h4>
                        <ul class="list-unstyled text-start">
                            <li class="mb-2"><i class="fas fa-star text-warning me-2"></i>Excellence in all endeavors</li>
                            <li class="mb-2"><i class="fas fa-star text-warning me-2"></i>Integrity and honesty</li>
                            <li class="mb-2"><i class="fas fa-star text-warning me-2"></i>Respect and inclusivity</li>
                            <li class="mb-2"><i class="fas fa-star text-warning me-2"></i>Innovation and creativity</li>
                            <li class="mb-2"><i class="fas fa-star text-warning me-2"></i>Community service</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- School History -->
<section id="history" class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in">
                <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="School history" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6 fade-in">
                <div class="section-title text-start">
                    <h2>Our History</h2>
                    <p class="text-start">A legacy of educational excellence spanning over a decade.</p>
                </div>
                
                <div class="timeline">
                    <div class="timeline-item mb-4">
                        <div class="d-flex">
                            <div class="timeline-marker me-3">
                                <div class="bg-primary rounded-circle" style="width: 12px; height: 12px; margin-top: 6px;"></div>
                            </div>
                            <div>
                                <h6 class="mb-1" style="color: var(--navy-blue);">2009 - Foundation</h6>
                                <p class="mb-0">Githunguri Bridgeway Preparatory School was established with a vision to provide quality education to the children of Githunguri and surrounding areas.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item mb-4">
                        <div class="d-flex">
                            <div class="timeline-marker me-3">
                                <div class="bg-success rounded-circle" style="width: 12px; height: 12px; margin-top: 6px;"></div>
                            </div>
                            <div>
                                <h6 class="mb-1" style="color: var(--navy-blue);">2012 - First KCPE Graduates</h6>
                                <p class="mb-0">Our first class of KCPE candidates achieved remarkable results, establishing our reputation for academic excellence.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item mb-4">
                        <div class="d-flex">
                            <div class="timeline-marker me-3">
                                <div class="bg-warning rounded-circle" style="width: 12px; height: 12px; margin-top: 6px;"></div>
                            </div>
                            <div>
                                <h6 class="mb-1" style="color: var(--navy-blue);">2015 - Facility Expansion</h6>
                                <p class="mb-0">Major expansion of school facilities including new classrooms, computer lab, and improved playground areas.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item mb-4">
                        <div class="d-flex">
                            <div class="timeline-marker me-3">
                                <div class="bg-info rounded-circle" style="width: 12px; height: 12px; margin-top: 6px;"></div>
                            </div>
                            <div>
                                <h6 class="mb-1" style="color: var(--navy-blue);">2020 - Digital Learning</h6>
                                <p class="mb-0">Embraced digital learning platforms and technology integration to enhance the educational experience.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="d-flex">
                            <div class="timeline-marker me-3">
                                <div class="bg-danger rounded-circle" style="width: 12px; height: 12px; margin-top: 6px;"></div>
                            </div>
                            <div>
                                <h6 class="mb-1" style="color: var(--navy-blue);">2024 - Continued Excellence</h6>
                                <p class="mb-0">Today, we continue to lead in educational innovation while maintaining our core values of excellence and integrity.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leadership Team -->
<section class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Our Leadership Team</h2>
            <p>Meet the dedicated professionals leading our school to excellence.</p>
        </div>
        
        <div class="row justify-content-center">
            <?php if(!empty($leadership_team)): ?>
                <?php foreach($leadership_team as $leader): ?>
                    <div class="col-lg-6 col-md-8 mb-4 fade-in">
                        <div class="card-custom text-center">
                            <div class="card-body">
                                <div class="mb-4">
                                    <?php if(!empty($leader['image'])): ?>
                                        <img src="<?php echo SITE_URL . '/' . $leader['image']; ?>" 
                                             alt="<?php echo htmlspecialchars($leader['name']); ?>" 
                                             class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white" 
                                             style="width: 120px; height: 120px; font-size: 3rem;">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <h4 style="color: var(--navy-blue);"><?php echo htmlspecialchars($leader['name']); ?></h4>
                                <p class="text-muted mb-3" style="font-size: 1.1rem;"><strong><?php echo htmlspecialchars($leader['position']); ?></strong></p>
                                <?php if(!empty($leader['bio'])): ?>
                                    <p class="lead"><?php echo htmlspecialchars($leader['bio']); ?></p>
                                <?php endif; ?>
                                <?php if(!empty($leader['email']) || !empty($leader['phone'])): ?>
                                    <div class="mt-4">
                                        <?php if(!empty($leader['email'])): ?>
                                            <p class="mb-1">
                                                <i class="fas fa-envelope me-2"></i>
                                                <a href="mailto:<?php echo htmlspecialchars($leader['email']); ?>" class="text-decoration-none">
                                                    <?php echo htmlspecialchars($leader['email']); ?>
                                                </a>
                                            </p>
                                        <?php endif; ?>
                                        <?php if(!empty($leader['phone'])): ?>
                                            <p class="mb-1">
                                                <i class="fas fa-phone me-2"></i>
                                                <a href="tel:<?php echo htmlspecialchars($leader['phone']); ?>" class="text-decoration-none">
                                                    <?php echo htmlspecialchars($leader['phone']); ?>
                                                </a>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if(empty($leader['image'])): ?>
                                    <div class="mt-4">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Photo can be added through admin panel
                                        </small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-lg-6 col-md-8 mb-4 fade-in">
                    <div class="card-custom text-center">
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white" 
                                     style="width: 120px; height: 120px; font-size: 3rem;">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                            </div>
                            <h4 style="color: var(--navy-blue);">Ms. Wa-Mwaura</h4>
                            <p class="text-muted mb-3" style="font-size: 1.1rem;"><strong>School Director</strong></p>
                            <p class="lead">Leading Githunguri Bridgeway Preparatory School with dedication to educational excellence and student development. Committed to providing quality education that nurtures young minds and builds strong foundations for future success.</p>
                            <div class="mt-4">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Leadership information managed through admin panel
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- School Facilities -->
<section class="section-padding">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Our Facilities</h2>
            <p>Modern infrastructure designed to support effective learning and development.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h5>Smart Classrooms</h5>
                    <p>Well-equipped classrooms with modern teaching aids and comfortable learning environment.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h5>Computer Lab</h5>
                    <p>State-of-the-art computer laboratory with internet connectivity for digital literacy programs.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                        <i class="fas fa-book"></i>
                    </div>
                    <h5>Library</h5>
                    <p>Well-stocked library with a wide collection of books, reference materials, and reading spaces.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                        <i class="fas fa-running"></i>
                    </div>
                    <h5>Sports Facilities</h5>
                    <p>Spacious playground and sports facilities for physical education and recreational activities.</p>
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
                <h2 class="mb-3" style="color: white;">Experience Excellence at Githunguri Bridgeway</h2>
                <p class="mb-0" style="font-size: 1.1rem;">Join our community of learners and discover how we can help your child reach their full potential.</p>
            </div>
            <div class="col-lg-4 text-lg-end fade-in">
                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn-primary-custom me-2 mb-2">Schedule a Visit</a>
                <a href="<?php echo SITE_URL; ?>/admissions.php" class="btn-outline-custom mb-2">Apply Today</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
