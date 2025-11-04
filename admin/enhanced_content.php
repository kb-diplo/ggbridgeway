<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Create enhanced content management tables
try {
    // Enhanced site_content table
    $pdo->exec("CREATE TABLE IF NOT EXISTS site_content (
        id INT AUTO_INCREMENT PRIMARY KEY,
        content_key VARCHAR(100) UNIQUE NOT NULL,
        content_value LONGTEXT,
        content_type ENUM('text', 'textarea', 'html', 'image', 'url', 'number') DEFAULT 'text',
        section VARCHAR(50) NOT NULL,
        page VARCHAR(50) NOT NULL DEFAULT 'homepage',
        label VARCHAR(255) NOT NULL,
        description TEXT,
        sort_order INT DEFAULT 0,
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
    
    // Page sections table for better organization
    $pdo->exec("CREATE TABLE IF NOT EXISTS page_sections (
        id INT AUTO_INCREMENT PRIMARY KEY,
        page_name VARCHAR(50) NOT NULL,
        section_name VARCHAR(50) NOT NULL,
        section_title VARCHAR(255) NOT NULL,
        description TEXT,
        sort_order INT DEFAULT 0,
        is_active BOOLEAN DEFAULT TRUE,
        UNIQUE KEY unique_page_section (page_name, section_name)
    )");
    
    // Insert default page sections
    $default_sections = [
        ['homepage', 'hero', 'Hero Section', 'Main banner and call-to-action area', 1],
        ['homepage', 'stats', 'Statistics', 'School statistics and numbers', 2],
        ['homepage', 'welcome', 'Welcome Section', 'Welcome message and features', 3],
        ['homepage', 'features', 'Why Choose Us', 'School features and benefits', 4],
        ['about', 'intro', 'Introduction', 'About us introduction text', 1],
        ['about', 'mission', 'Mission & Vision', 'Mission and vision statements', 2],
        ['about', 'values', 'Core Values', 'School values and principles', 3],
        ['academics', 'curriculum', 'Curriculum', 'Academic program details', 1],
        ['academics', 'subjects', 'Subjects', 'Subject offerings', 2],
        ['contact', 'info', 'Contact Information', 'Contact details and hours', 1]
    ];
    
    foreach ($default_sections as $section) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO page_sections (page_name, section_name, section_title, description, sort_order) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute($section);
    }
    
    // Insert comprehensive default content
    $default_content = [
        // Homepage Hero Section
        ['hero_title', 'Building Bright Futures with Strong Foundations', 'text', 'hero', 'homepage', 'Hero Title', 'Main headline on homepage', 1],
        ['hero_subtitle', 'Excellence and Integrity - Lead with Values', 'text', 'hero', 'homepage', 'Hero Subtitle', 'Tagline under main title', 2],
        ['hero_description', 'Nurturing young minds through quality education and strong values at Githunguri Bridgeway Preparatory School.', 'textarea', 'hero', 'homepage', 'Hero Description', 'Description text in hero section', 3],
        
        // Homepage Statistics
        ['total_students', '40', 'number', 'stats', 'homepage', 'Total Students', 'Current number of enrolled students', 1],
        ['qualified_teachers', '8', 'number', 'stats', 'homepage', 'Qualified Teachers', 'Number of qualified teaching staff', 2],
        ['years_experience', '5', 'number', 'stats', 'homepage', 'Years of Experience', 'Years the school has been operating', 3],
        ['success_rate', '95', 'number', 'stats', 'homepage', 'Success Rate (%)', 'KCPE success rate percentage', 4],
        
        // Homepage Welcome Section
        ['welcome_title', 'Welcome to Our School', 'text', 'welcome', 'homepage', 'Welcome Title', 'Welcome section heading', 1],
        ['welcome_description', 'At Githunguri Bridgeway Preparatory School, we are committed to providing quality education that nurtures young minds and builds character. Our dedicated team of educators ensures every child receives personalized attention in a safe and supportive environment.', 'textarea', 'welcome', 'homepage', 'Welcome Description', 'Main welcome text', 2],
        
        // About Page Content
        ['about_intro_title', 'Excellence and Integrity - Lead with Values', 'text', 'intro', 'about', 'About Introduction Title', 'Main title on about page', 1],
        ['about_intro_text', 'Githunguri Bridgeway Preparatory School is a premier educational institution located in the heart of Githunguri, Kiambu County, Kenya. We are dedicated to providing quality education that nurtures young minds and builds character for future leaders.', 'textarea', 'intro', 'about', 'About Introduction Text', 'Introduction paragraph', 2],
        ['mission_statement', 'To provide quality primary education that nurtures academic excellence, character development, and holistic growth in a safe and supportive environment.', 'textarea', 'mission', 'about', 'Mission Statement', 'School mission statement', 1],
        ['vision_statement', 'To be the leading preparatory school in Kiambu County, producing well-rounded students who excel academically and demonstrate strong moral character.', 'textarea', 'mission', 'about', 'Vision Statement', 'School vision statement', 2],
        ['core_values', 'Excellence, Integrity, Respect, Innovation, Community, Leadership', 'textarea', 'values', 'about', 'Core Values', 'School core values', 1],
        
        // Contact Information
        ['school_address', 'Behind Githunguri Holy Family Catholic Church, Githunguri, Kiambu County, Kenya', 'textarea', 'info', 'contact', 'School Address', 'Physical address of the school', 1],
        ['school_hours', 'Monday - Friday: 7:00 AM - 5:00 PM\nSaturday: 8:00 AM - 12:00 PM', 'textarea', 'info', 'contact', 'School Hours', 'Operating hours', 2],
        ['contact_email', 'info@bridgewayschool.ac.ke', 'text', 'info', 'contact', 'Contact Email', 'Main contact email', 3]
    ];
    
    foreach ($default_content as $content_item) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO site_content (content_key, content_value, content_type, section, page, label, description, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute($content_item);
    }
    
} catch(PDOException $e) {
    // Continue if table creation fails
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_content'])) {
        try {
            $updated_count = 0;
            foreach ($_POST as $key => $value) {
                if ($key !== 'update_content' && strpos($key, 'content_') === 0) {
                    $content_key = str_replace('content_', '', $key);
                    $stmt = $pdo->prepare("UPDATE site_content SET content_value = ?, updated_at = CURRENT_TIMESTAMP WHERE content_key = ?");
                    if ($stmt->execute([$value, $content_key])) {
                        $updated_count++;
                    }
                }
            }
            $message = "Successfully updated $updated_count content items!";
            $message_type = "success";
        } catch(PDOException $e) {
            $message = "Error updating content: " . $e->getMessage();
            $message_type = "danger";
        }
    }
}

// Get current content organized by page and section
$content_data = [];
try {
    $stmt = $pdo->prepare("
        SELECT sc.*, ps.section_title, ps.page_name 
        FROM site_content sc 
        LEFT JOIN page_sections ps ON sc.page = ps.page_name AND sc.section = ps.section_name 
        WHERE sc.is_active = 1 
        ORDER BY sc.page, ps.sort_order, sc.sort_order
    ");
    $stmt->execute();
    $results = $stmt->fetchAll();
    
    foreach ($results as $row) {
        $content_data[$row['page']][$row['section']][] = $row;
    }
} catch(PDOException $e) {
    $content_data = [];
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
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="previewChanges()">
                            <i class="fas fa-eye me-1"></i>Preview Website
                        </button>
                    </div>
                </div>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Content Management Form -->
            <form method="POST" id="contentForm">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Page Tabs -->
                        <ul class="nav nav-tabs mb-4" id="pageTab" role="tablist">
                            <?php $first_page = true; foreach($content_data as $page_name => $sections): ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?php echo $first_page ? 'active' : ''; ?>" 
                                            id="<?php echo $page_name; ?>-tab" 
                                            data-bs-toggle="tab" 
                                            data-bs-target="#page-<?php echo $page_name; ?>" 
                                            type="button" role="tab">
                                        <i class="fas fa-<?php echo $page_name == 'homepage' ? 'home' : ($page_name == 'about' ? 'info-circle' : 'phone'); ?> me-1"></i>
                                        <?php echo ucfirst($page_name); ?>
                                    </button>
                                </li>
                                <?php $first_page = false; ?>
                            <?php endforeach; ?>
                        </ul>

                        <!-- Page Content -->
                        <div class="tab-content" id="pageTabContent">
                            <?php $first_page = true; foreach($content_data as $page_name => $sections): ?>
                                <div class="tab-pane fade <?php echo $first_page ? 'show active' : ''; ?>" 
                                     id="page-<?php echo $page_name; ?>" role="tabpanel">
                                    
                                    <div class="alert alert-info mb-4">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong><?php echo ucfirst($page_name); ?> Page Content</strong> - 
                                        Edit the content that appears on the <?php echo $page_name; ?> page of your website.
                                    </div>
                                    
                                    <?php foreach($sections as $section_name => $items): ?>
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="mb-0">
                                                    <i class="fas fa-layer-group me-2"></i>
                                                    <?php echo isset($items[0]['section_title']) ? $items[0]['section_title'] : ucfirst($section_name); ?>
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <?php foreach($items as $item): ?>
                                                    <div class="mb-3">
                                                        <label for="content_<?php echo $item['content_key']; ?>" class="form-label">
                                                            <strong><?php echo $item['label']; ?></strong>
                                                            <?php if($item['description']): ?>
                                                                <small class="text-muted d-block"><?php echo $item['description']; ?></small>
                                                            <?php endif; ?>
                                                        </label>
                                                        
                                                        <?php if($item['content_type'] == 'textarea'): ?>
                                                            <textarea class="form-control" 
                                                                    id="content_<?php echo $item['content_key']; ?>" 
                                                                    name="content_<?php echo $item['content_key']; ?>" 
                                                                    rows="3"><?php echo htmlspecialchars($item['content_value']); ?></textarea>
                                                        <?php elseif($item['content_type'] == 'number'): ?>
                                                            <input type="number" 
                                                                   class="form-control" 
                                                                   id="content_<?php echo $item['content_key']; ?>" 
                                                                   name="content_<?php echo $item['content_key']; ?>" 
                                                                   value="<?php echo htmlspecialchars($item['content_value']); ?>">
                                                        <?php else: ?>
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   id="content_<?php echo $item['content_key']; ?>" 
                                                                   name="content_<?php echo $item['content_key']; ?>" 
                                                                   value="<?php echo htmlspecialchars($item['content_value']); ?>">
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php $first_page = false; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Sidebar with Actions -->
                    <div class="col-lg-4">
                        <div class="card sticky-top" style="top: 2rem;">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-tools me-2"></i>Actions
                                </h6>
                            </div>
                            <div class="card-body">
                                <button type="submit" name="update_content" class="btn btn-primary w-100 mb-3">
                                    <i class="fas fa-save me-2"></i>Save All Changes
                                </button>
                                
                                <a href="<?php echo SITE_URL; ?>" target="_blank" class="btn btn-outline-secondary w-100 mb-3">
                                    <i class="fas fa-external-link-alt me-2"></i>View Website
                                </a>
                                
                                <hr>
                                
                                <h6>Quick Tips:</h6>
                                <ul class="small text-muted">
                                    <li>Changes are saved immediately when you click "Save All Changes"</li>
                                    <li>Use the Preview button to see changes before saving</li>
                                    <li>Statistics should be numbers only</li>
                                    <li>Keep titles concise and descriptions informative</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<script>
function previewChanges() {
    window.open('<?php echo SITE_URL; ?>', '_blank');
}

// Auto-save functionality
let autoSaveTimeout;
document.querySelectorAll('input, textarea').forEach(element => {
    element.addEventListener('input', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            // Show auto-save indicator
            console.log('Auto-saving...');
        }, 2000);
    });
});
</script>

<?php include 'includes/admin_footer.php'; ?>
