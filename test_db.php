<?php
include 'config/config.php';

echo "Testing database connection...\n";
echo "Host: " . $config['db']['hostname'] . "\n";
echo "Database: " . $config['db']['database'] . "\n";
echo "Username: " . $config['db']['username'] . "\n";

$conn = mysqli_connect($config['db']['hostname'], $config['db']['username'], $config['db']['password'], $config['db']['database']);

if ($conn) {
    echo "✅ Database connection successful!\n";
    
    // Test query
    $result = mysqli_query($conn, "SHOW TABLES");
    echo "Tables in database:\n";
    while ($row = mysqli_fetch_array($result)) {
        echo "- " . $row[0] . "\n";
    }
    
    mysqli_close($conn);
} else {
    echo "❌ Database connection failed: " . mysqli_connect_error() . "\n";
}
?>