<?php
require_once 'includes/config.php';

$page_title = 'Careers - Join Our Team';
$page_description = 'Explore career opportunities at Githunguri Bridgeway Preparatory School. Join our dedicated team of educators and make a difference in young lives.';

// Get active job postings
try {
    $stmt = $pdo->prepare("SELECT * FROM careers WHERE is_active = 1 AND (application_deadline >= CURDATE() OR application_deadline IS NULL) ORDER BY created_at DESC");
    $stmt->execute();
    $careers = $stmt->fetchAll();
} catch(PDOException $e) {
    $careers = [];
}

include 'includes/header.php';
?>

<!-- Breadcrumb Section -->
<section class="breadcrumb-section">
    <div class="container">
        <h1>Career Opportunities</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Careers</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Careers Overview -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in">
                <div class="section-title text-start">
                    <h2>Join Our Team</h2>
                    <p class="text-start">Be part of our mission to provide quality education and shape the future of young minds at Githunguri Bridgeway Preparatory School.</p>
                </div>
                
                <p>We are always looking for passionate, dedicated educators and support staff who share our commitment to excellence in education. Join our team of approximately 8 qualified teachers serving our community of 40 learners.</p>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-chalkboard-teacher text-warning me-3" style="font-size: 1.5rem;"></i>
                            <span>Teaching Positions</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-users text-warning me-3" style="font-size: 1.5rem;"></i>
                            <span>Support Staff Roles</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-heart text-warning me-3" style="font-size: 1.5rem;"></i>
                            <span>Competitive Benefits</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-graduation-cap text-warning me-3" style="font-size: 1.5rem;"></i>
                            <span>Professional Development</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 fade-in">
                <img src="https://images.unsplash.com/photo-1544717297-fa95b6ee9643?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Teachers and students" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Why Work With Us -->
<section class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Why Choose Githunguri Bridgeway?</h2>
            <p>Discover what makes our school a great place to build your career in education.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100 text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h5>Supportive Environment</h5>
                        <p>Work in a collaborative, supportive environment where your contributions are valued and your professional growth is encouraged.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100 text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5>Small Class Sizes</h5>
                        <p>With approximately 40 learners, you can provide personalized attention and build meaningful relationships with students.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100 text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h5>Excellence Focus</h5>
                        <p>Be part of a school committed to academic excellence and character development following the KCPE curriculum.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100 text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h5>Great Location</h5>
                        <p>Located in Githunguri, Kiambu County - a peaceful environment conducive to learning and teaching.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100 text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h5>Career Growth</h5>
                        <p>Opportunities for professional development and career advancement within our growing school community.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 fade-in">
                <div class="card-custom h-100 text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h5>Community Impact</h5>
                        <p>Make a real difference in the lives of children and contribute to the development of our local community.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Current Openings -->
<section class="section-padding">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Current Job Openings</h2>
            <p>Explore our available positions and join our team of dedicated educators.</p>
        </div>
        
        <?php if(!empty($careers)): ?>
            <div class="row">
                <?php foreach($careers as $career): ?>
                    <div class="col-lg-6 mb-4 fade-in">
                        <div class="card-custom h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title"><?php echo htmlspecialchars($career['title']); ?></h5>
                                    <span class="badge bg-success"><?php echo ucfirst(str_replace('-', ' ', $career['employment_type'])); ?></span>
                                </div>
                                
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-building me-1"></i><?php echo htmlspecialchars($career['department']); ?> • 
                                        <i class="fas fa-map-marker-alt me-1"></i><?php echo htmlspecialchars($career['location']); ?>
                                        <?php if($career['salary_range']): ?>
                                            • <i class="fas fa-money-bill-wave me-1"></i><?php echo htmlspecialchars($career['salary_range']); ?>
                                        <?php endif; ?>
                                    </small>
                                </div>
                                
                                <p class="card-text"><?php echo htmlspecialchars(substr($career['description'], 0, 150)) . (strlen($career['description']) > 150 ? '...' : ''); ?></p>
                                
                                <?php if($career['application_deadline']): ?>
                                    <div class="mb-3">
                                        <small class="text-danger">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            Application Deadline: <?php echo date('F j, Y', strtotime($career['application_deadline'])); ?>
                                        </small>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn btn-outline-primary btn-sm" onclick="viewJob(<?php echo $career['id']; ?>)">
                                        <i class="fas fa-eye me-1"></i>View Details
                                    </button>
                                    <button class="btn btn-primary btn-sm" onclick="applyJob(<?php echo $career['id']; ?>)">
                                        <i class="fas fa-paper-plane me-1"></i>Apply Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center fade-in">
                <div class="mb-4" style="color: var(--navy-blue); font-size: 4rem;">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h4>No Current Openings</h4>
                <p>We don't have any open positions at the moment, but we're always interested in hearing from qualified candidates. Please check back soon or send us your CV for future opportunities.</p>
                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn-primary-custom">
                    <i class="fas fa-envelope me-2"></i>Contact Us
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Application Process -->
<section class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Application Process</h2>
            <p>Follow these simple steps to apply for a position at our school.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3 position-relative">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; color: white; font-size: 2rem;">
                            <i class="fas fa-search"></i>
                        </div>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">1</span>
                    </div>
                    <h5>Browse Jobs</h5>
                    <p>Review our current job openings and find positions that match your skills and interests.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3 position-relative">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; color: white; font-size: 2rem;">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">2</span>
                    </div>
                    <h5>Submit Application</h5>
                    <p>Complete the online application form with your details, cover letter, and CV.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3 position-relative">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; color: white; font-size: 2rem;">
                            <i class="fas fa-comments"></i>
                        </div>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">3</span>
                    </div>
                    <h5>Interview</h5>
                    <p>If shortlisted, you'll be invited for an interview to discuss your qualifications and experience.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3 position-relative">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; color: white; font-size: 2rem;">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">4</span>
                    </div>
                    <h5>Join Our Team</h5>
                    <p>Successful candidates will receive an offer and join our dedicated team of educators.</p>
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
                <h2 class="mb-3" style="color: white;">Ready to Make a Difference?</h2>
                <p class="mb-0" style="font-size: 1.1rem;">Join our team and help us continue building bright futures with strong foundations at Githunguri Bridgeway Preparatory School.</p>
            </div>
            <div class="col-lg-4 text-lg-end fade-in">
                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn-primary-custom me-2 mb-2">Contact HR</a>
                <a href="#current-openings" class="btn-outline-custom mb-2">View Openings</a>
            </div>
        </div>
    </div>
</section>

<!-- Job Details Modal -->
<div class="modal fade" id="jobModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobModalTitle">Job Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="jobModalBody">
                <!-- Job details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="applyFromModal">Apply Now</button>
            </div>
        </div>
    </div>
</div>

<!-- Application Modal -->
<div class="modal fade" id="applicationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Apply for Position</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="applicationForm" enctype="multipart/form-data">
                    <input type="hidden" id="career_id" name="career_id">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="applicant_name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="applicant_name" name="applicant_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone">
                    </div>
                    
                    <div class="mb-3">
                        <label for="cover_letter" class="form-label">Cover Letter *</label>
                        <textarea class="form-control" id="cover_letter" name="cover_letter" rows="5" 
                                  placeholder="Tell us why you're interested in this position and what makes you a great candidate..." required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="cv_file" class="form-label">Upload CV/Resume (PDF only) *</label>
                        <input type="file" class="form-control" id="cv_file" name="cv_file" accept=".pdf" required>
                        <small class="text-muted">Maximum file size: 5MB</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitApplication()">Submit Application</button>
            </div>
        </div>
    </div>
</div>

<script>
function viewJob(jobId) {
    // Load job details via AJAX
    fetch(`ajax/get_job_details.php?id=${jobId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('jobModalTitle').textContent = data.job.title;
                document.getElementById('jobModalBody').innerHTML = `
                    <div class="mb-3">
                        <strong>Department:</strong> ${data.job.department}<br>
                        <strong>Location:</strong> ${data.job.location}<br>
                        <strong>Employment Type:</strong> ${data.job.employment_type}<br>
                        ${data.job.salary_range ? `<strong>Salary Range:</strong> ${data.job.salary_range}<br>` : ''}
                        ${data.job.application_deadline ? `<strong>Application Deadline:</strong> ${data.job.application_deadline}<br>` : ''}
                    </div>
                    <div class="mb-3">
                        <h6>Job Description:</h6>
                        <p>${data.job.description}</p>
                    </div>
                    <div class="mb-3">
                        <h6>Requirements:</h6>
                        <p>${data.job.requirements.replace(/\n/g, '<br>')}</p>
                    </div>
                `;
                document.getElementById('applyFromModal').onclick = () => applyJob(jobId);
                new bootstrap.Modal(document.getElementById('jobModal')).show();
            }
        });
}

function applyJob(jobId) {
    document.getElementById('career_id').value = jobId;
    bootstrap.Modal.getInstance(document.getElementById('jobModal'))?.hide();
    new bootstrap.Modal(document.getElementById('applicationModal')).show();
}

function submitApplication() {
    const form = document.getElementById('applicationForm');
    const formData = new FormData(form);
    
    fetch('ajax/submit_application.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Application submitted successfully! We will review your application and get back to you soon.');
            bootstrap.Modal.getInstance(document.getElementById('applicationModal')).hide();
            form.reset();
        } else {
            alert('Error submitting application: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error submitting application. Please try again.');
    });
}
</script>

<?php include 'includes/footer.php'; ?>
