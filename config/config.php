<?php

/*
|--------------------------------------------------------------------------
| Bot Token
|--------------------------------------------------------------------------
|
| Change this to your Bot API Token
| It can be obtained from https://telegram.dog/BotFather
|
*/
$config['botToken'] = "7981870709:AAE4ndgBKunjyOYI-GBVNRu2TwBhVJZoS8E";

/*
|--------------------------------------------------------------------------
| Admin User ID
|--------------------------------------------------------------------------
|
| Change this to Admin's Numeric User ID
| ID can be obtained from https://telegram.dog/username_to_id_bot
|
*/
$config['adminID'] = "1317255118";

/*
|--------------------------------------------------------------------------
| Logs Channel ID
|--------------------------------------------------------------------------
|
| Create a New Channel/Group for logging data
| ID can be obtained from https://telegram.dog/BotFather
|
*/
$config['logsID'] =  "https://t.me/+4o9lzL5S2pA2MWM1";

/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
|
| Current timezone for Logging Activities with time
| It can be obtained from http://1min.in/content/international/time-zones
| By Default it's in Asia/Kolkata (India Standard Time)
|
*/
$config['timeZone'] =  "Asia/Kolkata";

/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
| Database to Store User Data
|
*/
$config['db']['hostname'] =  "localhost";
$config['db']['username'] =  "root";
$config['db']['password'] =  "";
$config['db']['database'] =  "checkerbot";

/*
|--------------------------------------------------------------------------
| Anti-Spam Timer
|--------------------------------------------------------------------------
|
| Anti-Spam Timer to prevent Spammers from Spamming the Checker
| Value is in Seconds. "20" = 20seconds
|
*/
$config['anti_spam_timer'] =  "20";

/*
|--------------------------------------------------------------------------
| SK Keys
|--------------------------------------------------------------------------
|
| SK Keys for !sm checker gate
| Add a Live SK Key here. You can Also add Multiple SK Keys
| array('sk1','sk2','sk3')
|
*/
$config['sk_keys'] =  array('sk_live_69GKI0saLB8uIEnxzv8VTvRX');
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