<?php
include 'config/config.php';

// Для локального тестирования временно уберем webhook
$botToken = $config['botToken'];

// Функция для отправки запроса к Telegram API
function telegramRequest($method, $parameters) {
    global $botToken;
    $url = "https://api.telegram.org/bot{$botToken}/{$method}";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $result = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($result, true);
}

// Удаляем существующий webhook (для локального тестирования)
echo "Removing existing webhook...\n";
$result = telegramRequest('deleteWebhook', []);
var_dump($result);

// Получаем информацию о боте
echo "\nGetting bot info...\n";
$result = telegramRequest('getMe', []);
if ($result['ok']) {
    echo "✅ Bot is active: @" . $result['result']['username'] . "\n";
    echo "Bot name: " . $result['result']['first_name'] . "\n";
} else {
    echo "❌ Bot token is invalid\n";
    exit(1);
}

// Тестируем отправку сообщения админу
echo "\nTesting message send to admin...\n";
$adminId = $config['adminID'];
$testResult = telegramRequest('sendMessage', [
    'chat_id' => $adminId,
    'text' => '🤖 Bot is ready and running! Server started at ' . date('Y-m-d H:i:s'),
    'parse_mode' => 'HTML'
]);

if ($testResult['ok']) {
    echo "✅ Test message sent successfully to admin (ID: {$adminId})\n";
} else {
    echo "❌ Failed to send test message: " . json_encode($testResult) . "\n";
}

echo "\n=== BOT SETUP COMPLETE ===\n";
echo "Your bot is ready to receive messages!\n";
echo "Send /start to your bot in Telegram to test it.\n";

// Для локального тестирования - запускаем в режиме long polling
echo "\nStarting long polling mode for testing...\n";
$offset = 0;

while (true) {
    $updates = telegramRequest('getUpdates', [
        'offset' => $offset,
        'timeout' => 30
    ]);
    
    if ($updates['ok'] && !empty($updates['result'])) {
        foreach ($updates['result'] as $update) {
            $offset = $update['update_id'] + 1;
            
            // Обрабатываем обновление
            echo "Processing update: " . json_encode($update) . "\n";
            
            // Имитируем webhook вызов
            $_POST = json_encode($update);
            $GLOBALS['update'] = $update;
            
            if (isset($update['message'])) {
                $GLOBALS['message'] = $update['message']['text'] ?? '';
                $GLOBALS['chat_id'] = $update['message']['chat']['id'];
                $GLOBALS['userId'] = $update['message']['from']['id'];
                $GLOBALS['username'] = $update['message']['from']['username'] ?? $update['message']['from']['first_name'];
                $GLOBALS['message_id'] = $update['message']['message_id'];
                
                // Подключаем основной код бота
                include 'main.php';
            }
        }
    }
    
    sleep(1);
}
?>