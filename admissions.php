<?php
require_once 'includes/config.php';

$page_title = 'Admissions';
$page_description = 'Apply for admission to Githunguri Bridgeway Preparatory School. Simple online application process for quality KCPE education.';

// Handle form submission
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = sanitize_input($_POST['student_name']);
    $parent_name = sanitize_input($_POST['parent_name']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $class_applying = sanitize_input($_POST['class_applying']);
    $previous_school = sanitize_input($_POST['previous_school']);
    $additional_info = sanitize_input($_POST['additional_info']);
    
    // Create admission message
    $admission_message = "ADMISSION APPLICATION\n\n";
    $admission_message .= "Student Name: $student_name\n";
    $admission_message .= "Parent/Guardian: $parent_name\n";
    $admission_message .= "Class Applying For: $class_applying\n";
    $admission_message .= "Previous School: $previous_school\n";
    $admission_message .= "Additional Information: $additional_info";
    
    try {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, phone, message, type) VALUES (?, ?, ?, ?, 'admission')");
        $stmt->execute([$parent_name, $email, $phone, $admission_message]);
        
        $message = "Thank you for your admission application! We will contact you within 48 hours to discuss the next steps.";
        $message_type = "success";
    } catch(PDOException $e) {
        $message = "Sorry, there was an error submitting your application. Please try again or contact us directly.";
        $message_type = "danger";
    }
}

include 'includes/header.php';
?>

<!-- Breadcrumb Section -->
<section class="breadcrumb-section">
    <div class="container">
        <h1>Admissions</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Admissions</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Admission Overview -->
<section class="section-padding">
    <div class="container">
        <?php if($message): ?>
            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in">
                <div class="section-title text-start">
                    <h2>Join Our School Family</h2>
                    <p class="text-start">We welcome students who are eager to learn and grow in a supportive, nurturing environment. Our admission process is designed to be simple and transparent.</p>
                </div>
                
                <p>At Githunguri Bridgeway Preparatory School, we believe every child deserves quality education. Our admissions are open throughout the year, and we encourage parents to visit our school to see our facilities and meet our dedicated teaching staff.</p>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-calendar-check text-success me-3" style="font-size: 1.5rem;"></i>
                            <span>Rolling Admissions</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-handshake text-success me-3" style="font-size: 1.5rem;"></i>
                            <span>Personal Interview</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-file-alt text-success me-3" style="font-size: 1.5rem;"></i>
                            <span>Simple Documentation</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-clock text-success me-3" style="font-size: 1.5rem;"></i>
                            <span>Quick Response</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 fade-in">
                <img src="https://images.unsplash.com/photo-1497486751825-1233686d5d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Happy students" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Admission Process -->
<section class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Admission Process</h2>
            <p>Follow these simple steps to secure your child's place at our school.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3 position-relative">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; background-color: var(--navy-blue); color: white; font-size: 1.5rem; font-weight: bold;">
                            1
                        </div>
                    </div>
                    <h5>Submit Application</h5>
                    <p>Complete and submit the online application form with required information about your child.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3 position-relative">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; background-color: var(--maroon); color: white; font-size: 1.5rem; font-weight: bold;">
                            2
                        </div>
                    </div>
                    <h5>School Visit</h5>
                    <p>Schedule a visit to tour our facilities and meet with our admissions team and teachers.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3 position-relative">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; background-color: var(--navy-blue); color: white; font-size: 1.5rem; font-weight: bold;">
                            3
                        </div>
                    </div>
                    <h5>Assessment</h5>
                    <p>Simple assessment to understand your child's current academic level and learning needs.</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3 position-relative">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; background-color: var(--maroon); color: white; font-size: 1.5rem; font-weight: bold;">
                            4
                        </div>
                    </div>
                    <h5>Enrollment</h5>
                    <p>Complete the enrollment process with required documents and fee payment.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Application Form -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="section-title fade-in">
                    <h2>Online Application Form</h2>
                    <p>Fill out this form to begin the admission process for your child.</p>
                </div>
                
                <div class="card-custom fade-in">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="student_name" class="form-label">Student's Full Name *</label>
                                    <input type="text" class="form-control" id="student_name" name="student_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="class_applying" class="form-label">Class Applying For *</label>
                                    <select class="form-control" id="class_applying" name="class_applying" required>
                                        <option value="">Select Class</option>
                                        <option value="Nursery">Nursery</option>
                                        <option value="Pre-Unit">Pre-Unit</option>
                                        <option value="Class 1">Class 1</option>
                                        <option value="Class 2">Class 2</option>
                                        <option value="Class 3">Class 3</option>
                                        <option value="Class 4">Class 4</option>
                                        <option value="Class 5">Class 5</option>
                                        <option value="Class 6">Class 6</option>
                                        <option value="Class 7">Class 7</option>
                                        <option value="Class 8">Class 8</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="parent_name" class="form-label">Parent/Guardian Name *</label>
                                    <input type="text" class="form-control" id="parent_name" name="parent_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="previous_school" class="form-label">Previous School (if any)</label>
                                <input type="text" class="form-control" id="previous_school" name="previous_school">
                            </div>
                            
                            <div class="mb-3">
                                <label for="additional_info" class="form-label">Additional Information</label>
                                <textarea class="form-control" id="additional_info" name="additional_info" rows="4" 
                                          placeholder="Please share any additional information about your child that would help us serve them better..."></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the school's terms and conditions and privacy policy *
                                    </label>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn-primary-custom">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Application
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Required Documents -->
<section class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Required Documents</h2>
            <p>Please prepare the following documents for the enrollment process.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body">
                        <h5 style="color: var(--navy-blue);">For New Students</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-file-alt text-success me-2"></i>Student's birth certificate</li>
                            <li class="mb-2"><i class="fas fa-file-alt text-success me-2"></i>Parent/Guardian ID copies</li>
                            <li class="mb-2"><i class="fas fa-file-alt text-success me-2"></i>Passport-size photographs (4 copies)</li>
                            <li class="mb-2"><i class="fas fa-file-alt text-success me-2"></i>Medical certificate</li>
                            <li class="mb-2"><i class="fas fa-file-alt text-success me-2"></i>Immunization records</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4 fade-in">
                <div class="card-custom h-100">
                    <div class="card-body">
                        <h5 style="color: var(--maroon);">For Transfer Students</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-file-alt text-success me-2"></i>All documents for new students</li>
                            <li class="mb-2"><i class="fas fa-file-alt text-success me-2"></i>Transfer certificate from previous school</li>
                            <li class="mb-2"><i class="fas fa-file-alt text-success me-2"></i>Academic transcripts/report cards</li>
                            <li class="mb-2"><i class="fas fa-file-alt text-success me-2"></i>Character certificate</li>
                            <li class="mb-2"><i class="fas fa-file-alt text-success me-2"></i>Fee clearance certificate</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fee Structure -->
<section class="section-padding">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Fee Structure</h2>
            <p>Affordable quality education with flexible payment options.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto fade-in">
                <div class="card-custom">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead style="background-color: var(--navy-blue); color: white;">
                                    <tr>
                                        <th>Class</th>
                                        <th>Tuition Fee (Per Term)</th>
                                        <th>Registration Fee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Nursery</td>
                                        <td>KES 8,000</td>
                                        <td>KES 2,000</td>
                                    </tr>
                                    <tr>
                                        <td>Pre-Unit</td>
                                        <td>KES 9,000</td>
                                        <td>KES 2,000</td>
                                    </tr>
                                    <tr>
                                        <td>Class 1-3</td>
                                        <td>KES 10,000</td>
                                        <td>KES 2,500</td>
                                    </tr>
                                    <tr>
                                        <td>Class 4-6</td>
                                        <td>KES 12,000</td>
                                        <td>KES 2,500</td>
                                    </tr>
                                    <tr>
                                        <td>Class 7-8</td>
                                        <td>KES 15,000</td>
                                        <td>KES 3,000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <h6 style="color: var(--navy-blue);">Payment Options:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Full term payment (5% discount)</li>
                                <li class="mb-1"><i class="fas fa-check text-success me-2"></i>Monthly installments</li>
                                <li class="mb-1"><i class="fas fa-check text-success me-2"></i>M-Pesa, Bank transfer, or Cash</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="section-padding" style="background: linear-gradient(135deg, var(--navy-blue), var(--maroon)); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 fade-in">
                <h2 class="mb-3" style="color: white;">Need Help with Your Application?</h2>
                <p class="mb-0" style="font-size: 1.1rem;">Our admissions team is here to assist you throughout the process. Contact us for any questions or to schedule a school visit.</p>
            </div>
            <div class="col-lg-4 text-lg-end fade-in">
                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn-primary-custom me-2 mb-2">Contact Us</a>
                <a href="tel:<?php echo SCHOOL_PHONE; ?>" class="btn-outline-custom mb-2">Call Now</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
