<?php

/*

///==[Checker Stats Commands]==///

/stats - Returns the Checker Stats

*/


include __DIR__."/../config/config.php";
include __DIR__."/../config/variables.php";
include_once __DIR__."/../functions/bot.php";
include_once __DIR__."/../functions/db.php";
include_once __DIR__."/../functions/functions.php";


////////////====[MUTE]====////////////
if(strpos($message, "/stats") === 0 || strpos($message, "!stats") === 0){   
    $antispam = antispamCheck($userId);
    addUser($userId);
    
    if($antispam != False){
      bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"[<u>ANTI SPAM</u>] Try again after <b>$antispam</b>s.",
        'parse_mode'=>'html',
        'reply_to_message_id'=> $message_id
      ]);
      return;

    }else{
        $gStats = fetchGlobalStats();
        $uStats = fetchUserStats($userId);
        bot('sendmessage',[
          'chat_id'=>$chat_id,
          'text'=>"≡ <b>User Stats</b>

- <ins>Total Cards Checked:</ins> ".$uStats['total_checked']."
- <ins>Total CVV Cards:</ins> ".$uStats['total_cvv']."
- <ins>Total CCN Cards:</ins> ".$uStats['total_ccn']."
          
≡ <b>Global Checker Stats</b>

- <ins>Total Cards Checked:</ins> ".$gStats['total_checked']."
- <ins>Total CVV Cards:</ins> ".$gStats['total_cvv']."
- <ins>Total CCN Cards:</ins> ".$gStats['total_ccn']."",
          'parse_mode'=>'html',
          'reply_to_message_id'=> $message_id

        ]);          
            
}

}


?>

{
  "configurations": [
    {
      "type": "php",
      "request": "launch",
      "name": "Launch PHP Bot",
      "program": "${workspaceFolder}/SDMN_CheckerBot/${input:phpFile}",
      "runtimeArgs": [
        "-dxdebug.start_with_request=yes"
      ],
      "env": {
        "XDEBUG_MODE": "debug,develop"
      },
      "port": 9003
    }
  ],
  "inputs": [
    {
      "type": "pickString",
      "id": "phpFile",
      "description": "Select the PHP file to debug",
      "options": [
        "main.php",
        "run_bot.php",
        "start_bot.php",
        "test_callback.php",
        "test_db.php",
        "diagnose.php"
      ]
    }
  ]
}