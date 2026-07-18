<?php

// Безопасная обработка Telegram webhook данных
$input = file_get_contents("php://input");
$update = json_decode($input);

// Проверяем, что данные получены корректно
if (!$update) {
    // Если запуск через run_bot.php, используем глобальные переменные
    if (isset($GLOBALS['update'])) {
        // Конвертируем массив в объект рекурсивно
        $update = json_decode(json_encode($GLOBALS['update']));
    } else {
        $update = new stdClass();
    }
}

// Безопасное извлечение данных сообщения
$chat_id = isset($update->message->chat->id) ? $update->message->chat->id : (isset($GLOBALS['chat_id']) ? $GLOBALS['chat_id'] : null);
$userId = isset($update->message->from->id) ? $update->message->from->id : (isset($GLOBALS['userId']) ? $GLOBALS['userId'] : null);
$firstname = isset($update->message->from->first_name) ? $update->message->from->first_name : (isset($GLOBALS['firstname']) ? $GLOBALS['firstname'] : '');
$lastname = isset($update->message->from->last_name) ? $update->message->from->last_name : (isset($GLOBALS['lastname']) ? $GLOBALS['lastname'] : '');
$username = isset($update->message->from->username) ? $update->message->from->username : (isset($GLOBALS['username']) ? $GLOBALS['username'] : '');
$chattype = isset($update->message->chat->type) ? $update->message->chat->type : (isset($GLOBALS['chattype']) ? $GLOBALS['chattype'] : '');
$message = isset($update->message->text) ? $update->message->text : (isset($GLOBALS['message']) ? $GLOBALS['message'] : '');
$message_id = isset($update->message->message_id) ? $update->message->message_id : (isset($GLOBALS['message_id']) ? $GLOBALS['message_id'] : null);

// Безопасное извлечение данных reply сообщения
$replytomessageis = isset($update->message->reply_to_message->text) ? $update->message->reply_to_message->text : '';

// Безопасное извлечение данных callback query
$data = isset($update->callback_query->data) ? $update->callback_query->data : '';
$callbackfname = isset($update->callback_query->from->first_name) ? $update->callback_query->from->first_name : '';
$callbacklname = isset($update->callback_query->from->last_name) ? $update->callback_query->from->last_name : '';
$callbackusername = isset($update->callback_query->from->username) ? $update->callback_query->from->username : '';
$callbackchatid = isset($update->callback_query->message->chat->id) ? $update->callback_query->message->chat->id : null;
$callbackuserid = isset($update->callback_query->message->reply_to_message->from->id) ? $update->callback_query->message->reply_to_message->from->id : null;
$callbackmessageid = isset($update->callback_query->message->message_id) ? $update->callback_query->message->message_id : null;


$live_array = array(
    'incorrect_cvc', 
    '"cvc_check": "fail"', 
    '"cvc_check": "pass"', 
    'insufficient_funds',
    'Your card does not support this type of purchase',
    'transaction_not_allowed',
    'CVV INVALID'
);

?>
