<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Create settings table if it doesn't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS site_settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(100) UNIQUE NOT NULL,
        setting_value TEXT,
        setting_description VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
    
    // Insert default settings if they don't exist
    $default_settings = [
        ['facebook_url', 'https://facebook.com/bridgewayschool', 'Facebook page URL'],
        ['twitter_url', 'https://twitter.com/bridgewayschool', 'Twitter profile URL'],
        ['instagram_url', 'https://instagram.com/bridgewayschool', 'Instagram profile URL'],
        ['youtube_url', 'https://youtube.com/@bridgewayschool', 'YouTube channel URL'],
        ['linkedin_url', '', 'LinkedIn profile URL'],
        ['developer_name', 'Lance Services', 'Website developer name'],
        ['developer_url', 'https://lanceservices.pythonanywhere.com/', 'Website developer URL'],
        ['school_motto', 'Excellence and Integrity - Lead with Values', 'School motto'],
        ['contact_hours', 'Monday - Friday: 7:00 AM - 5:00 PM, Saturday: 8:00 AM - 12:00 PM', 'School operating hours'],
        ['show_developer_credit', '1', 'Show developer credit in footer (1=yes, 0=no)']
    ];
    
    foreach ($default_settings as $setting) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO site_settings (setting_key, setting_value, setting_description) VALUES (?, ?, ?)");
        $stmt->execute($setting);
    }
} catch(PDOException $e) {
    // Table creation failed, continue anyway
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        foreach ($_POST as $key => $value) {
            if ($key !== 'submit') {
                $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) 
                                     ON DUPLICATE KEY UPDATE setting_value = ?, updated_at = CURRENT_TIMESTAMP");
                $stmt->execute([$key, $value, $value]);
            }
        }
        $message = "Settings updated successfully!";
        $message_type = "success";
    } catch(PDOException $e) {
        $message = "Error updating settings: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Get current settings
$settings = [];
try {
    $stmt = $pdo->prepare("SELECT setting_key, setting_value FROM site_settings");
    $stmt->execute();
    $results = $stmt->fetchAll();
    foreach ($results as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch(PDOException $e) {
    // If table doesn't exist, use defaults
    $settings = [
        'facebook_url' => 'https://facebook.com/bridgewayschool',
        'twitter_url' => 'https://twitter.com/bridgewayschool',
        'instagram_url' => 'https://instagram.com/bridgewayschool',
        'youtube_url' => 'https://youtube.com/@bridgewayschool',
        'linkedin_url' => '',
        'developer_name' => 'Lance Services',
        'developer_url' => 'https://lanceservices.pythonanywhere.com/',
        'school_motto' => 'Excellence and Integrity - Lead with Values',
        'contact_hours' => 'Monday - Friday: 7:00 AM - 5:00 PM, Saturday: 8:00 AM - 12:00 PM',
        'show_developer_credit' => '1'
    ];
}

include 'includes/admin_header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/admin_sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="admin-header">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">
                        <i class="fas fa-cog me-2"></i>Website Settings
                    </h1>
                </div>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST">
                <!-- Social Media Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-share-alt me-2"></i>Social Media Links
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="facebook_url" class="form-label">
                                    <i class="fab fa-facebook me-2"></i>Facebook URL
                                </label>
                                <input type="url" class="form-control" id="facebook_url" name="facebook_url" 
                                       value="<?php echo htmlspecialchars(isset($settings['facebook_url']) ? $settings['facebook_url'] : ''); ?>"
                                       placeholder="https://facebook.com/yourschool">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="twitter_url" class="form-label">
                                    <i class="fab fa-twitter me-2"></i>Twitter URL
                                </label>
                                <input type="url" class="form-control" id="twitter_url" name="twitter_url" 
                                       value="<?php echo htmlspecialchars(isset($settings['twitter_url']) ? $settings['twitter_url'] : ''); ?>"
                                       placeholder="https://twitter.com/yourschool">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="instagram_url" class="form-label">
                                    <i class="fab fa-instagram me-2"></i>Instagram URL
                                </label>
                                <input type="url" class="form-control" id="instagram_url" name="instagram_url" 
                                       value="<?php echo htmlspecialchars(isset($settings['instagram_url']) ? $settings['instagram_url'] : ''); ?>"
                                       placeholder="https://instagram.com/yourschool">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="youtube_url" class="form-label">
                                    <i class="fab fa-youtube me-2"></i>YouTube URL
                                </label>
                                <input type="url" class="form-control" id="youtube_url" name="youtube_url" 
                                       value="<?php echo htmlspecialchars(isset($settings['youtube_url']) ? $settings['youtube_url'] : ''); ?>"
                                       placeholder="https://youtube.com/@yourschool">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="linkedin_url" class="form-label">
                                    <i class="fab fa-linkedin me-2"></i>LinkedIn URL
                                </label>
                                <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" 
                                       value="<?php echo htmlspecialchars(isset($settings['linkedin_url']) ? $settings['linkedin_url'] : ''); ?>"
                                       placeholder="https://linkedin.com/company/yourschool">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- School Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-school me-2"></i>School Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="school_motto" class="form-label">School Motto</label>
                            <input type="text" class="form-control" id="school_motto" name="school_motto" 
                                   value="<?php echo htmlspecialchars(isset($settings['school_motto']) ? $settings['school_motto'] : ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="contact_hours" class="form-label">Contact Hours</label>
                            <input type="text" class="form-control" id="contact_hours" name="contact_hours" 
                                   value="<?php echo htmlspecialchars(isset($settings['contact_hours']) ? $settings['contact_hours'] : ''); ?>">
                        </div>
                    </div>
                </div>

                <!-- Developer Information (Read-Only) -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-code me-2"></i>Developer Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Website Developer</h6>
                            <p class="mb-2">This website was developed by <strong>Lance Services</strong></p>
                            <p class="mb-0">
                                <a href="https://lanceservices.pythonanywhere.com/" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-external-link-alt me-1"></i>Visit Developer Website
                                </a>
                            </p>
                        </div>
                        <small class="text-muted">Developer credit is permanently displayed in the website footer and cannot be removed.</small>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Save Settings
                    </button>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
