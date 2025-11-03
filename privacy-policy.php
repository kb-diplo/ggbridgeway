<?php
require_once 'includes/config.php';

$page_title = 'Privacy Policy';
$page_description = 'Privacy Policy for Githunguri Bridgeway Preparatory School website. Learn how we collect, use, and protect your personal information.';

include 'includes/header.php';
?>

<!-- Breadcrumb Section -->
<section class="breadcrumb-section">
    <div class="container">
        <h1>Privacy Policy</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Privacy Policy</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Privacy Policy Content -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <p class="text-muted mb-4"><strong>Last updated:</strong> <?php echo date('F j, Y'); ?></p>
                        
                        <h3>Introduction</h3>
                        <p>Githunguri Bridgeway Preparatory School ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.</p>
                        
                        <h3>Information We Collect</h3>
                        <h5>Personal Information</h5>
                        <p>We may collect personal information that you voluntarily provide to us when you:</p>
                        <ul>
                            <li>Fill out contact forms or inquiry forms</li>
                            <li>Submit admission applications</li>
                            <li>Subscribe to our newsletter</li>
                            <li>Apply for job positions</li>
                        </ul>
                        
                        <p>This information may include:</p>
                        <ul>
                            <li>Name and contact information</li>
                            <li>Email address and phone number</li>
                            <li>Student information for admissions</li>
                            <li>Employment history for job applications</li>
                        </ul>
                        
                        <h5>Automatically Collected Information</h5>
                        <p>When you visit our website, we may automatically collect certain information about your device, including:</p>
                        <ul>
                            <li>IP address and browser type</li>
                            <li>Operating system and device information</li>
                            <li>Pages visited and time spent on our site</li>
                            <li>Referring website information</li>
                        </ul>
                        
                        <h3>How We Use Your Information</h3>
                        <p>We use the information we collect to:</p>
                        <ul>
                            <li>Respond to your inquiries and provide customer service</li>
                            <li>Process admission applications</li>
                            <li>Send you information about our school programs</li>
                            <li>Improve our website and services</li>
                            <li>Comply with legal obligations</li>
                        </ul>
                        
                        <h3>Information Sharing</h3>
                        <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except:</p>
                        <ul>
                            <li>To comply with legal requirements</li>
                            <li>To protect our rights and safety</li>
                            <li>With service providers who assist in our operations</li>
                        </ul>
                        
                        <h3>Data Security</h3>
                        <p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>
                        
                        <h3>Cookies</h3>
                        <p>Our website may use cookies to enhance your browsing experience. You can choose to disable cookies through your browser settings, though this may affect website functionality.</p>
                        
                        <h3>Your Rights</h3>
                        <p>You have the right to:</p>
                        <ul>
                            <li>Access your personal information</li>
                            <li>Request correction of inaccurate data</li>
                            <li>Request deletion of your information</li>
                            <li>Opt-out of communications</li>
                        </ul>
                        
                        <h3>Contact Information</h3>
                        <p>If you have questions about this Privacy Policy, please contact us:</p>
                        <ul class="list-unstyled">
                            <li><strong>Phone:</strong> <?php echo SCHOOL_PHONE; ?></li>
                            <li><strong>Email:</strong> <?php echo SCHOOL_EMAIL; ?></li>
                            <li><strong>Address:</strong> <?php echo SCHOOL_ADDRESS; ?></li>
                        </ul>
                        
                        <h3>Changes to This Policy</h3>
                        <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page with an updated revision date.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
