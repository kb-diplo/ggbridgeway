<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';
$section = isset($_GET['section']) ? $_GET['section'] : 'homepage';

// Create content tables if they don't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS site_content (
        id INT AUTO_INCREMENT PRIMARY KEY,
        content_key VARCHAR(100) UNIQUE NOT NULL,
        content_value LONGTEXT,
        content_type ENUM('text', 'textarea', 'html', 'image', 'url') DEFAULT 'text',
        section VARCHAR(50) NOT NULL,
        label VARCHAR(255) NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
} catch(PDOException $e) {
    $message = "Database error: " . $e->getMessage();
    $message_type = "danger";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_content'])) {
    try {
        foreach ($_POST['content'] as $key => $value) {
            $stmt = $pdo->prepare("INSERT INTO site_content (content_key, content_value, section, label) VALUES (?, ?, ?, ?) 
                                   ON DUPLICATE KEY UPDATE content_value = VALUES(content_value)");
            $stmt->execute([$key, $value, $section, $key]);
        }
        $message = "Content updated successfully!";
        $message_type = "success";
    } catch(PDOException $e) {
        $message = "Error updating content: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Fetch existing content for the section
$content = [];
try {
    $stmt = $pdo->prepare("SELECT content_key, content_value FROM site_content WHERE section = ?");
    $stmt->execute([$section]);
    $results = $stmt->fetchAll();
    foreach ($results as $row) {
        $content[$row['content_key']] = $row['content_value'];
    }
} catch(PDOException $e) {
    // Continue with empty content
}

// Define content sections and their fields
$sections = [
    'homepage' => [
        'title' => 'Homepage Content',
        'fields' => [
            'hero_title' => ['label' => 'Hero Title', 'type' => 'text', 'default' => 'Building Bright Futures with Strong Foundations'],
            'hero_subtitle' => ['label' => 'Hero Subtitle', 'type' => 'text', 'default' => 'Excellence and Integrity - Lead with Values'],
            'hero_description' => ['label' => 'Hero Description', 'type' => 'textarea', 'default' => 'Nurturing young minds through quality education and strong values at Githunguri Bridgeway Preparatory School.'],
            'welcome_title' => ['label' => 'Welcome Section Title', 'type' => 'text', 'default' => 'Welcome to Our School'],
            'welcome_content' => ['label' => 'Welcome Content', 'type' => 'textarea', 'default' => 'We provide quality primary education...'],
            'total_students' => ['label' => 'Total Students', 'type' => 'text', 'default' => '40'],
            'qualified_teachers' => ['label' => 'Qualified Teachers', 'type' => 'text', 'default' => '8'],
            'success_rate' => ['label' => 'Success Rate (%)', 'type' => 'text', 'default' => '95'],
            'years_experience' => ['label' => 'Years of Experience', 'type' => 'text', 'default' => '5']
        ]
    ],
    'about' => [
        'title' => 'About Us Content',
        'fields' => [
            'mission_title' => ['label' => 'Mission Title', 'type' => 'text', 'default' => 'Our Mission'],
            'mission_content' => ['label' => 'Mission Statement', 'type' => 'textarea', 'default' => 'To provide quality primary education...'],
            'vision_title' => ['label' => 'Vision Title', 'type' => 'text', 'default' => 'Our Vision'],
            'vision_content' => ['label' => 'Vision Statement', 'type' => 'textarea', 'default' => 'To be the leading preparatory school...'],
            'values_title' => ['label' => 'Values Title', 'type' => 'text', 'default' => 'Our Values'],
            'values_content' => ['label' => 'Values Content', 'type' => 'textarea', 'default' => 'Excellence, Integrity, Leadership...'],
            'history_title' => ['label' => 'History Title', 'type' => 'text', 'default' => 'Our History'],
            'history_content' => ['label' => 'School History', 'type' => 'textarea', 'default' => 'Established in...']
        ]
    ],
    'academics' => [
        'title' => 'Academics Content',
        'fields' => [
            'academics_intro' => ['label' => 'Academics Introduction', 'type' => 'textarea', 'default' => 'Our academic program follows the KCPE curriculum...'],
            'curriculum_title' => ['label' => 'Curriculum Title', 'type' => 'text', 'default' => 'KCPE Curriculum'],
            'curriculum_content' => ['label' => 'Curriculum Description', 'type' => 'textarea', 'default' => 'We follow the Kenya Certificate of Primary Education curriculum...'],
            'subjects_offered' => ['label' => 'Subjects Offered', 'type' => 'textarea', 'default' => 'Mathematics, English, Kiswahili, Science, Social Studies...']
        ]
    ],
    'contact' => [
        'title' => 'Contact Information',
        'fields' => [
            'school_phone' => ['label' => 'School Phone', 'type' => 'text', 'default' => '020 3318581'],
            'school_email' => ['label' => 'School Email', 'type' => 'text', 'default' => 'info@bridgewayschool.ac.ke'],
            'school_address' => ['label' => 'School Address', 'type' => 'textarea', 'default' => 'Behind Githunguri Holy Family Catholic Church, Githunguri, Kiambu County, Kenya'],
            'office_hours' => ['label' => 'Office Hours', 'type' => 'text', 'default' => 'Monday - Friday: 7:00 AM - 5:00 PM'],
            'contact_person' => ['label' => 'Contact Person', 'type' => 'text', 'default' => 'School Administrator']
        ]
    ]
];

include 'includes/admin_header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/admin_sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-edit me-2"></i>Content Management - <?php echo $sections[$section]['title']; ?>
                </h1>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Section Navigation -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-sitemap me-2"></i>Website Sections
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach($sections as $key => $sec): ?>
                            <div class="col-md-3 mb-2">
                                <a href="?section=<?php echo $key; ?>" 
                                   class="btn <?php echo $section == $key ? 'btn-primary' : 'btn-outline-primary'; ?> w-100">
                                    <?php echo $sec['title']; ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Content Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-pencil-alt me-2"></i>Edit <?php echo $sections[$section]['title']; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <?php foreach($sections[$section]['fields'] as $key => $field): ?>
                            <div class="mb-3">
                                <label for="<?php echo $key; ?>" class="form-label">
                                    <strong><?php echo $field['label']; ?></strong>
                                </label>
                                
                                <?php if($field['type'] == 'textarea'): ?>
                                    <textarea class="form-control" id="<?php echo $key; ?>" name="content[<?php echo $key; ?>]" rows="4"><?php echo htmlspecialchars(isset($content[$key]) ? $content[$key] : $field['default']); ?></textarea>
                                <?php else: ?>
                                    <input type="<?php echo $field['type']; ?>" class="form-control" id="<?php echo $key; ?>" 
                                           name="content[<?php echo $key; ?>]" 
                                           value="<?php echo htmlspecialchars(isset($content[$key]) ? $content[$key] : $field['default']); ?>">
                                <?php endif; ?>
                                
                                <small class="form-text text-muted">
                                    This content appears on the <?php echo strtolower($sections[$section]['title']); ?> page.
                                </small>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" name="update_content" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Save Changes
                            </button>
                            <a href="../index.php" target="_blank" class="btn btn-outline-secondary">
                                <i class="fas fa-external-link-alt me-1"></i>Preview Website
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Preview -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-eye me-2"></i>Current Content Preview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach($sections[$section]['fields'] as $key => $field): ?>
                            <div class="col-md-6 mb-3">
                                <strong><?php echo $field['label']; ?>:</strong><br>
                                <small class="text-muted">
                                    <?php 
                                    $value = isset($content[$key]) ? $content[$key] : $field['default'];
                                    echo htmlspecialchars(strlen($value) > 100 ? substr($value, 0, 100) . '...' : $value);
                                    ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
