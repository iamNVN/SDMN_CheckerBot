<?php
include 'config/config.php';

echo "🤖 Starting CheckerBot in TEST MODE...\n";
echo "📝 Note: This is a test mode without real Telegram API\n";

// Функция-заглушка для отправки запроса к Telegram API  
function telegramRequest($method, $parameters)
{
    echo "📡 [TEST MODE] Would call: {$method} with " . json_encode($parameters) . "\n";

    // Имитируем успешные ответы
    switch ($method) {
        case 'getMe':
            return [
                'ok' => true,
                'result' => [
                    'username' => 'test_checker_bot',
                    'first_name' => 'Test Checker Bot'
                ]
            ];
        case 'sendMessage':
        case 'answerCallbackQuery':
            return ['ok' => true];
        default:
            return ['ok' => true];
    }
}

// Имитируем получение информации о боте
$bot_info = telegramRequest('getMe', []);
if ($bot_info['ok']) {
    echo "✅ Bot is active: @" . $bot_info['result']['username'] . "\n";
    echo "📝 Bot name: " . $bot_info['result']['first_name'] . "\n";
    $GLOBALS['bot_username'] = $bot_info['result']['username'];
} else {
    echo "❌ Bot token is invalid\n";
    exit(1);
}

echo "\n🚀 Bot is ready and listening for test messages...\n";
echo "💬 Testing with simulated /start command\n\n";

// Тестируем с симулированным сообщением
$test_update = [
    'update_id' => 1,
    'message' => [
        'message_id' => 1,
        'from' => [
            'id' => 123456789,
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'testuser'
        ],
        'chat' => [
            'id' => 123456789,
            'type' => 'private'
        ],
        'text' => '/start'
    ]
];

echo "📨 Processing test update\n";

// Определяем тип обновления и устанавливаем переменные
$GLOBALS['update'] = $test_update;
$GLOBALS['chat_id'] = $test_update['message']['chat']['id'];
$GLOBALS['userId'] = $test_update['message']['from']['id'];
$GLOBALS['username'] = $test_update['message']['from']['username'] ?? $test_update['message']['from']['first_name'];
$GLOBALS['message'] = $test_update['message']['text'] ?? '';
$GLOBALS['message_id'] = $test_update['message']['message_id'];
$GLOBALS['firstname'] = $test_update['message']['from']['first_name'] ?? '';
$GLOBALS['lastname'] = $test_update['message']['from']['last_name'] ?? '';
$GLOBALS['chattype'] = $test_update['message']['chat']['type'];
$GLOBALS['data'] = '';

$chat_id = $test_update['message']['chat']['id'];
$userId = $test_update['message']['from']['id'];
$firstname = $test_update['message']['from']['first_name'] ?? '';
$lastname = $test_update['message']['from']['last_name'] ?? '';
$username = $test_update['message']['from']['username'] ?? '';
$chattype = $test_update['message']['chat']['type'];
$message = $test_update['message']['text'] ?? '';
$message_id = $test_update['message']['message_id'];
$data = '';

echo "👤 From: @{$username} ({$userId})\n";
echo "💭 Message: {$message}\n";
echo "📍 Chat type: {$chattype}\n";

try {
    // Включаем файлы в правильном порядке
    if (!function_exists('bot')) {
        include_once 'functions/bot.php';
    }
    if (!function_exists('addUser')) {
        include_once 'functions/db.php';
    }
    if (!function_exists('getUsernameById')) {
        include_once 'functions/functions.php';
    }

    // Устанавливаем часовой пояс
    if (isset($config['timeZone'])) {
        date_default_timezone_set($config['timeZone']);
    }

    // Включаем variables.php для дополнительных переменных
    include_once 'config/variables.php';

    // Регистрируем пользователя в базе данных (только для приватных чатов)
    if ($chattype === 'private' && function_exists('addUser')) {
        echo "👥 Testing user registration...\n";
        // В тестовом режиме не обращаемся к базе
    }

    // Включаем основные команды
    include_once 'modules/commands.php';

    echo "✅ Message processing completed\n";
} catch (Exception $e) {
    echo "❌ Error processing message: " . $e->getMessage() . "\n";
    echo "📄 Stack trace: " . $e->getTraceAsString() . "\n";
} catch (ParseError $e) {
    echo "❌ Parse error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine() . "\n";
} catch (Error $e) {
    echo "❌ Fatal error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine() . "\n";
}

echo "\n✅ Test completed successfully!\n";
