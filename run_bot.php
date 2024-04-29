<?php
include 'config/config.php';

// Функция для отправки запроса к Telegram API
function telegramRequest($method, $parameters) {
    global $config;
    $botToken = $config['botToken'];
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

// Удаляем существующий webhook
echo "🤖 Starting CheckerBot...\n";
echo "📡 Removing existing webhook...\n";
$result = telegramRequest('deleteWebhook', []);

// Получаем информацию о боте
echo "🔍 Getting bot info...\n";
$result = telegramRequest('getMe', []);
if ($result['ok']) {
    echo "✅ Bot is active: @" . $result['result']['username'] . "\n";
    echo "📝 Bot name: " . $result['result']['first_name'] . "\n";
} else {
    echo "❌ Bot token is invalid\n";
    exit(1);
}

echo "\n🚀 Bot is ready and listening for messages...\n";
echo "💬 Send /start to your bot in Telegram to test it.\n";
echo "⏹️  Press Ctrl+C to stop the bot\n\n";

// Long polling для получения обновлений
$offset = 0;

while (true) {
    $updates = telegramRequest('getUpdates', [
        'offset' => $offset,
        'timeout' => 30
    ]);
    
    if ($updates['ok'] && !empty($updates['result'])) {
        foreach ($updates['result'] as $update) {
            $offset = $update['update_id'] + 1;
            
            echo "📨 Processing update: " . $update['update_id'] . "\n";
            
            // Обрабатываем только сообщения
            if (isset($update['message'])) {
                // Устанавливаем глобальные переменные как в webhook
                $GLOBALS['update'] = $update;
                $GLOBALS['chat_id'] = $update['message']['chat']['id'];
                $GLOBALS['userId'] = $update['message']['from']['id'];
                $GLOBALS['username'] = $update['message']['from']['username'] ?? $update['message']['from']['first_name'];
                $GLOBALS['message'] = $update['message']['text'] ?? '';
                $GLOBALS['message_id'] = $update['message']['message_id'];
                $GLOBALS['firstname'] = $update['message']['from']['first_name'] ?? '';
                $GLOBALS['lastname'] = $update['message']['from']['last_name'] ?? '';
                $GLOBALS['chattype'] = $update['message']['chat']['type'];
                
                // Устанавливаем переменные для включаемых файлов
                $chat_id = $update['message']['chat']['id'];
                $userId = $update['message']['from']['id'];
                $firstname = $update['message']['from']['first_name'] ?? '';
                $lastname = $update['message']['from']['last_name'] ?? '';
                $username = $update['message']['from']['username'] ?? '';
                $chattype = $update['message']['chat']['type'];
                $message = $update['message']['text'] ?? '';
                $message_id = $update['message']['message_id'];
                
                echo "👤 From: @{$username} ({$userId})\n";
                echo "💭 Message: {$message}\n";
                
                try {
                    // Включаем основной файл бота без variables.php
                    include_once 'config/config.php';
                    include_once 'functions/bot.php';
                    include_once 'functions/functions.php';
                    include_once 'functions/db.php';
                    
                    date_default_timezone_set($config['timeZone']);
                    
                    // Включаем модули
                    include_once 'modules/admin.php';
                    include_once 'modules/skcheck.php';
                    include_once 'modules/binlookup.php';
                    include_once 'modules/iban.php';
                    include_once 'modules/stats.php';
                    include_once 'modules/me.php';
                    include_once 'modules/apikey.php';
                    
                    // Включаем чекеры (они могут иметь проблемы с путями)
                    if (file_exists('modules/checker/ss.php')) {
                        include_once 'modules/checker/ss.php';
                    }
                    if (file_exists('modules/checker/schk.php')) {
                        include_once 'modules/checker/schk.php';
                    }
                    if (file_exists('modules/checker/sm.php')) {
                        include_once 'modules/checker/sm.php';
                    }
                    
                    // Обработка команды /start
                    if (strpos($message, "/start") === 0) {
                        if (!isBanned($userId) && !isMuted($userId)) {
                            $messagesec = "";
                            if ($userId == $config['adminID']) {
                                $messagesec = "<b>Type /admin to know admin commands</b>";
                            }
                            
                            addUser($userId);
                            bot('sendmessage', [
                                'chat_id' => $chat_id,
                                'text' => "<b>Hello @$username,

Type /cmds to know all my commands!</b>

$messagesec",
                                'parse_mode' => 'html',
                                'reply_to_message_id' => $message_id,
                                'reply_markup' => json_encode(['inline_keyboard' => [
                                    [
                                        ['text' => '📋 Commands', 'callback_data' => 'cmds'],
                                        ['text' => '📊 Stats', 'callback_data' => 'stats']
                                    ]
                                ]])
                            ]);
                            echo "✅ Sent welcome message\n";
                        }
                    }
                    
                } catch (Exception $e) {
                    echo "❌ Error processing message: " . $e->getMessage() . "\n";
                }
                
                echo "---\n";
            }
        }
    }
    
    // Небольшая пауза между запросами
    usleep(100000); // 0.1 секунды
}
?>