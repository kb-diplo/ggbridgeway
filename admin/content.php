<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Create content tables if they don't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS site_content (
        id INT AUTO_INCREMENT PRIMARY KEY,
        content_key VARCHAR(100) UNIQUE NOT NULL,
        content_value LONGTEXT,
        content_type ENUM('text', 'textarea', 'html', 'image', 'url') DEFAULT 'text',
        section VARCHAR(50) NOT NULL,
        label VARCHAR(255) NOT NULL,
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
    
    // Insert default content if it doesn't exist
    $default_content = [
        ['hero_title', 'Building Bright Futures with Strong Foundations', 'text', 'hero', 'Hero Title', 1],
        ['hero_description', 'Nurturing young minds through quality education and strong values at Githunguri Bridgeway Preparatory School.', 'textarea', 'hero', 'Hero Description', 2],
        ['about_description', 'Located in Githunguri, Kiambu County, we are a private, co-educational day school committed to providing quality primary education following the KCPE curriculum.', 'textarea', 'about', 'About Description', 1],
        ['mission_statement', 'To provide quality primary education that nurtures academic excellence, character development, and holistic growth.', 'textarea', 'about', 'Mission Statement', 2],
        ['vision_statement', 'To be the leading preparatory school in Kiambu County, producing well-rounded students who excel academically.', 'textarea', 'about', 'Vision Statement', 3],
        ['core_values', 'Excellence, Integrity, Respect, Innovation, Community, Leadership', 'textarea', 'about', 'Core Values', 4],
        ['total_students', '40', 'text', 'stats', 'Total Students', 1],
        ['qualified_teachers', '8', 'text', 'stats', 'Qualified Teachers', 2],
        ['years_experience', '5', 'text', 'stats', 'Years of Experience', 3],
        ['success_rate', '95', 'text', 'stats', 'Success Rate (%)', 4]
    ];
    
    foreach ($default_content as $content_item) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO site_content (content_key, content_value, content_type, section, label, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute($content_item);
    }
} catch(PDOException $e) {
    // Table creation failed, continue anyway
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        foreach ($_POST as $key => $value) {
            if ($key !== 'submit') {
                $stmt = $pdo->prepare("INSERT INTO site_content (content_key, content_value) VALUES (?, ?) 
                                     ON DUPLICATE KEY UPDATE content_value = ?, updated_at = CURRENT_TIMESTAMP");
                $stmt->execute([$key, $value, $value]);
            }
        }
        $message = "Content updated successfully!";
        $message_type = "success";
    } catch(PDOException $e) {
        $message = "Error updating content: " . $e->getMessage();
        $message_type = "danger";
    }
}

// Get current content
$content = [];
try {
    $stmt = $pdo->prepare("SELECT content_key, content_value, section, label FROM site_content ORDER BY section, sort_order");
    $stmt->execute();
    $results = $stmt->fetchAll();
    foreach ($results as $row) {
        $content[$row['content_key']] = [
            'value' => $row['content_value'],
            'section' => $row['section'],
            'label' => $row['label']
        ];
    }
} catch(PDOException $e) {
    // If table doesn't exist, use defaults
    $content = [];
}

// Group content by section
$sections = [];
foreach ($content as $key => $data) {
    $sections[$data['section']][$key] = $data;
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
                        <i class="fas fa-edit me-2"></i>Website Content Management
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
                <!-- Hero Section -->
                <?php if(isset($sections['hero'])): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-star me-2"></i>Hero Section (Homepage Banner)
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php foreach($sections['hero'] as $key => $data): ?>
                            <div class="mb-3">
                                <label for="<?php echo $key; ?>" class="form-label"><?php echo $data['label']; ?></label>
                                <?php if(strpos($key, 'description') !== false): ?>
                                    <textarea class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" rows="3"><?php echo htmlspecialchars($data['value']); ?></textarea>
                                <?php else: ?>
                                    <input type="text" class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" 
                                           value="<?php echo htmlspecialchars($data['value']); ?>">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- About Section -->
                <?php if(isset($sections['about'])): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>About Us Section
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php foreach($sections['about'] as $key => $data): ?>
                            <div class="mb-3">
                                <label for="<?php echo $key; ?>" class="form-label"><?php echo $data['label']; ?></label>
                                <textarea class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" rows="4"><?php echo htmlspecialchars($data['value']); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Academics Section -->
                <?php if(isset($sections['academics'])): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-graduation-cap me-2"></i>Academics Section
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php foreach($sections['academics'] as $key => $data): ?>
                            <div class="mb-3">
                                <label for="<?php echo $key; ?>" class="form-label"><?php echo $data['label']; ?></label>
                                <textarea class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" rows="3"><?php echo htmlspecialchars($data['value']); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Contact Information -->
                <?php if(isset($sections['contact'])): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-phone me-2"></i>Contact Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach($sections['contact'] as $key => $data): ?>
                                <div class="col-md-6 mb-3">
                                    <label for="<?php echo $key; ?>" class="form-label"><?php echo $data['label']; ?></label>
                                    <input type="text" class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" 
                                           value="<?php echo htmlspecialchars($data['value']); ?>">
                                    <?php if($key == 'school_coordinates'): ?>
                                        <small class="text-muted">Format: latitude,longitude (e.g., -1.0578,36.77101)</small>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- School Statistics -->
                <?php if(isset($sections['stats'])): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i>School Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach($sections['stats'] as $key => $data): ?>
                                <div class="col-md-6 mb-3">
                                    <label for="<?php echo $key; ?>" class="form-label"><?php echo $data['label']; ?></label>
                                    <input type="number" class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" 
                                           value="<?php echo htmlspecialchars($data['value']); ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="text-center mb-4">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Save All Changes
                    </button>
                </div>
            </form>

            <!-- Preview Section -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-eye me-2"></i>Quick Preview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Current Statistics:</h6>
                            <ul class="list-unstyled">
                                <li><strong>Students:</strong> <?php echo isset($content['total_students']['value']) ? $content['total_students']['value'] : 'Not set'; ?></li>
                                <li><strong>Teachers:</strong> <?php echo isset($content['qualified_teachers']['value']) ? $content['qualified_teachers']['value'] : 'Not set'; ?></li>
                                <li><strong>Experience:</strong> <?php echo isset($content['years_experience']['value']) ? $content['years_experience']['value'] : 'Not set'; ?> years</li>
                                <li><strong>Success Rate:</strong> <?php echo isset($content['success_rate']['value']) ? $content['success_rate']['value'] : 'Not set'; ?>%</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Contact Information:</h6>
                            <ul class="list-unstyled">
                                <li><strong>Phone:</strong> <?php echo isset($content['school_phone']['value']) ? $content['school_phone']['value'] : 'Not set'; ?></li>
                                <li><strong>Email:</strong> <?php echo isset($content['school_email']['value']) ? $content['school_email']['value'] : 'Not set'; ?></li>
                                <li><strong>Address:</strong> <?php echo isset($content['school_address']['value']) ? $content['school_address']['value'] : 'Not set'; ?></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="../index.php" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-external-link-alt me-1"></i>Preview Website
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
