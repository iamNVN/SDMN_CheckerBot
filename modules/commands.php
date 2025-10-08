<?php

/*
Основные команды бота
*/

//////////////===[START]===//////////////

if(strpos($message, "/start") === 0){

  if(!isBanned($userId) && !isMuted($userId)){
    
    $messagesec = "";
    if($userId == $config['adminID']){
      $messagesec = "<b>Type /admin to know admin commands</b>";
    }
    
    addUser($userId);
    bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"<b>Hello @$username,

Type /cmds to know all my commands!</b>

$messagesec",
    'parse_mode'=>'html',
    'reply_to_message_id'=> $message_id,
    'reply_markup'=>json_encode(['inline_keyboard'=>[
    [['text'=>"📋 Commands",'callback_data'=>"cmds"],['text'=>"📊 Stats",'callback_data'=>"stats"]],
    ],'resize_keyboard'=>true])
    ]);

  }
}

//////////////===[CMDS]===//////////////

if(strpos($message, "/cmds") === 0 || strpos($message, "!cmds") === 0){

  if(!isBanned($userId) && !isMuted($userId)){
    bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"<b>Which commands would you like to check?</b>",
    'parse_mode'=>'html',
    'reply_to_message_id'=> $message_id,
    'reply_markup'=>json_encode(['inline_keyboard'=>[
    [['text'=>"💳 CC Checker Gates",'callback_data'=>"checkergates"]],[['text'=>"🛠 Other Commands",'callback_data'=>"othercmds"]],
    ],'resize_keyboard'=>true])
    ]);
  }
}

// Callback обработка для команд
if($data == "cmds"){
  bot('editMessageText',[
  'chat_id'=>$callbackchatid,
  'message_id'=>$callbackmessageid,
  'text'=>"<b>Which commands would you like to check?</b>",
  'parse_mode'=>'html',
  'reply_markup'=>json_encode(['inline_keyboard'=>[
  [['text'=>"💳 CC Checker Gates",'callback_data'=>"checkergates"]],[['text'=>"🛠 Other Commands",'callback_data'=>"othercmds"]],
  ],'resize_keyboard'=>true])
  ]);
}

if($data == "back"){
  bot('editMessageText',[
  'chat_id'=>$callbackchatid,
  'message_id'=>$callbackmessageid,
  'text'=>"<b>Which commands would you like to check?</b>",
  'parse_mode'=>'html',
  'reply_markup'=>json_encode(['inline_keyboard'=>[
  [['text'=>"💳 CC Checker Gates",'callback_data'=>"checkergates"]],[['text'=>"🛠 Other Commands",'callback_data'=>"othercmds"]],
  ],'resize_keyboard'=>true])
  ]);
}

if($data == "checkergates"){
  bot('editMessageText',[
  'chat_id'=>$callbackchatid,
  'message_id'=>$callbackmessageid,
  'text'=>"<b>━━CC Checker Gates━━</b>

<b>/ss | !ss - Stripe [Auth]</b>
<b>/sm | !sm - Stripe [Merchant]</b>
<b>/schk | !schk - User Stripe Merchant [Needs SK]</b>

<b>━━━━━━━━━━━━━━━━━━━━━━</b>

<b>Format: /gate cc|mm|yy|cvv</b>
<b>Example: /ss 4111111111111111|12|2025|123</b>",
  'parse_mode'=>'html',
  'reply_markup'=>json_encode(['inline_keyboard'=>[
  [['text'=>"🔙 Back",'callback_data'=>"back"]],
  ],'resize_keyboard'=>true])
  ]);
}

if($data == "othercmds"){
  bot('editMessageText',[
  'chat_id'=>$callbackchatid,
  'message_id'=>$callbackmessageid,
  'text'=>"<b>━━Other Commands━━</b>

<b>/me - Check your account info</b>
<b>/bin - BIN Lookup</b>
<b>/iban - IBAN Validation</b>
<b>/sk - Check Stripe Key</b>
<b>/stats - Bot Statistics</b>

<b>━━━━━━━━━━━━━━━━━━━━━━</b>

<b>Format: /command input</b>
<b>Example: /bin 411111</b>",
  'parse_mode'=>'html',
  'reply_markup'=>json_encode(['inline_keyboard'=>[
  [['text'=>"🔙 Back",'callback_data'=>"back"]],
  ],'resize_keyboard'=>true])
  ]);
}

if($data == "stats"){
  $botstats = bot('sendmessage',[
  'chat_id'=>$callbackchatid,
  'text'=>"<b>Bot Statistics</b>

<b>Total Users:</b> " . countUsers() . "
<b>Total Checks:</b> " . countChecks() . "

<b>Bot Status:</b> ✅ Online",
  'parse_mode'=>'html',
  'reply_markup'=>json_encode(['inline_keyboard'=>[
  [['text'=>"🔙 Back",'callback_data'=>"cmds"]],
  ],'resize_keyboard'=>true])
  ]);
}

?>