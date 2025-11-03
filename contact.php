<?php
require_once 'includes/config.php';

$page_title = 'Contact Us';
$page_description = 'Get in touch with Githunguri Bridgeway Preparatory School. Visit us, call us, or send us a message. We are here to help with all your inquiries.';

// Handle form submission
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input(isset($_POST['phone']) ? $_POST['phone'] : '');
    $subject = sanitize_input(isset($_POST['subject']) ? $_POST['subject'] : 'General Inquiry');
    $user_message = sanitize_input($_POST['message']);
    
    try {
        // Create messages table if it doesn't exist
        $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            phone VARCHAR(20),
            message TEXT NOT NULL,
            type ENUM('contact', 'admission') NOT NULL,
            status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, phone, message, type) VALUES (?, ?, ?, ?, 'contact')");
        $stmt->execute([$name, $email, $phone, "Subject: $subject\n\n$user_message"]);
        
        $message = "Thank you for contacting us! We will get back to you within 24 hours.";
        $message_type = "success";
    } catch(PDOException $e) {
        $message = "Sorry, there was an error sending your message. Please try again or contact us directly at " . SCHOOL_PHONE;
        $message_type = "danger";
    }
}

include 'includes/header.php';
?>

<!-- Breadcrumb Section -->
<section class="breadcrumb-section">
    <div class="container">
        <h1>Contact Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Contact Us</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Contact Information -->
<section class="section-padding">
    <div class="container">
        <?php if($message): ?>
            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="section-title fade-in">
            <h2>Get in Touch</h2>
            <p>We're here to answer your questions and help you learn more about our school.</p>
        </div>
        
        <div class="row">
            <!-- Contact Information Cards -->
            <div class="col-lg-4 mb-4 fade-in">
                <div class="card-custom h-100 text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h5>Visit Us</h5>
                        <p class="mb-0"><?php echo SCHOOL_ADDRESS; ?></p>
                        <small class="text-muted">Monday - Friday: 7:00 AM - 5:00 PM<br>Saturday: 8:00 AM - 12:00 PM</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4 fade-in">
                <div class="card-custom h-100 text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h5>Call Us</h5>
                        <p class="mb-0">
                            <a href="tel:<?php echo SCHOOL_PHONE; ?>" class="text-decoration-none">
                                <?php echo SCHOOL_PHONE; ?>
                            </a>
                        </p>
                        <small class="text-muted">Available during school hours</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4 fade-in">
                <div class="card-custom h-100 text-center">
                    <div class="card-body">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5>Email Us</h5>
                        <p class="mb-0">
                            <a href="mailto:<?php echo SCHOOL_EMAIL; ?>" class="text-decoration-none">
                                <?php echo SCHOOL_EMAIL; ?>
                            </a>
                        </p>
                        <small class="text-muted">We'll respond within 24 hours</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form and Map -->
<section class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-6 mb-4">
                <div class="section-title text-start fade-in">
                    <h3>Send Us a Message</h3>
                    <p class="text-start">Have a question or want to schedule a visit? Fill out the form below and we'll get back to you soon.</p>
                </div>
                
                <div class="card-custom fade-in">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="subject" class="form-label">Subject *</label>
                                    <select class="form-control" id="subject" name="subject" required>
                                        <option value="">Select Subject</option>
                                        <option value="General Inquiry">General Inquiry</option>
                                        <option value="Admissions">Admissions</option>
                                        <option value="Academic Programs">Academic Programs</option>
                                        <option value="School Visit">Schedule School Visit</option>
                                        <option value="Fee Information">Fee Information</option>
                                        <option value="Student Life">Student Life & Activities</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control" id="message" name="message" rows="5" 
                                          placeholder="Please tell us how we can help you..." required></textarea>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn-primary-custom">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Map and Additional Info -->
            <div class="col-lg-6">
                <div class="section-title text-start fade-in">
                    <h3>Find Us</h3>
                    <p class="text-start">Located in the heart of Githunguri, Kiambu County, our school is easily accessible by public and private transport.</p>
                </div>
                
                <!-- Google Maps Embed -->
                <div class="fade-in mb-4">
                    <div class="map-container" style="height: 300px; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7234567890123!2d36.8219!3d-0.9167!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1a6bf7445dc1%3A0x940b62a3c8efde8f!2sGithunguri%2C%20Kenya!5e0!3m2!1sen!2ske!4v1699024800000!5m2!1sen!2ske" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Githunguri Bridgeway Preparatory School Location">
                        </iframe>
                    </div>
                </div>
                
                <!-- Transportation Info -->
                <div class="card-custom fade-in">
                    <div class="card-body">
                        <h5 style="color: var(--navy-blue);">Transportation</h5>
                        <div class="mb-3">
                            <h6><i class="fas fa-bus me-2"></i>Public Transport</h6>
                            <p class="mb-2">Regular matatu services from Kiambu town and Nairobi</p>
                        </div>
                        <div class="mb-3">
                            <h6><i class="fas fa-car me-2"></i>Private Vehicle</h6>
                            <p class="mb-2">Ample parking space available for parents and visitors</p>
                        </div>
                        <div>
                            <h6><i class="fas fa-walking me-2"></i>Landmarks</h6>
                            <p class="mb-0">Behind Githunguri Holy Family Catholic Church</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Contact Options -->
<section class="section-padding">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Quick Contact Options</h2>
            <p>Choose the most convenient way to reach us.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hello%20Githunguri%20Bridgeway%20Preparatory%20School" 
                       target="_blank" class="text-decoration-none">
                        <div class="mb-3" style="color: #25d366; font-size: 3rem;">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h5>WhatsApp</h5>
                        <p>Chat with us instantly for quick responses</p>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <a href="tel:<?php echo SCHOOL_PHONE; ?>" class="text-decoration-none">
                        <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h5>Phone Call</h5>
                        <p>Speak directly with our staff</p>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <a href="mailto:<?php echo SCHOOL_EMAIL; ?>" class="text-decoration-none">
                        <div class="mb-3" style="color: var(--maroon); font-size: 3rem;">
                            <i class="fas fa-envelope-open"></i>
                        </div>
                        <h5>Email</h5>
                        <p>Send detailed inquiries via email</p>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4 fade-in">
                <div class="text-center">
                    <div class="mb-3" style="color: var(--navy-blue); font-size: 3rem;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h5>Schedule Visit</h5>
                    <p>Book an appointment to tour our facilities</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section-padding" style="background-color: var(--light-gray);">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Frequently Asked Questions</h2>
            <p>Quick answers to common questions about our school.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto fade-in">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item mb-3" style="border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                What are your school hours?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Our school operates Monday to Friday from 7:00 AM to 5:00 PM, and Saturday from 8:00 AM to 12:00 PM for co-curricular activities.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item mb-3" style="border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Do you provide transport services?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, we provide school bus services to various routes within Githunguri and surrounding areas. Contact us for route details and transport fees.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item mb-3" style="border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                What is your admission process?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Our admission process includes: 1) Online application, 2) School visit and interview, 3) Simple assessment, and 4) Enrollment with required documents.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item mb-3" style="border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Do you offer meals at school?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, we provide nutritious meals including breakfast, lunch, and snacks. Our kitchen follows strict hygiene standards and caters to dietary requirements.
                            </div>
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
                <h2 class="mb-3" style="color: white;">Ready to Visit Our School?</h2>
                <p class="mb-0" style="font-size: 1.1rem;">We'd love to show you around our campus and discuss how we can support your child's educational journey.</p>
            </div>
            <div class="col-lg-4 text-lg-end fade-in">
                <a href="<?php echo SITE_URL; ?>/admissions.php" class="btn-primary-custom me-2 mb-2">Apply Now</a>
                <a href="tel:<?php echo SCHOOL_PHONE; ?>" class="btn-outline-custom mb-2">Call to Visit</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
