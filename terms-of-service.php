<?php
require_once 'includes/config.php';

$page_title = 'Terms of Service';
$page_description = 'Terms of Service for Githunguri Bridgeway Preparatory School website. Please read these terms carefully before using our website.';

include 'includes/header.php';
?>

<!-- Breadcrumb Section -->
<section class="breadcrumb-section">
    <div class="container">
        <h1>Terms of Service</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item active">Terms of Service</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Terms of Service Content -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <p class="text-muted mb-4"><strong>Last updated:</strong> <?php echo date('F j, Y'); ?></p>
                        
                        <h3>Agreement to Terms</h3>
                        <p>By accessing and using the Githunguri Bridgeway Preparatory School website, you accept and agree to be bound by the terms and provision of this agreement.</p>
                        
                        <h3>Use License</h3>
                        <p>Permission is granted to temporarily download one copy of the materials on our website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:</p>
                        <ul>
                            <li>Modify or copy the materials</li>
                            <li>Use the materials for any commercial purpose or for any public display</li>
                            <li>Attempt to reverse engineer any software contained on our website</li>
                            <li>Remove any copyright or other proprietary notations from the materials</li>
                        </ul>
                        
                        <h3>Disclaimer</h3>
                        <p>The materials on our website are provided on an 'as is' basis. Githunguri Bridgeway Preparatory School makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>
                        
                        <h3>Limitations</h3>
                        <p>In no event shall Githunguri Bridgeway Preparatory School or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on our website, even if we or our authorized representative has been notified orally or in writing of the possibility of such damage.</p>
                        
                        <h3>Accuracy of Materials</h3>
                        <p>The materials appearing on our website could include technical, typographical, or photographic errors. We do not warrant that any of the materials on its website are accurate, complete, or current. We may make changes to the materials contained on its website at any time without notice.</p>
                        
                        <h3>Links</h3>
                        <p>We have not reviewed all of the sites linked to our website and are not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by us of the site. Use of any such linked website is at the user's own risk.</p>
                        
                        <h3>Modifications</h3>
                        <p>We may revise these terms of service for its website at any time without notice. By using this website, you are agreeing to be bound by the then current version of these terms of service.</p>
                        
                        <h3>Governing Law</h3>
                        <p>These terms and conditions are governed by and construed in accordance with the laws of Kenya and you irrevocably submit to the exclusive jurisdiction of the courts in that State or location.</p>
                        
                        <h3>School-Specific Terms</h3>
                        <h5>Admission Information</h5>
                        <p>Information provided about our admission process, fees, and programs is subject to change. Please contact the school directly for the most current information.</p>
                        
                        <h5>Student Information</h5>
                        <p>Any student information submitted through our website will be handled in accordance with our Privacy Policy and applicable education privacy laws.</p>
                        
                        <h5>Communication</h5>
                        <p>By providing your contact information, you consent to receive communications from the school regarding admissions, programs, and school-related matters.</p>
                        
                        <h3>Contact Information</h3>
                        <p>If you have any questions about these Terms of Service, please contact us:</p>
                        <ul class="list-unstyled">
                            <li><strong>Phone:</strong> <?php echo SCHOOL_PHONE; ?></li>
                            <li><strong>Email:</strong> <?php echo SCHOOL_EMAIL; ?></li>
                            <li><strong>Address:</strong> <?php echo SCHOOL_ADDRESS; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
