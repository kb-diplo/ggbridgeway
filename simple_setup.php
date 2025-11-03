<!DOCTYPE html>
<html>
<head>
    <title>Bridgeway School - Database Setup</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #28a745; background: #d4edda; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .btn { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none; display: inline-block; }
        .btn:hover { background: #0056b3; }
        h1 { color: #001F3F; }
        h2 { color: #800000; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎓 Githunguri Bridgeway Preparatory School</h1>
        <h2>Database Setup & Configuration</h2>

        <?php
        // Database configuration
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 'bridgeway_school';

        try {
            // Step 1: Connect to MySQL without specifying database
            echo "<h3>Step 1: Connecting to MySQL...</h3>";
            $pdo = new PDO("mysql:host=$db_host", $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<div class='success'>✅ Connected to MySQL successfully!</div>";

            // Step 2: Create database
            echo "<h3>Step 2: Creating database...</h3>";
            $pdo->exec("CREATE DATABASE IF NOT EXISTS $db_name");
            echo "<div class='success'>✅ Database '$db_name' created successfully!</div>";

            // Step 3: Use the database
            $pdo->exec("USE $db_name");
            echo "<div class='success'>✅ Using database '$db_name'</div>";

            // Step 4: Create tables
            echo "<h3>Step 3: Creating tables...</h3>";

            // Admins table
            $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            echo "<div class='success'>✅ Admins table created</div>";

            // Banners table
            $pdo->exec("CREATE TABLE IF NOT EXISTS banners (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                image VARCHAR(255) NOT NULL,
                description TEXT,
                youtube_url VARCHAR(500) NULL,
                button_text VARCHAR(100) DEFAULT 'Learn More',
                button_link VARCHAR(500) NULL,
                is_active BOOLEAN DEFAULT TRUE,
                sort_order INT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            echo "<div class='success'>✅ Banners table created</div>";

            // Events table
            $pdo->exec("CREATE TABLE IF NOT EXISTS events (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                date DATE NOT NULL,
                details TEXT,
                image VARCHAR(255),
                youtube_url VARCHAR(500) NULL,
                is_featured BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            echo "<div class='success'>✅ Events table created</div>";

            // Gallery table
            $pdo->exec("CREATE TABLE IF NOT EXISTS gallery (
                id INT AUTO_INCREMENT PRIMARY KEY,
                caption VARCHAR(255),
                image VARCHAR(255) NULL,
                youtube_url VARCHAR(500) NULL,
                category VARCHAR(50) DEFAULT 'general',
                type ENUM('image', 'video') DEFAULT 'image',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            echo "<div class='success'>✅ Gallery table created</div>";

            // Messages table
            $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                phone VARCHAR(20),
                message TEXT NOT NULL,
                type ENUM('contact', 'admission') NOT NULL,
                status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            echo "<div class='success'>✅ Messages table created</div>";

            // Site settings table
            $pdo->exec("CREATE TABLE IF NOT EXISTS site_settings (
                id INT AUTO_INCREMENT PRIMARY KEY,
                setting_key VARCHAR(100) UNIQUE NOT NULL,
                setting_value TEXT,
                setting_description VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )");
            echo "<div class='success'>✅ Site settings table created</div>";

            // School media table
            $pdo->exec("CREATE TABLE IF NOT EXISTS school_media (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                media_type ENUM('image', 'video', 'document') NOT NULL,
                file_path VARCHAR(500) NULL,
                youtube_url VARCHAR(500) NULL,
                category VARCHAR(100) DEFAULT 'general',
                is_featured BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            echo "<div class='success'>✅ School media table created</div>";

            // Step 5: Insert default data
            echo "<h3>Step 4: Adding default data...</h3>";

            // Default admin (password: admin123)
            $pdo->exec("INSERT IGNORE INTO admins (username, password) VALUES 
                ('admin', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')");
            echo "<div class='success'>✅ Default admin user created (admin/admin123)</div>";

            // Default banners
            $pdo->exec("INSERT IGNORE INTO banners (id, title, image, description, button_text, button_link, sort_order) VALUES 
                (1, 'Welcome to Githunguri Bridgeway Preparatory School', 'assets/images/banner1.jpg', 'Excellence and Integrity - Lead with Values', 'Learn More', '/about.php', 1),
                (2, 'KCPE Excellence Program', 'assets/images/banner2.jpg', 'Quality education following the Kenyan curriculum', 'View Academics', '/academics.php', 2),
                (3, 'Nurturing Young Minds', 'assets/images/banner3.jpg', 'Building tomorrow\\'s leaders today', 'Apply Today', '/admissions.php', 3)");
            echo "<div class='success'>✅ Default banners added</div>";

            // Default events
            $pdo->exec("INSERT IGNORE INTO events (id, title, date, details, is_featured) VALUES 
                (1, 'School Opening Day 2024', '2024-01-15', 'Welcome back students! New term begins.', TRUE),
                (2, 'Annual Sports Day', '2024-03-20', 'Inter-house sports competition.', TRUE),
                (3, 'Academic Excellence Awards', '2024-07-10', 'Celebrating our top students.', FALSE)");
            echo "<div class='success'>✅ Default events added</div>";

            // Default settings
            $settings = [
                ['facebook_url', 'https://facebook.com/bridgewayschool', 'Facebook page URL'],
                ['twitter_url', 'https://twitter.com/bridgewayschool', 'Twitter profile URL'],
                ['instagram_url', 'https://instagram.com/bridgewayschool', 'Instagram profile URL'],
                ['youtube_url', 'https://youtube.com/@bridgewayschool', 'YouTube channel URL'],
                ['developer_name', 'Lance Services', 'Website developer name'],
                ['developer_url', 'https://lanceservices.pythonanywhere.com/', 'Website developer URL'],
                ['school_motto', 'Excellence and Integrity - Lead with Values', 'School motto'],
                ['contact_hours', 'Monday - Friday: 7:00 AM - 5:00 PM\\nSaturday: 8:00 AM - 12:00 PM', 'School operating hours'],
                ['show_developer_credit', '1', 'Show developer credit in footer']
            ];

            foreach ($settings as $setting) {
                $stmt = $pdo->prepare("INSERT IGNORE INTO site_settings (setting_key, setting_value, setting_description) VALUES (?, ?, ?)");
                $stmt->execute($setting);
            }
            echo "<div class='success'>✅ Default settings configured</div>";

            echo "<h2>🎉 Setup Complete!</h2>";
            echo "<p><strong>Your website is now ready to use!</strong></p>";
            echo "<div style='margin: 20px 0;'>";
            echo "<a href='index.php' class='btn' style='margin-right: 10px;'>🌐 View Website</a>";
            echo "<a href='admin/' class='btn'>🔧 Admin Panel</a>";
            echo "</div>";

            echo "<h3>📋 Login Information:</h3>";
            echo "<p><strong>Admin Panel:</strong> <code>http://localhost/bridgeway/admin</code></p>";
            echo "<p><strong>Username:</strong> <code>admin</code></p>";
            echo "<p><strong>Password:</strong> <code>admin123</code></p>";

            echo "<h3>✨ Features Available:</h3>";
            echo "<ul>";
            echo "<li>✅ Complete school website with all pages</li>";
            echo "<li>✅ Admin dashboard for content management</li>";
            echo "<li>✅ YouTube video integration</li>";
            echo "<li>✅ Social media management</li>";
            echo "<li>✅ Contact and admission forms</li>";
            echo "<li>✅ Developer credit: Lance Services</li>";
            echo "</ul>";

        } catch(PDOException $e) {
            echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
            echo "<p>Please make sure:</p>";
            echo "<ul>";
            echo "<li>XAMPP MySQL is running</li>";
            echo "<li>MySQL is accessible on localhost:3306</li>";
            echo "<li>Root user has no password (default XAMPP setup)</li>";
            echo "</ul>";
        }
        ?>
    </div>
</body>
</html>
