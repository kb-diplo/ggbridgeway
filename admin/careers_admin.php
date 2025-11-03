<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Handle form submission for adding/editing careers
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_career'])) {
        $title = sanitize_input($_POST['title']);
        $department = sanitize_input($_POST['department']);
        $description = sanitize_input($_POST['description']);
        $requirements = sanitize_input($_POST['requirements']);
        $salary_range = sanitize_input($_POST['salary_range']);
        $employment_type = sanitize_input($_POST['employment_type']);
        $location = sanitize_input($_POST['location']);
        $application_deadline = $_POST['application_deadline'] ? $_POST['application_deadline'] : null;
        
        try {
            $stmt = $pdo->prepare("INSERT INTO careers (title, department, description, requirements, salary_range, employment_type, location, application_deadline) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $department, $description, $requirements, $salary_range, $employment_type, $location, $application_deadline]);
            $message = "Career opportunity added successfully!";
            $message_type = "success";
        } catch(PDOException $e) {
            $message = "Error adding career opportunity.";
            $message_type = "danger";
        }
    }
}

// Handle actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = (int)$_GET['id'];
    
    try {
        if ($action == 'delete') {
            $stmt = $pdo->prepare("DELETE FROM careers WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Career opportunity deleted successfully.";
            $message_type = "success";
        } elseif ($action == 'toggle') {
            $stmt = $pdo->prepare("UPDATE careers SET is_active = NOT is_active WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Career status updated.";
            $message_type = "success";
        }
    } catch(PDOException $e) {
        $message = "Error performing action.";
        $message_type = "danger";
    }
}

// Get careers
try {
    $stmt = $pdo->prepare("SELECT * FROM careers ORDER BY created_at DESC");
    $stmt->execute();
    $careers = $stmt->fetchAll();
} catch(PDOException $e) {
    $careers = [];
}

// Get job applications
try {
    $stmt = $pdo->prepare("SELECT ja.*, c.title as job_title FROM job_applications ja 
                          LEFT JOIN careers c ON ja.career_id = c.id 
                          ORDER BY ja.created_at DESC");
    $stmt->execute();
    $applications = $stmt->fetchAll();
} catch(PDOException $e) {
    $applications = [];
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
                        <i class="fas fa-briefcase me-2"></i>Career Management
                    </h1>
                </div>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Add Career Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>Post New Job Opening
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Job Title *</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-control" id="department" name="department">
                                    <option value="Teaching">Teaching</option>
                                    <option value="Administration">Administration</option>
                                    <option value="Support Staff">Support Staff</option>
                                    <option value="Management">Management</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Job Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="requirements" class="form-label">Requirements *</label>
                            <textarea class="form-control" id="requirements" name="requirements" rows="4" 
                                      placeholder="List each requirement on a new line" required></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="salary_range" class="form-label">Salary Range</label>
                                <input type="text" class="form-control" id="salary_range" name="salary_range" 
                                       placeholder="e.g., Ksh 30,000 - 45,000">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="employment_type" class="form-label">Employment Type</label>
                                <select class="form-control" id="employment_type" name="employment_type">
                                    <option value="full-time">Full-time</option>
                                    <option value="part-time">Part-time</option>
                                    <option value="contract">Contract</option>
                                    <option value="temporary">Temporary</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" 
                                       value="Githunguri, Kiambu County">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="application_deadline" class="form-label">Application Deadline</label>
                            <input type="date" class="form-control" id="application_deadline" name="application_deadline">
                        </div>
                        
                        <button type="submit" name="add_career" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Post Job Opening
                        </button>
                    </form>
                </div>
            </div>

            <!-- Current Job Openings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Current Job Openings (<?php echo count($careers); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($careers)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Department</th>
                                        <th>Salary Range</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th>Applications</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($careers as $career): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($career['title']); ?></strong><br>
                                                <small class="text-muted"><?php echo ucfirst(str_replace('-', ' ', $career['employment_type'])); ?></small>
                                            </td>
                                            <td><?php echo htmlspecialchars($career['department']); ?></td>
                                            <td><?php echo htmlspecialchars($career['salary_range'] ?: 'Not specified'); ?></td>
                                            <td>
                                                <?php if($career['application_deadline']): ?>
                                                    <?php echo date('M j, Y', strtotime($career['application_deadline'])); ?>
                                                    <?php if(strtotime($career['application_deadline']) < time()): ?>
                                                        <br><small class="text-danger">Expired</small>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <small class="text-muted">No deadline</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo $career['is_active'] ? 'success' : 'secondary'; ?>">
                                                    <?php echo $career['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $app_count = 0;
                                                foreach($applications as $app) {
                                                    if($app['career_id'] == $career['id']) $app_count++;
                                                }
                                                echo $app_count;
                                                ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="careers_admin.php?action=toggle&id=<?php echo $career['id']; ?>" 
                                                       class="btn btn-outline-<?php echo $career['is_active'] ? 'warning' : 'success'; ?>" 
                                                       title="<?php echo $career['is_active'] ? 'Deactivate' : 'Activate'; ?>">
                                                        <i class="fas fa-<?php echo $career['is_active'] ? 'eye-slash' : 'eye'; ?>"></i>
                                                    </a>
                                                    <a href="careers_admin.php?action=delete&id=<?php echo $career['id']; ?>" 
                                                       class="btn btn-outline-danger" title="Delete"
                                                       onclick="return confirmDelete('Are you sure you want to delete this job posting?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No job openings posted</h5>
                            <p class="text-muted">Use the form above to post your first job opening.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Job Applications -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Job Applications (<?php echo count($applications); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($applications)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Position</th>
                                        <th>Application Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($applications as $app): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($app['applicant_name']); ?></strong><br>
                                                <small class="text-muted">
                                                    <i class="fas fa-envelope me-1"></i><?php echo htmlspecialchars($app['email']); ?>
                                                    <?php if($app['phone']): ?>
                                                        <br><i class="fas fa-phone me-1"></i><?php echo htmlspecialchars($app['phone']); ?>
                                                    <?php endif; ?>
                                                </small>
                                            </td>
                                            <td><?php echo htmlspecialchars($app['job_title'] ?: 'Position Deleted'); ?></td>
                                            <td><?php echo date('M j, Y g:i A', strtotime($app['created_at'])); ?></td>
                                            <td>
                                                <span class="badge bg-<?php 
                                                    echo $app['application_status'] == 'pending' ? 'warning' : 
                                                        ($app['application_status'] == 'hired' ? 'success' : 
                                                        ($app['application_status'] == 'rejected' ? 'danger' : 'info')); ?>">
                                                    <?php echo ucfirst($app['application_status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" 
                                                        onclick="viewApplication(<?php echo $app['id']; ?>)">
                                                    <i class="fas fa-eye"></i> View
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No applications received</h5>
                            <p class="text-muted">Applications will appear here when candidates apply for your job postings.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function viewApplication(appId) {
    // This would open a modal with application details
    alert('Application details feature - to be implemented with full application viewing');
}
</script>

<?php include 'includes/admin_footer.php'; ?>
