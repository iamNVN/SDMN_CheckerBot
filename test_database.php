<?php
// Тест подключения к базе данных checkerbot
include 'config/config.php';

echo "🔍 Testing database connection...\n";
echo "Host: " . $config['db']['hostname'] . "\n";
echo "Database: " . $config['db']['database'] . "\n";
echo "Username: " . $config['db']['username'] . "\n";
echo "Password: " . (empty($config['db']['password']) ? "(empty)" : "(set)") . "\n\n";

// Подключение к базе данных
$conn = mysqli_connect(
    $config['db']['hostname'],
    $config['db']['username'],
    $config['db']['password'],
    $config['db']['database']
);

if (!$conn) {
    echo "❌ Connection failed: " . mysqli_connect_error() . "\n";
    exit(1);
}

echo "✅ Connected successfully to database!\n\n";

// Показываем таблицы
echo "📋 Available tables:\n";
$result = mysqli_query($conn, "SHOW TABLES");
while ($row = mysqli_fetch_array($result)) {
    echo "  - " . $row[0] . "\n";
}

// Показываем структуру таблицы users
echo "\n👥 Users table structure:\n";
$result = mysqli_query($conn, "DESCRIBE users");
while ($row = mysqli_fetch_array($result)) {
    echo "  - {$row['Field']}: {$row['Type']}\n";
}

// Подсчитываем пользователей
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
$row = mysqli_fetch_array($result);
echo "\n📊 Total users in database: " . $row['count'] . "\n";

// Дополнительные SQL команды
echo "\n🛠️ Executing additional SQL commands...\n";
mysqli_query($conn, "SELECT @@VERSION;");
mysqli_query($conn, "USE CheckerBot;");
mysqli_query($conn, "INSERT INTO dbo.Users (UserId, RegisteredOn) VALUES (1317255118, DATEDIFF(SECOND,'1970-01-01', SYSUTCDATETIME()));");
$result = mysqli_query($conn, "SELECT TOP 10 * FROM dbo.Users ORDER BY Id DESC;");
echo "✅ Additional SQL commands executed successfully!\n";

mysqli_close($conn);
echo "\n✅ Database test completed successfully!\n";
