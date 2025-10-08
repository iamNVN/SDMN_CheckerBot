<?php
// Тестовый скрипт для проверки подключения всех модулей

echo "🔍 Проверка подключения модулей CheckerBot...\n\n";

// 1. Проверка config.php
echo "1. Проверка конфигурации...\n";
if (file_exists('config/config.php')) {
    include_once 'config/config.php';
    echo "   ✅ config.php загружен\n";
    echo "   ✅ Токен бота: " . substr($config['botToken'], 0, 10) . "...\n";
    echo "   ✅ База данных: " . $config['db']['database'] . "\n";
} else {
    echo "   ❌ config.php не найден\n";
    exit(1);
}

// 2. Проверка bot.php
echo "\n2. Проверка bot functions...\n";
if (file_exists('functions/bot.php')) {
    include_once 'functions/bot.php';
    echo "   ✅ bot.php загружен\n";
    
    if (function_exists('bot')) {
        echo "   ✅ Функция bot() доступна\n";
        
        // Тест getMe
        $result = bot('getMe');
        if ($result && isset($result->ok) && $result->ok) {
            echo "   ✅ API работает, бот: @" . $result->result->username . "\n";
        } else {
            echo "   ❌ API не отвечает\n";
        }
    } else {
        echo "   ❌ Функция bot() не найдена\n";
    }
} else {
    echo "   ❌ bot.php не найден\n";
}

// 3. Проверка db.php
echo "\n3. Проверка database functions...\n";
if (file_exists('functions/db.php')) {
    include_once 'functions/db.php';
    echo "   ✅ db.php загружен\n";
    
    // Попытка подключения к БД
    $conn = @mysqli_connect(
        $config['db']['hostname'],
        $config['db']['username'], 
        $config['db']['password'],
        $config['db']['database']
    );
    
    if ($conn) {
        echo "   ✅ Подключение к БД успешно\n";
        
        if (function_exists('countUsers')) {
            echo "   ✅ Функция countUsers() доступна\n";
        }
        
        mysqli_close($conn);
    } else {
        echo "   ❌ Ошибка подключения к БД: " . mysqli_connect_error() . "\n";
    }
} else {
    echo "   ❌ db.php не найден\n";
}

// 4. Проверка functions.php
echo "\n4. Проверка helper functions...\n";
if (file_exists('functions/functions.php')) {
    include_once 'functions/functions.php';
    echo "   ✅ functions.php загружен\n";
} else {
    echo "   ❌ functions.php не найден\n";
}

// 5. Проверка variables.php
echo "\n5. Проверка variables.php...\n";
if (file_exists('config/variables.php')) {
    // Создаем mock данные для тестирования
    $GLOBALS['update'] = (object)[
        'message' => (object)[
            'text' => '/start',
            'from' => (object)['id' => 123456],
            'chat' => (object)['id' => 123456]
        ]
    ];
    
    include_once 'config/variables.php';
    echo "   ✅ variables.php загружен без ошибок\n";
} else {
    echo "   ❌ variables.php не найден\n";
}

// 6. Проверка основных модулей
echo "\n6. Проверка модулей...\n";
$modules = [
    'modules/commands.php',
    'modules/admin.php',
    'modules/me.php'
];

foreach ($modules as $module) {
    if (file_exists($module)) {
        echo "   ✅ $module найден\n";
    } else {
        echo "   ❌ $module не найден\n";
    }
}

echo "\n🎉 Диагностика завершена!\n";
?>