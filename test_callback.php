<?php
// Простой тест для проверки обработки callback query

include 'config/config.php';
include_once 'functions/bot.php';

echo "🧪 Тестируем обработку callback query...\n\n";

// Создаем mock update как массив (как в run_bot.php)
$update = [
    'update_id' => 123456,
    'callback_query' => [
        'id' => 'test_callback_id_123',
        'from' => [
            'id' => 5913439523,
            'first_name' => 'Test',
            'username' => 'testuser'
        ],
        'data' => 'test_data',
        'message' => [
            'chat' => [
                'id' => 5913439523,
                'type' => 'private'
            ]
        ]
    ]
];

echo "1. Update type: " . gettype($update) . "\n";
echo "2. Has callback_query: " . (isset($update['callback_query']) ? 'YES' : 'NO') . "\n";

if (isset($update['callback_query'])) {
    echo "3. Callback ID: " . $update['callback_query']['id'] . "\n";
    
    // Пробуем вызвать bot функцию
    try {
        $result = bot('answerCallbackQuery', [
            'callback_query_id' => $update['callback_query']['id']
        ]);
        echo "4. ✅ answerCallbackQuery успешно выполнено\n";
        var_dump($result);
    } catch (Exception $e) {
        echo "4. ❌ Ошибка в answerCallbackQuery: " . $e->getMessage() . "\n";
    }
} else {
    echo "3. ❌ callback_query не найден\n";
}

echo "\n🧪 Тест завершен\n";
?>