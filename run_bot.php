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
            
            // Обрабатываем сообщения и callback queries
            if (isset($update['message']) || isset($update['callback_query'])) {
                
                // Определяем тип обновления и устанавливаем переменные
                if (isset($update['message'])) {
                    // Обычное сообщение
                    $GLOBALS['update'] = $update;
                    $GLOBALS['chat_id'] = $update['message']['chat']['id'];
                    $GLOBALS['userId'] = $update['message']['from']['id'];
                    $GLOBALS['username'] = $update['message']['from']['username'] ?? $update['message']['from']['first_name'];
                    $GLOBALS['message'] = $update['message']['text'] ?? '';
                    $GLOBALS['message_id'] = $update['message']['message_id'];
                    $GLOBALS['firstname'] = $update['message']['from']['first_name'] ?? '';
                    $GLOBALS['lastname'] = $update['message']['from']['last_name'] ?? '';
                    $GLOBALS['chattype'] = $update['message']['chat']['type'];
                    $GLOBALS['data'] = '';
                    
                    $chat_id = $update['message']['chat']['id'];
                    $userId = $update['message']['from']['id'];
                    $firstname = $update['message']['from']['first_name'] ?? '';
                    $lastname = $update['message']['from']['last_name'] ?? '';
                    $username = $update['message']['from']['username'] ?? '';
                    $chattype = $update['message']['chat']['type'];
                    $message = $update['message']['text'] ?? '';
                    $message_id = $update['message']['message_id'];
                    $data = '';
                    
                    echo "👤 From: @{$username} ({$userId})\n";
                    echo "💭 Message: {$message}\n";
                    
                } elseif (isset($update['callback_query'])) {
                    // Callback query
                    $GLOBALS['update'] = $update;
                    $GLOBALS['chat_id'] = $update['callback_query']['message']['chat']['id'];
                    $GLOBALS['userId'] = $update['callback_query']['from']['id'];
                    $GLOBALS['username'] = $update['callback_query']['from']['username'] ?? $update['callback_query']['from']['first_name'];
                    $GLOBALS['message'] = '';
                    $GLOBALS['message_id'] = null;
                    $GLOBALS['firstname'] = $update['callback_query']['from']['first_name'] ?? '';
                    $GLOBALS['lastname'] = $update['callback_query']['from']['last_name'] ?? '';
                    $GLOBALS['chattype'] = $update['callback_query']['message']['chat']['type'];
                    $GLOBALS['data'] = $update['callback_query']['data'];
                    
                    $chat_id = $update['callback_query']['message']['chat']['id'];
                    $userId = $update['callback_query']['from']['id'];
                    $firstname = $update['callback_query']['from']['first_name'] ?? '';
                    $lastname = $update['callback_query']['from']['last_name'] ?? '';
                    $username = $update['callback_query']['from']['username'] ?? '';
                    $chattype = $update['callback_query']['message']['chat']['type'];
                    $message = '';
                    $message_id = null;
                    $data = $update['callback_query']['data'];
                    
                    // Устанавливаем callback-специфичные переменные
                    $callbackchatid = $chat_id;
                    $callbackmessageid = $update['callback_query']['message']['message_id'];
                    $callbackfname = $firstname;
                    $callbacklname = $lastname;
                    $callbackusername = $username;
                    $callbackuserid = $userId;
                    
                    echo "👤 Callback from: @{$username} ({$userId})\n";
                    echo "🎯 Data: {$data}\n";
                }
                
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
                    
                    // Включаем основные команды
                    include_once 'modules/commands.php';
                    
                    // Включаем модули
                    $modules = [
                        'modules/admin.php',
                        'modules/skcheck.php', 
                        'modules/binlookup.php',
                        'modules/iban.php',
                        'modules/stats.php',
                        'modules/me.php',
                        'modules/apikey.php'
                    ];
                    
                    foreach ($modules as $module) {
                        if (file_exists($module)) {
                            include_once $module;
                        }
                    }
                    
                    // Включаем чекеры
                    $checkers = [
                        'modules/checker/ss.php',
                        'modules/checker/schk.php', 
                        'modules/checker/sm.php'
                    ];
                    
                    foreach ($checkers as $checker) {
                        if (file_exists($checker)) {
                            include_once $checker;
                        }
                    }
                    
                    // Ответ на callback query если это callback - универсальная обработка
                    $has_callback = false;
                    $callback_id = null;
                    
                    if (is_array($update) && isset($update['callback_query'])) {
                        $has_callback = true;
                        $callback_id = $update['callback_query']['id'];
                    } elseif (is_object($update) && isset($update->callback_query)) {
                        $has_callback = true;
                        $callback_id = $update->callback_query->id;
                    }
                    
                    if ($has_callback && $callback_id) {
                        bot('answerCallbackQuery', [
                            'callback_query_id' => $callback_id
                        ]);
                    }
                    
                } catch (Exception $e) {
                    echo "❌ Error processing message: " . $e->getMessage() . "\n";
                } catch (ParseError $e) {
                    echo "❌ Parse error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine() . "\n";
                } catch (Error $e) {
                    echo "❌ Fatal error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine() . "\n";
                }
                
                echo "---\n";
            }
        }
    }
    
    // Небольшая пауза между запросами
    usleep(100000); // 0.1 секунды
}
?>