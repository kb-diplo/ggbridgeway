<?php
echo "<h1>PHP Test - Githunguri Bridgeway School</h1>";
echo "<p>PHP is working! ✅</p>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";

// Test database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=bridgeway_school", "root", "");
    echo "<p>Database connection: ✅ Success</p>";
} catch(PDOException $e) {
    echo "<p>Database connection: ❌ " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<a href='simple_setup.php'>🔧 Run Database Setup</a> | ";
echo "<a href='index.php'>🌐 View Website</a> | ";
echo "<a href='admin/'>🔐 Admin Panel</a>";
?>
