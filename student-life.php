<?php
require_once 'includes/config.php';

$page_title = 'Student Life';
$page_description = 'Discover the vibrant student life at Githunguri Bridgeway Preparatory School - events, activities, gallery, and co-curricular programs.';

// Fetch events
try {
    $stmt = $pdo->prepare("SELECT * FROM events ORDER BY date DESC");
    $stmt->execute();
    $events = $stmt->fetchAll();
} catch(PDOException $e) {
    $events = [];
}

// Fetch gallery images
try {
    $stmt = $pdo->prepare("SELECT * FROM gallery ORDER BY created_at DESC");
    $stmt->execute();
    $gallery_images = $stmt->fetchAll();
} catch(PDOException $e) {
    $gallery_images = [];
}

include 'includes/header.php';
?>

<!-- Breadcrumb Section -->
<section class="breadcrumb-section">
    <div class="container">
        <h1>Student Life</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Student Life</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Student Life Overview -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in">
                <div class="section-title text-start">
                    <h2>Vibrant School Community</h2>
                    <p class="text-start">At Githunguri Bridgeway Preparatory School, we believe in nurturing well-rounded individuals through a rich variety of co-curricular activities and school events.</p>
                </div>
                
                <p>Our students enjoy a dynamic school life filled with opportunities to explore their talents, develop leadership skills, and build lasting friendships. From sports competitions to cultural festivals, every day brings new learning experiences beyond the classroom.</p>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-trophy text-warning me-3" style="font-size: 1.5rem;"></i>
                            <span>Sports & Athletics</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-music text-warning me-3" style="font-size: 1.5rem;"></i>
                            <span>Music & Drama</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-palette text-warning me-3" style="font-size: 1.5rem;"></i>
                            <span>Arts & Crafts</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-users text-warning me-3" style="font-size: 1.5rem;"></i>
                            <span>Leadership Programs</span>
                        </div>
                    </div>
                </div>
                
                <a href="<?php echo SITE_URL; ?>/admissions.php" class="btn-primary-custom">Join Our Community</a>
            </div>
            <div class="col-lg-6 fade-in">
                <img src="https://images.unsplash.com/photo-1544717297-fa95b6ee9643?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Students activities" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Co-curricular Activities -->
<section class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Co-curricular Activities</h2>
            <p>Diverse programs to develop talents and build character beyond academics.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body text-center">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-running"></i>
                        </div>
                        <h5>Sports & Athletics</h5>
                        <p>Football, netball, athletics, swimming, and various indoor games to promote physical fitness and teamwork.</p>
                        <ul class="list-unstyled text-start">
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Inter-house competitions</li>
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>District tournaments</li>
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Annual sports day</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body text-center">
                        <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                            <i class="fas fa-music"></i>
                        </div>
                        <h5>Music & Drama</h5>
                        <p>Choir, instrumental music, drama club, and cultural performances to nurture artistic talents and confidence.</p>
                        <ul class="list-unstyled text-start">
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>School choir</li>
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Drama productions</li>
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Cultural festivals</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body text-center">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-palette"></i>
                        </div>
                        <h5>Arts & Crafts</h5>
                        <p>Drawing, painting, pottery, and handicrafts to develop creativity and fine motor skills.</p>
                        <ul class="list-unstyled text-start">
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Art exhibitions</li>
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Craft workshops</li>
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Creative competitions</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body text-center">
                        <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5>Leadership & Clubs</h5>
                        <p>Student council, debate club, environmental club, and various interest groups for leadership development.</p>
                        <ul class="list-unstyled text-start">
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Student government</li>
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Debate competitions</li>
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Community service</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body text-center">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h5>Technology Club</h5>
                        <p>Computer programming, robotics, and digital literacy programs to prepare students for the digital age.</p>
                        <ul class="list-unstyled text-start">
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Coding workshops</li>
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Digital projects</li>
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Tech competitions</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body text-center">
                        <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h5>Environmental Club</h5>
                        <p>Tree planting, recycling programs, and environmental conservation activities to build eco-consciousness.</p>
                        <ul class="list-unstyled text-start">
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>School garden</li>
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Recycling projects</li>
                            <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Nature walks</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- School Events -->
<section id="events" class="section-padding">
    <div class="container">
        <div class="section-title fade-in">
            <h2>School Events & Activities</h2>
            <p>Throughout the year, we organize various events that bring our school community together.</p>
        </div>
        
        <?php if(!empty($events)): ?>
            <div class="row">
                <?php foreach($events as $event): ?>
                    <div class="col-lg-4 col-md-6 mb-4 fade-in">
                        <div class="card-custom h-100">
                            <?php if($event['image']): ?>
                                <img src="<?php echo SITE_URL . '/' . UPLOAD_PATH . $event['image']; ?>" 
                                     class="card-img-top" alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                     style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top d-flex align-items-center justify-content-center" 
                                     style="height: 200px; background-color: var(--light-gray);">
                                    <i class="fas fa-calendar-alt" style="font-size: 3rem; color: var(--navy-blue);"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        <?php echo date('F j, Y', strtotime($event['date'])); ?>
                                    </small>
                                    <?php if($event['is_featured']): ?>
                                        <span class="badge bg-warning text-dark ms-2">Featured</span>
                                    <?php endif; ?>
                                </div>
                                <h5><?php echo htmlspecialchars($event['title']); ?></h5>
                                <p><?php echo htmlspecialchars($event['details']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center fade-in">
                <div class="mb-4" style="color: var(--navy-blue); font-size: 4rem;">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h4>Exciting Events Coming Soon!</h4>
                <p>We're planning amazing events for our students. Check back soon for updates.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- School Gallery -->
<section id="gallery" class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>School Gallery</h2>
            <p>Capturing memorable moments from our school life and activities.</p>
        </div>
        
        <?php if(!empty($gallery_images)): ?>
            <div class="row">
                <?php foreach($gallery_images as $image): ?>
                    <div class="col-lg-4 col-md-6 mb-4 fade-in">
                        <div class="gallery-item">
                            <img src="<?php echo SITE_URL . '/' . $image['image']; ?>" 
                                 alt="<?php echo htmlspecialchars($image['caption']); ?>" 
                                 class="img-fluid">
                            <div class="gallery-overlay">
                                <span><?php echo htmlspecialchars($image['caption']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Default gallery with school images -->
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 fade-in">
                    <div class="gallery-item">
                        <img src="assets/images/githunguri_bridgewaystudents.jpeg" 
                             alt="Our Students Learning" class="img-fluid">
                        <div class="gallery-overlay">
                            <span>Our Students in Learning Environment</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4 fade-in">
                    <div class="gallery-item">
                        <img src="assets/images/githunguri_bridgewaygraduation.jpeg" 
                             alt="Graduation Ceremony" class="img-fluid">
                        <div class="gallery-overlay">
                            <span>Graduation Ceremony - Academic Achievement</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4 fade-in">
                    <div class="gallery-item">
                        <img src="assets/images/githunguri_bridgewaythanksgiving.jpeg" 
                             alt="Thanksgiving Celebration" class="img-fluid">
                        <div class="gallery-overlay">
                            <span>Thanksgiving Celebration - Community Spirit</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Message for admin to add more images -->
            <div class="text-center mt-4">
                <div class="alert alert-info d-inline-block">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>More photos coming soon!</strong> Visit our admin panel to add more gallery images.
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Student Achievements -->
<section class="section-padding">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Student Achievements</h2>
            <p>Celebrating our students' excellence in academics, sports, and co-curricular activities.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h4 style="color: var(--navy-blue); font-weight: bold;">15+</h4>
                    <p>Academic Awards</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h4 style="color: var(--maroon); font-weight: bold;">8+</h4>
                    <p>Sports Championships</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                        <i class="fas fa-star"></i>
                    </div>
                    <h4 style="color: var(--navy-blue); font-weight: bold;">12+</h4>
                    <p>Cultural Competitions</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h4 style="color: var(--maroon); font-weight: bold;">100+</h4>
                    <p>Certificates Earned</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Daily Schedule -->
<section class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Daily Schedule</h2>
            <p>A well-structured day that balances academics with co-curricular activities.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto fade-in">
                <div class="card-custom">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead style="background-color: var(--navy-blue); color: white;">
                                    <tr>
                                        <th>Time</th>
                                        <th>Activity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>7:00 - 7:30 AM</strong></td>
                                        <td>Assembly & Morning Devotion</td>
                                    </tr>
                                    <tr>
                                        <td><strong>7:30 - 10:30 AM</strong></td>
                                        <td>Morning Lessons (3 periods)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>10:30 - 11:00 AM</strong></td>
                                        <td>Tea Break</td>
                                    </tr>
                                    <tr>
                                        <td><strong>11:00 AM - 1:00 PM</strong></td>
                                        <td>Lessons Continue (2 periods)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>1:00 - 2:00 PM</strong></td>
                                        <td>Lunch Break</td>
                                    </tr>
                                    <tr>
                                        <td><strong>2:00 - 3:30 PM</strong></td>
                                        <td>Afternoon Lessons</td>
                                    </tr>
                                    <tr>
                                        <td><strong>3:30 - 4:30 PM</strong></td>
                                        <td>Co-curricular Activities</td>
                                    </tr>
                                    <tr>
                                        <td><strong>4:30 - 5:00 PM</strong></td>
                                        <td>Study Time & Departure</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                <h2 class="mb-3" style="color: white;">Be Part of Our Vibrant Community</h2>
                <p class="mb-0" style="font-size: 1.1rem;">Join us and give your child the opportunity to grow, learn, and thrive in a supportive and dynamic environment.</p>
            </div>
            <div class="col-lg-4 text-lg-end fade-in">
                <a href="<?php echo SITE_URL; ?>/admissions.php" class="btn-primary-custom me-2 mb-2">Apply Today</a>
                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn-outline-custom mb-2">Visit Us</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
