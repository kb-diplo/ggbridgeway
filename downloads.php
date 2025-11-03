<?php
require_once 'includes/config.php';

$page_title = 'Downloads';
$page_description = 'Download important documents, forms, and resources from Githunguri Bridgeway Preparatory School.';

// Fetch downloads from database
try {
    $stmt = $pdo->prepare("SELECT * FROM downloads WHERE is_active = 1 ORDER BY category, sort_order, created_at DESC");
    $stmt->execute();
    $downloads = $stmt->fetchAll();
} catch(PDOException $e) {
    $downloads = [];
}

// Group downloads by category
$grouped_downloads = [];
foreach ($downloads as $download) {
    $category = $download['category'] ?: 'General';
    $grouped_downloads[$category][] = $download;
}

include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header" style="background: linear-gradient(135deg, var(--navy-blue), var(--maroon)); padding: 100px 0 60px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h1 class="display-4 fw-bold mb-3">Downloads</h1>
                <p class="lead mb-0">Access important documents, forms, and resources</p>
                <nav aria-label="breadcrumb" class="mt-3">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Downloads</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Downloads Content -->
<section class="section-padding">
    <div class="container">
        <?php if (!empty($grouped_downloads)): ?>
            <?php foreach ($grouped_downloads as $category => $category_downloads): ?>
                <div class="mb-5">
                    <div class="section-title fade-in">
                        <h3 style="color: var(--navy-blue);">
                            <i class="fas fa-folder-open me-2"></i><?php echo htmlspecialchars($category); ?>
                        </h3>
                        <hr style="border-color: var(--maroon); width: 100px;">
                    </div>
                    
                    <div class="row">
                        <?php foreach ($category_downloads as $download): ?>
                            <div class="col-lg-6 col-md-6 mb-4 fade-in">
                                <div class="card h-100 shadow-sm border-0" style="border-radius: 15px; transition: all 0.3s ease;">
                                    <div class="card-body d-flex align-items-start">
                                        <div class="me-3">
                                            <div class="download-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--navy-blue), var(--maroon)); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-file-pdf text-white fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-2" style="color: var(--navy-blue);">
                                                <?php echo htmlspecialchars($download['title']); ?>
                                            </h5>
                                            <?php if (!empty($download['description'])): ?>
                                                <p class="card-text text-muted mb-3" style="font-size: 0.9rem;">
                                                    <?php echo htmlspecialchars($download['description']); ?>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <?php if (!empty($download['file_size'])): ?>
                                                        <small class="text-muted">
                                                            <i class="fas fa-weight me-1"></i><?php echo $download['file_size']; ?>
                                                        </small>
                                                    <?php endif; ?>
                                                </div>
                                                <a href="<?php echo SITE_URL . '/' . $download['file_path']; ?>" 
                                                   class="btn btn-primary btn-sm" 
                                                   target="_blank"
                                                   style="background: linear-gradient(135deg, var(--navy-blue), var(--maroon)); border: none; border-radius: 20px;">
                                                    <i class="fas fa-download me-1"></i>Download
                                                </a>
                                            </div>
                                            
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-calendar me-1"></i>
                                                Added: <?php echo date('M j, Y', strtotime($download['created_at'])); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- No downloads available -->
            <div class="text-center py-5">
                <div class="mb-4" style="color: var(--navy-blue); font-size: 4rem;">
                    <i class="fas fa-download"></i>
                </div>
                <h3 style="color: var(--navy-blue);">No Downloads Available</h3>
                <p class="text-muted mb-4">Downloads will be posted here when available. Check back soon for important documents and forms.</p>
                
                <!-- Default helpful downloads -->
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow-sm border-0" style="border-radius: 15px;">
                            <div class="card-body text-center">
                                <div class="mb-3" style="color: var(--navy-blue); font-size: 2rem;">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <h5 style="color: var(--navy-blue);">Contact Information</h5>
                                <p class="text-muted mb-3">For documents and forms, please contact the school office.</p>
                                <p class="mb-0">
                                    <strong>Phone:</strong> <?php echo SCHOOL_PHONE; ?><br>
                                    <strong>Email:</strong> <?php echo SCHOOL_EMAIL; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Call to Action -->
<section class="section-padding" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 fade-in">
                <h3 style="color: var(--navy-blue);">Need Help Finding a Document?</h3>
                <p class="mb-0 text-muted">If you can't find what you're looking for, please contact our school office. We're here to help with any documents or information you need.</p>
            </div>
            <div class="col-lg-4 text-lg-end fade-in">
                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary btn-lg" style="background: linear-gradient(135deg, var(--navy-blue), var(--maroon)); border: none; border-radius: 25px;">
                    <i class="fas fa-phone me-2"></i>Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

.download-icon {
    transition: all 0.3s ease;
}

.card:hover .download-icon {
    transform: scale(1.1);
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.5);
}
</style>

<?php include 'includes/footer.php'; ?>
