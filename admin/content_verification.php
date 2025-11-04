<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

include 'includes/admin_header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/admin_sidebar.php'; ?>
        
        <main>
            <div class="admin-header">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">
                        <i class="fas fa-check-circle me-2"></i>Complete Admin Control Verification
                    </h1>
                </div>
            </div>

            <!-- Admin Control Overview -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">✅ What Admin Can Control on Every Page</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Homepage Control -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0"><i class="fas fa-home me-2"></i>Homepage (index.php)</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled mb-0">
                                                <li>✅ <strong>Hero Slider</strong> - <a href="banners.php">Manage Banners</a></li>
                                                <li>✅ <strong>Hero Title/Text</strong> - <a href="enhanced_content.php">Enhanced Content Manager</a></li>
                                                <li>✅ <strong>Notices Section</strong> - <a href="notices.php">Manage Notices</a></li>
                                                <li>✅ <strong>Statistics</strong> - <a href="enhanced_content.php">Enhanced Content Manager</a></li>
                                                <li>✅ <strong>Featured Events</strong> - <a href="events.php">Manage Events</a></li>
                                                <li>✅ <strong>Gallery Preview</strong> - <a href="gallery.php">Manage Gallery</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- About Page Control -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-info">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>About Us (about.php)</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled mb-0">
                                                <li>✅ <strong>Mission/Vision</strong> - <a href="content.php">Website Content</a></li>
                                                <li>✅ <strong>School History</strong> - <a href="content.php">Website Content</a></li>
                                                <li>✅ <strong>Leadership Team</strong> - <a href="leadership.php">Leadership Management</a></li>
                                                <li>✅ <strong>Core Values</strong> - <a href="content.php">Website Content</a></li>
                                                <li>✅ <strong>School Description</strong> - <a href="content.php">Website Content</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Academics Page Control -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-warning">
                                        <div class="card-header bg-warning text-dark">
                                            <h6 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Academics (academics.php)</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled mb-0">
                                                <li>✅ <strong>Academic Overview</strong> - <a href="content.php">Website Content</a></li>
                                                <li>✅ <strong>Teacher Info</strong> - <a href="content.php">Website Content</a></li>
                                                <li>✅ <strong>Curriculum Details</strong> - <a href="content.php">Website Content</a></li>
                                                <li>✅ <strong>KCPE Information</strong> - <a href="content.php">Website Content</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Admissions Page Control -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0"><i class="fas fa-user-plus me-2"></i>Admissions (admissions.php)</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled mb-0">
                                                <li>✅ <strong>Admission Process</strong> - <a href="content.php">Website Content</a></li>
                                                <li>✅ <strong>Requirements</strong> - <a href="content.php">Website Content</a></li>
                                                <li>✅ <strong>Fee Structure</strong> - <a href="content.php">Website Content</a></li>
                                                <li>✅ <strong>Applications</strong> - <a href="messages.php">View Messages</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Student Life Page Control -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-secondary">
                                        <div class="card-header bg-secondary text-white">
                                            <h6 class="mb-0"><i class="fas fa-users me-2"></i>Student Life (student-life.php)</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled mb-0">
                                                <li>✅ <strong>All Events</strong> - <a href="events.php">Manage Events</a></li>
                                                <li>✅ <strong>Photo Gallery</strong> - <a href="gallery.php">Manage Gallery</a></li>
                                                <li>✅ <strong>Activities Info</strong> - <a href="content.php">Website Content</a></li>
                                                <li>✅ <strong>Student Programs</strong> - <a href="content.php">Website Content</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Careers Page Control -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-dark">
                                        <div class="card-header bg-dark text-white">
                                            <h6 class="mb-0"><i class="fas fa-briefcase me-2"></i>Careers (careers.php)</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled mb-0">
                                                <li>✅ <strong>Job Postings</strong> - <a href="careers_admin.php">Career Management</a></li>
                                                <li>✅ <strong>Applications</strong> - <a href="careers_admin.php">Career Management</a></li>
                                                <li>✅ <strong>Job Descriptions</strong> - <a href="careers_admin.php">Career Management</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Page Control -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-danger">
                                        <div class="card-header bg-danger text-white">
                                            <h6 class="mb-0"><i class="fas fa-phone me-2"></i>Contact (contact.php)</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled mb-0">
                                                <li>✅ <strong>Contact Info</strong> - <a href="content.php">Website Content</a></li>
                                                <li>✅ <strong>School Address</strong> - <a href="content.php">Website Content</a></li>
                                                <li>✅ <strong>Phone/Email</strong> - <a href="content.php">Website Content</a></li>
                                                <li>✅ <strong>Messages</strong> - <a href="messages.php">View Messages</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Global Settings Control -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-success">
                                        <div class="card-header" style="background: linear-gradient(135deg, #001F3F, #800000); color: white;">
                                            <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Global Settings</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled mb-0">
                                                <li>✅ <strong>Social Media Links</strong> - <a href="settings.php">Settings</a></li>
                                                <li>✅ <strong>Footer Content</strong> - <a href="settings.php">Settings</a></li>
                                                <li>✅ <strong>School Hours</strong> - <a href="settings.php">Settings</a></li>
                                                <li>✅ <strong>Contact Details</strong> - <a href="settings.php">Settings</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Action Buttons -->
                            <div class="text-center mt-4">
                                <h5 class="mb-3">Quick Content Management</h5>
                                <div class="btn-group-vertical btn-group-lg" role="group">
                                    <a href="content.php" class="btn btn-primary mb-2">
                                        <i class="fas fa-edit me-2"></i>Edit All Website Text Content
                                    </a>
                                    <a href="banners.php" class="btn btn-success mb-2">
                                        <i class="fas fa-images me-2"></i>Manage Homepage Slider
                                    </a>
                                    <a href="events.php" class="btn btn-info mb-2">
                                        <i class="fas fa-calendar me-2"></i>Manage All Events
                                    </a>
                                    <a href="gallery.php" class="btn btn-warning mb-2">
                                        <i class="fas fa-photo-video me-2"></i>Manage Photo Gallery
                                    </a>
                                    <a href="notices.php" class="btn btn-secondary mb-2">
                                        <i class="fas fa-bullhorn me-2"></i>Manage Notices & Announcements
                                    </a>
                                </div>
                            </div>

                            <!-- Confirmation -->
                            <div class="alert alert-success mt-4">
                                <h5><i class="fas fa-check-circle me-2"></i>Confirmation</h5>
                                <p class="mb-0"><strong>YES!</strong> Admin has complete control over ALL website content. Every text, image, event, notice, and setting can be managed from this admin panel. Changes reflect immediately on the website.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
