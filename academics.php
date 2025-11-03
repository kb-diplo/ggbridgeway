<?php
require_once 'includes/config.php';

$page_title = 'Academics';
$page_description = 'Discover our comprehensive KCPE curriculum and academic programs at Githunguri Bridgeway Preparatory School. Excellence in education for every child.';

include 'includes/header.php';
?>

<!-- Breadcrumb Section -->
<section class="breadcrumb-section">
    <div class="container">
        <h1>Academics</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Academics</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Academic Overview -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in">
                <div class="section-title text-start">
                    <h2>KCPE Curriculum Excellence</h2>
                    <p class="text-start">Our academic program is carefully designed to align with the Kenya Certificate of Primary Education (KCPE) curriculum while fostering critical thinking, creativity, and character development.</p>
                </div>
                
                <p>We follow the official Kenyan curriculum as prescribed by the Kenya Institute of Curriculum Development (KICD), ensuring our students are well-prepared for national examinations and future academic pursuits.</p>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-graduation-cap text-success me-3" style="font-size: 1.5rem;"></i>
                            <span>KCPE Focused Curriculum</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-users text-success me-3" style="font-size: 1.5rem;"></i>
                            <span>Small Class Sizes</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-chart-line text-success me-3" style="font-size: 1.5rem;"></i>
                            <span>Continuous Assessment</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-award text-success me-3" style="font-size: 1.5rem;"></i>
                            <span>Excellence Recognition</span>
                        </div>
                    </div>
                </div>
                
                <a href="<?php echo SITE_URL; ?>/admissions.php" class="btn-primary-custom">Enroll Your Child</a>
            </div>
            <div class="col-lg-6 fade-in">
                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Students learning" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Academic Programs -->
<section id="programs" class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Our Academic Programs</h2>
            <p>Comprehensive education from nursery through primary school completion.</p>
        </div>
        
        <div class="row">
            <!-- Nursery School -->
            <div id="nursery" class="col-lg-4 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-baby"></i>
                        </div>
                        <h4 style="color: var(--navy-blue);">Nursery School</h4>
                        <p class="mb-3">Ages 3-5 years</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Play-based learning</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Basic literacy and numeracy</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Social skills development</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Creative arts and crafts</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Physical development activities</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Lower Primary -->
            <div class="col-lg-4 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                            <i class="fas fa-child"></i>
                        </div>
                        <h4 style="color: var(--maroon);">Lower Primary</h4>
                        <p class="mb-3">Classes 1-3</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Foundation literacy skills</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Basic mathematics concepts</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Environmental activities</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Kiswahili language development</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Creative and performing arts</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Upper Primary -->
            <div id="primary" class="col-lg-4 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h4 style="color: var(--navy-blue);">Upper Primary</h4>
                        <p class="mb-3">Classes 4-8</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Advanced English and Kiswahili</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Mathematics and Science</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Social Studies</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Religious Education</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>KCPE Preparation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Subjects -->
<section class="section-padding">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Core Subjects</h2>
            <p>Our curriculum covers all essential subjects as per KICD guidelines.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                        <i class="fas fa-language"></i>
                    </div>
                    <h5>English</h5>
                    <p>Comprehensive language skills including reading, writing, speaking, and listening.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                        <i class="fas fa-flag"></i>
                    </div>
                    <h5>Kiswahili</h5>
                    <p>National language proficiency with emphasis on communication and cultural understanding.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h5>Mathematics</h5>
                    <p>Problem-solving skills, logical thinking, and mathematical concepts from basic to advanced levels.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h5>Science</h5>
                    <p>Hands-on experiments and scientific inquiry to understand the natural world.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <h5>Social Studies</h5>
                    <p>Geography, history, and civics to understand society and citizenship responsibilities.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                        <i class="fas fa-praying-hands"></i>
                    </div>
                    <h5>Religious Education</h5>
                    <p>Moral and spiritual development through Christian Religious Education (CRE).</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h5>Creative Arts</h5>
                    <p>Music, art, and craft activities to develop creativity and artistic expression.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                        <i class="fas fa-running"></i>
                    </div>
                    <h5>Physical Education</h5>
                    <p>Sports and physical activities to promote health, fitness, and teamwork.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KCPE Preparation -->
<section id="kcpe" class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in">
                <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="KCPE Preparation" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6 fade-in">
                <div class="section-title text-start">
                    <h2>KCPE Preparation Program</h2>
                    <p class="text-start">Our specialized KCPE preparation program ensures students are fully ready for the national examination.</p>
                </div>
                
                <div class="mb-4">
                    <h5 style="color: var(--navy-blue);">Our KCPE Success Strategy:</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Comprehensive syllabus coverage</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Regular mock examinations</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Individual student tracking</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Extra coaching for weak areas</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Exam techniques and time management</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Stress management and confidence building</li>
                    </ul>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-center p-3" style="background-color: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            <h3 style="color: var(--navy-blue); font-weight: bold;">98%</h3>
                            <small class="text-muted">KCPE Success Rate</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center p-3" style="background-color: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            <h3 style="color: var(--maroon); font-weight: bold;">350+</h3>
                            <small class="text-muted">Average KCPE Score</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Teaching Methodology -->
<section class="section-padding">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Our Teaching Approach</h2>
            <p>Modern, student-centered teaching methods that make learning engaging and effective.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-6 mb-4 fade-in">
                <div class="d-flex">
                    <div class="me-4" style="color: var(--navy-blue); font-size: 3rem;">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div>
                        <h5>Interactive Learning</h5>
                        <p>We use interactive teaching methods including group discussions, hands-on activities, and multimedia resources to make learning engaging and memorable.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4 fade-in">
                <div class="d-flex">
                    <div class="me-4" style="color: var(--maroon); font-size: 3rem;">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div>
                        <h5>Personalized Attention</h5>
                        <p>Small class sizes allow our teachers to provide individual attention to each student, identifying strengths and addressing learning gaps promptly.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4 fade-in">
                <div class="d-flex">
                    <div class="me-4" style="color: var(--navy-blue); font-size: 3rem;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h5>Continuous Assessment</h5>
                        <p>Regular assessments and feedback help track student progress and adjust teaching strategies to ensure optimal learning outcomes.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4 fade-in">
                <div class="d-flex">
                    <div class="me-4" style="color: var(--maroon); font-size: 3rem;">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div>
                        <h5>Technology Integration</h5>
                        <p>We incorporate modern technology and digital tools to enhance learning experiences and prepare students for the digital age.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Academic Calendar -->
<section class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Academic Calendar</h2>
            <p>Our academic year follows the official Kenyan school calendar.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 mb-4 fade-in">
                <div class="card-custom text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 2.5rem;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h5>Term 1</h5>
                        <p class="mb-2"><strong>January - April</strong></p>
                        <p>New academic year begins with fresh energy and new learning objectives.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4 fade-in">
                <div class="card-custom text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--maroon); font-size: 2.5rem;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h5>Term 2</h5>
                        <p class="mb-2"><strong>May - August</strong></p>
                        <p>Mid-year assessments and continued curriculum coverage with various school activities.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4 fade-in">
                <div class="card-custom text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 2.5rem;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h5>Term 3</h5>
                        <p class="mb-2"><strong>September - November</strong></p>
                        <p>Final term with KCPE examinations for Class 8 students and year-end assessments.</p>
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
                <h2 class="mb-3" style="color: white;">Ready to Give Your Child the Best Education?</h2>
                <p class="mb-0" style="font-size: 1.1rem;">Join hundreds of families who have trusted us with their children's education. Experience our commitment to academic excellence.</p>
            </div>
            <div class="col-lg-4 text-lg-end fade-in">
                <a href="<?php echo SITE_URL; ?>/admissions.php" class="btn-primary-custom me-2 mb-2">Apply Now</a>
                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn-outline-custom mb-2">Learn More</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
