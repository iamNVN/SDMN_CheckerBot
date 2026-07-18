<?php
include 'config/config.php';

echo "🔍 Testing bot token...\n";
echo "Token: " . substr($config['botToken'], 0, 10) . "...\n\n";

// Функция для отправки запроса к Telegram API
function telegramRequest($method, $parameters)
{
    global $config;
    $botToken = $config['botToken'];
    $url = "https://api.telegram.org/bot{$botToken}/{$method}";

    echo "📡 Making request to: {$url}\n";
    echo "📦 Parameters: " . json_encode($parameters) . "\n";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_VERBOSE, true);

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    echo "🌐 HTTP Code: {$httpCode}\n";
    if ($error) {
        echo "❌ cURL Error: {$error}\n";
    }
    echo "📥 Response: {$result}\n\n";

    return json_decode($result, true);
}

// Тест getMe
$result = telegramRequest('getMe', []);
if ($result && $result['ok']) {
    echo "✅ Bot token is valid!\n";
    echo "🤖 Bot username: @" . $result['result']['username'] . "\n";
    echo "📝 Bot name: " . $result['result']['first_name'] . "\n";
} else {
    echo "❌ Bot token is invalid or there's a network issue\n";
    if ($result) {
        echo "Error: " . json_encode($result) . "\n";
    }
}
