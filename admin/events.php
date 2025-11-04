<?php
require_once '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    redirect('login.php');
}

$message = '';
$message_type = '';

// Create events table if it doesn't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        details LONGTEXT,
        date DATE NOT NULL,
        time TIME,
        location VARCHAR(255),
        image VARCHAR(255),
        is_featured BOOLEAN DEFAULT FALSE,
        is_active BOOLEAN DEFAULT TRUE,
        created_by INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
} catch(PDOException $e) {
    // Continue if table creation fails
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_event'])) {
        $title = sanitize_input($_POST['title']);
        $description = sanitize_input($_POST['description']);
        $details = sanitize_input($_POST['details']);
        $date = $_POST['date'];
        $time = $_POST['time'];
        $location = sanitize_input($_POST['location']);
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        
        try {
            $stmt = $pdo->prepare("INSERT INTO events (title, description, details, date, time, location, is_featured, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $details, $date, $time, $location, $is_featured, $_SESSION['admin_id']]);
            $message = "Event added successfully!";
            $message_type = "success";
        } catch(PDOException $e) {
            $message = "Error adding event: " . $e->getMessage();
            $message_type = "danger";
        }
    }
}

// Get all events
try {
    $stmt = $pdo->prepare("SELECT * FROM events ORDER BY date DESC, created_at DESC");
    $stmt->execute();
    $events = $stmt->fetchAll();
} catch(PDOException $e) {
    $events = [];
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
                        <i class="fas fa-calendar-alt me-2"></i>Events & News Management
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                        <i class="fas fa-plus me-1"></i>Add New Event
                    </button>
                </div>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Events List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">School Events (<?php echo count($events); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($events)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Event Details</th>
                                        <th>Date & Time</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($events as $event): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($event['title']); ?></strong>
                                                <?php if($event['is_featured']): ?>
                                                    <span class="badge bg-warning ms-2">Featured</span>
                                                <?php endif; ?>
                                                <br>
                                                <small class="text-muted"><?php echo htmlspecialchars(substr($event['description'], 0, 100)) . '...'; ?></small>
                                            </td>
                                            <td>
                                                <strong><?php echo date('M j, Y', strtotime($event['date'])); ?></strong><br>
                                                <small class="text-muted"><?php echo $event['time'] ? date('g:i A', strtotime($event['time'])) : 'All Day'; ?></small>
                                            </td>
                                            <td>
                                                <small><?php echo htmlspecialchars($event['location']) ?: 'TBA'; ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo $event['is_active'] ? 'success' : 'secondary'; ?>">
                                                    <?php echo $event['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Events Found</h5>
                            <p class="text-muted">Start by adding your first school event using the button above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add New Event
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="title" class="form-label">Event Title *</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label">Event Date *</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="time" class="form-label">Event Time</label>
                            <input type="time" class="form-control" id="time" name="time">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="e.g., School Hall">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Short Description *</label>
                        <textarea class="form-control" id="description" name="description" rows="2" required placeholder="Brief description for event preview"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="details" class="form-label">Full Details</label>
                        <textarea class="form-control" id="details" name="details" rows="4" placeholder="Complete event information and details"></textarea>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured">
                        <label class="form-check-label" for="is_featured">
                            <strong>Featured Event</strong> <small class="text-muted">(Show on homepage)</small>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_event" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Add Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
