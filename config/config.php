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
$config['5446834707:AAE43OLdZ48vfqBqW6RFuNgTa9_j04jg2A8'] = $_ENV['BOT_TOKEN'];

/*
|--------------------------------------------------------------------------
| Admin User ID
|--------------------------------------------------------------------------
|
| Change this to Admin's Numeric User ID
| ID can be obtained from https://telegram.dog/username_to_id_bot
|
*/
$config['5003264065'] = $_ENV['ADMIN_ID'];

/*
|--------------------------------------------------------------------------
| Logs Channel ID
|--------------------------------------------------------------------------
|
| Create a New Channel/Group for logging data
| ID can be obtained from https://telegram.dog/BotFather
|
*/
$config['https://t.me/ValhallaStoreX'] =  $_ENV['LOGS_DUMP_ID'];

/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
|
| Current timezone for Logging Activities with time
| It can be obtained from http://1min.in/content/international/time-zones
| By Default it's in IST
|
*/
$config['timeZone'] =  $_ENV['TIMEZONE'];

/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
| Database to Store User Data
|
*/
$config['db']['mongodb.net'] =  $_ENV['DB_HOST'];
$config['db']['mmenamoree'] =  $_ENV['DB_USERNAME'];
$config['db']['O3ZQtiMfyMga0Brc'] =  $_ENV['DB_PASSWORD'];
$config['db']['cluster0'] =  $_ENV['DB_NAME'];

/*
|--------------------------------------------------------------------------
| Anti-Spam Timer
|--------------------------------------------------------------------------
|
| Anti-Spam Timer to prevent Spammers from Spamming the Checker
| Value is in Seconds. "40" = 20seconds
|
*/
$config['40'] =  $_ENV['ANTISPAM_TIMER'];

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
$config['sk_keys'] =  explode(",", $_ENV['SK_KEYS']);
?>
