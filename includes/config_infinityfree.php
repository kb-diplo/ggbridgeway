<?php
// InfinityFree Database Configuration
// IMPORTANT: Update these values with your actual InfinityFree database details

// Database configuration for InfinityFree
define('DB_HOST', 'sql206.infinityfree.com');
define('DB_NAME', 'if0_40322936_bridgeway_school');
define('DB_USER', 'if0_40322936');
define('DB_PASS', 'B1ljovew'); // Replace with your actual password

// Site configuration - UPDATE SITE_URL FOR YOUR DOMAIN
define('SITE_NAME', 'Githunguri Bridgeway Preparatory School');
define('SITE_URL', 'https://githunguribridgewaypreparatoryschool.ct.ws'); // Your InfinityFree domain
define('UPLOAD_PATH', 'uploads/');

// School contact information
define('SCHOOL_PHONE', '020 3318581');
define('SCHOOL_WHATSAPP', '020 3318581');
define('SCHOOL_EMAIL', 'info@bridgewayschool.ac.ke');
define('SCHOOL_ADDRESS', 'Behind Githunguri Holy Family Catholic Church, Githunguri, Kiambu County, Kenya');
define('WHATSAPP_NUMBER', '254203318581');

// Security settings for production
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1); // Set to 1 for HTTPS (InfinityFree supports SSL)

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection using PDO with error handling for production
try {
    $dsn = "mysql:host=" . DB_HOST . ";port=3306;dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch(PDOException $e) {
    // Log error instead of displaying it in production
    error_log("Database connection failed: " . $e->getMessage());
    die("Website temporarily unavailable. Please try again later.");
}

// Helper functions
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
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

// Production error reporting (disable error display)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set to 0 for production
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');
?>
