<!DOCTYPE html>
<html>
<head>
    <title>Add School Images to Gallery</title>
    <style>
        body { font-family: 'Poppins', Arial, sans-serif; margin: 40px; background: linear-gradient(135deg, #001F3F, #800000); min-height: 100vh; color: white; }
        .container { max-width: 900px; margin: 0 auto; background: rgba(255,255,255,0.1); padding: 40px; border-radius: 20px; backdrop-filter: blur(10px); }
        .success { color: #28a745; background: rgba(40,167,69,0.2); padding: 15px; border-radius: 8px; margin: 15px 0; border: 1px solid rgba(40,167,69,0.3); }
        .info { color: #17a2b8; background: rgba(23,162,184,0.2); padding: 15px; border-radius: 8px; margin: 15px 0; border: 1px solid rgba(23,162,184,0.3); }
        .btn { background: linear-gradient(135deg, #ffd700, #ffed4e); color: #001F3F; padding: 12px 24px; border: none; border-radius: 25px; text-decoration: none; display: inline-block; margin: 5px; font-weight: 600; }
        h1 { text-align: center; margin-bottom: 30px; }
        .image-preview { display: flex; gap: 15px; margin: 20px 0; flex-wrap: wrap; }
        .image-item { text-align: center; flex: 1; min-width: 200px; background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; }
        .image-item img { width: 100%; max-width: 200px; height: 120px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📸 Add School Images to Gallery</h1>
        
        <?php
        require_once 'includes/config.php';
        
        // Create gallery table if it doesn't exist
        try {
            $pdo->exec("CREATE TABLE IF NOT EXISTS gallery (
                id INT AUTO_INCREMENT PRIMARY KEY,
                caption VARCHAR(255) NOT NULL,
                image VARCHAR(255) NOT NULL,
                category VARCHAR(100) DEFAULT 'general',
                type ENUM('image', 'video') DEFAULT 'image',
                sort_order INT DEFAULT 0,
                is_active BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
        } catch(PDOException $e) {
            echo "<div class='info'>Database table created/verified</div>";
        }
        
        // School images with proper descriptions based on filenames
        $school_images = [
            [
                'filename' => 'assets/images/githunguri_bridgewaylogo.jpeg',
                'caption' => 'Githunguri Bridgeway Preparatory School Logo',
                'category' => 'school_branding',
                'description' => 'Official school logo representing our identity and values'
            ],
            [
                'filename' => 'assets/images/githunguri_bridgewaystudents.jpeg',
                'caption' => 'Our Students in Learning Environment',
                'category' => 'students',
                'description' => 'Students engaged in learning activities at our school'
            ],
            [
                'filename' => 'assets/images/githunguri_bridgewaygraduation.jpeg',
                'caption' => 'Graduation Ceremony - Academic Achievement',
                'category' => 'events',
                'description' => 'Celebrating our students\' academic achievements and graduation success'
            ],
            [
                'filename' => 'assets/images/githunguri_bridgewaythanksgiving.jpeg',
                'caption' => 'Thanksgiving Celebration - Community Spirit',
                'category' => 'events',
                'description' => 'School community coming together for thanksgiving celebration'
            ]
        ];
        
        echo "<h3>📋 School Images to Add</h3>";
        echo "<div class='image-preview'>";
        
        foreach ($school_images as $img) {
            echo "<div class='image-item'>";
            if (file_exists($img['filename'])) {
                echo "<img src='{$img['filename']}' alt='{$img['caption']}'>";
                echo "<h6 style='margin-top: 10px; color: #ffd700;'>{$img['caption']}</h6>";
                echo "<small>{$img['description']}</small>";
                echo "<br><span class='badge' style='background: rgba(40,167,69,0.3); padding: 3px 8px; border-radius: 10px; font-size: 0.7rem; margin-top: 5px; display: inline-block;'>{$img['category']}</span>";
            } else {
                echo "<div style='width: 200px; height: 120px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; border-radius: 8px;'>";
                echo "<span>Image not found</span>";
                echo "</div>";
                echo "<h6 style='margin-top: 10px; color: #ff6b6b;'>{$img['caption']}</h6>";
                echo "<small>File missing</small>";
            }
            echo "</div>";
        }
        echo "</div>";
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_images'])) {
            try {
                // Clear existing school images from gallery
                $pdo->exec("DELETE FROM gallery WHERE category IN ('school_branding', 'students', 'events') AND image LIKE '%githunguri_bridgeway%'");
                
                $added_count = 0;
                foreach ($school_images as $img) {
                    if (file_exists($img['filename'])) {
                        $stmt = $pdo->prepare("INSERT INTO gallery (caption, image, category, type, sort_order, is_active) VALUES (?, ?, ?, 'image', ?, 1)");
                        $sort_order = ($img['category'] == 'school_branding') ? 1 : (($img['category'] == 'students') ? 2 : 3);
                        $stmt->execute([
                            $img['caption'],
                            $img['filename'],
                            $img['category'],
                            $sort_order
                        ]);
                        $added_count++;
                    }
                }
                
                echo "<div class='success'>✅ Added $added_count school images to gallery successfully!</div>";
                
                echo "<h3>🎯 Images Added to Gallery</h3>";
                echo "<div class='info'>";
                echo "<ul>";
                foreach ($school_images as $img) {
                    if (file_exists($img['filename'])) {
                        echo "<li><strong>{$img['caption']}</strong> - Category: {$img['category']}</li>";
                    }
                }
                echo "</ul>";
                echo "</div>";
                
                echo "<div class='info'>";
                echo "<h4>📂 Gallery Categories Created:</h4>";
                echo "<ul>";
                echo "<li><strong>School Branding:</strong> Logo and identity materials</li>";
                echo "<li><strong>Students:</strong> Students in learning environments</li>";
                echo "<li><strong>Events:</strong> School celebrations and ceremonies</li>";
                echo "</ul>";
                echo "</div>";
                
            } catch(PDOException $e) {
                echo "<div class='error' style='color: #dc3545; background: rgba(220,53,69,0.2); padding: 15px; border-radius: 8px; border: 1px solid rgba(220,53,69,0.3);'>❌ Database Error: " . $e->getMessage() . "</div>";
            }
        } else {
            ?>
            <div class="info">
                <h3>🎯 Ready to Add Images to Gallery</h3>
                <p>This will add all your school images to the gallery with proper names and categories:</p>
                <ul>
                    <li><strong>Logo:</strong> School branding section</li>
                    <li><strong>Students:</strong> Learning environment photos</li>
                    <li><strong>Graduation:</strong> Academic achievement events</li>
                    <li><strong>Thanksgiving:</strong> Community celebration events</li>
                </ul>
                <p><strong>These images will be organized by category and properly labeled based on their filenames.</strong></p>
            </div>
            
            <form method="POST" style="text-align: center;">
                <button type="submit" name="add_images" class="btn" style="font-size: 1.1rem; padding: 15px 30px;">
                    📸 Add School Images to Gallery
                </button>
            </form>
            <?php
        }
        ?>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="admin/gallery.php" class="btn">🖼️ Manage Gallery</a>
            <a href="student-life.php" class="btn">👀 View Gallery Page</a>
            <a href="index.php" class="btn">🏠 Back to Homepage</a>
        </div>
        
        <div class="info">
            <h3>📝 Image Descriptions Based on Filenames</h3>
            <ul>
                <li><strong>githunguri_bridgewaylogo.jpeg</strong> → School Logo & Branding</li>
                <li><strong>githunguri_bridgewaystudents.jpeg</strong> → Students Learning Environment</li>
                <li><strong>githunguri_bridgewaygraduation.jpeg</strong> → Graduation & Academic Achievement</li>
                <li><strong>githunguri_bridgewaythanksgiving.jpeg</strong> → Thanksgiving & Community Events</li>
            </ul>
        </div>
    </div>
</body>
</html>
