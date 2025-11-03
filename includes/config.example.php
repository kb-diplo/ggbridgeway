<?php
// Database configuration - UPDATE THESE VALUES
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

// Site configuration - UPDATE SITE_URL FOR PRODUCTION
define('SITE_NAME', 'Githunguri Bridgeway Preparatory School');
define('SITE_URL', 'http://localhost/bridgeway'); // Change to your domain
define('UPLOAD_PATH', 'uploads/');

// School contact information - UPDATE AS NEEDED
define('SCHOOL_PHONE', '020 3318581');
define('SCHOOL_WHATSAPP', '020 3318581');
define('SCHOOL_EMAIL', 'info@bridgewayschool.ac.ke');
define('SCHOOL_ADDRESS', 'Behind Githunguri Holy Family Catholic Church, Githunguri, Kiambu County, Kenya');
define('WHATSAPP_NUMBER', '254203318581');

// Security settings
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 for HTTPS

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection using PDO
try {
    $dsn = "mysql:host=" . DB_HOST . ";port=3306;dbname=" . DB_NAME . ";charset=utf8";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8 COLLATE utf8_general_ci"
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Helper functions
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function redirect($url) {
    if (!headers_sent()) {
        header("Location: " . $url);
        exit();
    } else {
        echo "<script>window.location.href='" . $url . "';</script>";
        exit();
    }
}

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1); // Set to 0 for production
?>
