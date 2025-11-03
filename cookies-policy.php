<?php
require_once 'includes/config.php';

$page_title = 'Cookies Policy';
$page_description = 'Cookies Policy for Githunguri Bridgeway Preparatory School website. Learn about how we use cookies to improve your browsing experience.';

include 'includes/header.php';
?>

<!-- Breadcrumb Section -->
<section class="breadcrumb-section">
    <div class="container">
        <h1>Cookies Policy</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Cookies Policy</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Cookies Policy Content -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <p class="text-muted mb-4"><strong>Last updated:</strong> <?php echo date('F j, Y'); ?></p>
                        
                        <h3>What Are Cookies</h3>
                        <p>Cookies are small text files that are placed on your computer or mobile device when you visit our website. They are widely used to make websites work more efficiently and provide information to website owners.</p>
                        
                        <h3>How We Use Cookies</h3>
                        <p>Githunguri Bridgeway Preparatory School uses cookies to:</p>
                        <ul>
                            <li>Remember your preferences and settings</li>
                            <li>Improve website performance and user experience</li>
                            <li>Analyze website traffic and usage patterns</li>
                            <li>Ensure website security</li>
                            <li>Remember your login status (admin area)</li>
                        </ul>
                        
                        <h3>Types of Cookies We Use</h3>
                        
                        <h5>Essential Cookies</h5>
                        <p>These cookies are necessary for the website to function properly. They enable basic functions like page navigation, access to secure areas, and form submissions.</p>
                        
                        <h5>Performance Cookies</h5>
                        <p>These cookies collect information about how visitors use our website, such as which pages are visited most often. This data helps us improve our website's performance.</p>
                        
                        <h5>Functionality Cookies</h5>
                        <p>These cookies allow our website to remember choices you make (such as language preferences) and provide enhanced, more personal features.</p>
                        
                        <h5>Session Cookies</h5>
                        <p>These temporary cookies are deleted when you close your browser. They help maintain your session while browsing our website.</p>
                        
                        <h3>Third-Party Cookies</h3>
                        <p>Our website may also use third-party cookies from:</p>
                        <ul>
                            <li><strong>Google Analytics:</strong> To analyze website traffic and user behavior</li>
                            <li><strong>Social Media Platforms:</strong> For social media integration and sharing</li>
                            <li><strong>Content Delivery Networks:</strong> To improve website loading speed</li>
                        </ul>
                        
                        <h3>Managing Cookies</h3>
                        <p>You can control and manage cookies in several ways:</p>
                        
                        <h5>Browser Settings</h5>
                        <p>Most web browsers allow you to:</p>
                        <ul>
                            <li>View what cookies are stored on your device</li>
                            <li>Delete cookies individually or all at once</li>
                            <li>Block cookies from specific websites</li>
                            <li>Block all cookies</li>
                            <li>Get notified when a cookie is set</li>
                        </ul>
                        
                        <h5>Browser-Specific Instructions</h5>
                        <ul>
                            <li><strong>Chrome:</strong> Settings > Privacy and Security > Cookies and other site data</li>
                            <li><strong>Firefox:</strong> Options > Privacy & Security > Cookies and Site Data</li>
                            <li><strong>Safari:</strong> Preferences > Privacy > Cookies and website data</li>
                            <li><strong>Edge:</strong> Settings > Cookies and site permissions</li>
                        </ul>
                        
                        <h3>Impact of Disabling Cookies</h3>
                        <p>If you choose to disable cookies, some features of our website may not function properly, including:</p>
                        <ul>
                            <li>Form submissions and contact features</li>
                            <li>User preferences and settings</li>
                            <li>Admin login functionality</li>
                            <li>Website performance optimization</li>
                        </ul>
                        
                        <h3>Cookie Consent</h3>
                        <p>By continuing to use our website, you consent to our use of cookies as described in this policy. We may display a cookie consent banner on your first visit to inform you about our cookie usage.</p>
                        
                        <h3>Updates to This Policy</h3>
                        <p>We may update this Cookies Policy from time to time to reflect changes in our practices or for other operational, legal, or regulatory reasons. Please check this page periodically for updates.</p>
                        
                        <h3>Contact Us</h3>
                        <p>If you have any questions about our use of cookies, please contact us:</p>
                        <ul class="list-unstyled">
                            <li><strong>Phone:</strong> <?php echo SCHOOL_PHONE; ?></li>
                            <li><strong>Email:</strong> <?php echo SCHOOL_EMAIL; ?></li>
                            <li><strong>Address:</strong> <?php echo SCHOOL_ADDRESS; ?></li>
                        </ul>
                        
                        <div class="alert alert-info mt-4">
                            <h6><i class="fas fa-info-circle me-2"></i>Cookie Notice</h6>
                            <p class="mb-0">This website uses cookies to ensure you get the best experience on our website. By continuing to browse, you agree to our use of cookies.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
