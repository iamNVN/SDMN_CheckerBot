<?php

/*

///==[IBAN Checker Commands]==///

/iban de123 - Checks the IBAN

*/


include __DIR__."/../config/config.php";
include __DIR__."/../config/variables.php";
include_once __DIR__."/../functions/bot.php";
include_once __DIR__."/../functions/db.php";
include_once __DIR__."/../functions/functions.php";


////////////====[MUTE]====////////////
if(strpos($message, "/iban ") === 0){   
    $antispam = antispamCheck($userId);
    addUser($userId);
    
    if($antispam != False){
      bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"[<u>ANTI SPAM</u>] Try again after <b>$antispam</b>s.",
        'parse_mode'=>'html',
        'reply_to_message_id'=> $message_id,
      ]);
      return;

    }else{
        $messageidtoedit1 = bot('sendmessage',[
          'chat_id'=>$chat_id,
          'text'=>"<b>Wait for Result...</b>",
          'parse_mode'=>'html',
          'reply_to_message_id'=> $message_id,

        ]);

        $messageidtoedit = capture(json_encode($messageidtoedit1), '"message_id":', ',');
        $ibanx = substr($message, 6);
        $iban = preg_replace("/\s+/", "", $ibanx);
        
        if(preg_match_all("/^([A-Z]{2}[ '+'\\'+'-]?[0-9]{2})(?=(?:[ '+'\\'+'-]?[A-Z0-9]){9,30}$)((?:[ '+'\\'+'-]?[A-Z0-9]{3,5}){2,7})([ '+'\\'+'-]?[A-Z0-9]{1,3})?$/", $iban, $matches)) {
            $iban = $matches[0][0];
            $startTime = microtime(true); 
        

            ###CHECKER PART###  
            $result2 = file_get_contents('https://openiban.com/validate/'.$iban.'?getBIC=true&validateBankCode=true');
            $bankcode1 = capture($result2, '"bankCode": "', '"');
            $bankname = capture($result2, '"name": "', '"');
            $zip = capture($result2, '"zip": "', '"');
            $city = capture($result2, '"city": "', '"');
            $bic = capture($result2, '"bic": "', '"');

            $timetakeen = (microtime(true) - $startTime);
            $timetaken = substr_replace($timetakeen, '',4);

            ###END OF CHECKER PART###
            
            
            if(strpos($result2, 'valid": true')){
              bot('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$messageidtoedit,
                'text'=>"IBAN -LIVE ✅ <code>$iban</code> - [ RESPONSE: <b>This is a valid IBAN.</b> ]
<ins>BIC:</ins>  <code>$bic</code>
<ins>Bank Code:</ins>  <code>$bankcode1</code>
<ins>Bank:</ins>  <b>$bankname</b>
<ins>City:</ins>  <b>$city</b>
<ins>Time:</ins>  <code>$timetaken</code><code>s</code>
<b>━━━━━━━━━━━━━
Checked By <a href='tg://user?id=$userId'>$firstname</a></b>
<b>Bot By: <a href='t.me/iamNVN'>ɴɪɴᴊᴀ ɴᴀᴠᴇᴇɴ</a></b>",
                'parse_mode'=>'html',
                'disable_web_page_preview'=>'true'
                
            ]);}
            else{
              bot('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$messageidtoedit,
                'text'=>"IBAN -DEAD ❌ <code>$iban</code> - [ RESPONSE: <b>This is a Invalid IBAN.</b> ]
<ins>Time:</ins>  <code>$timetaken</code><code>s</code>
<b>━━━━━━━━━━</b>

<b>Checked By <a href='tg://user?id=$userId'>$firstname</a></b>
<b>Bot By: <a href='t.me/ninjanaveen'>ɴɪɴᴊᴀ ɴᴀᴠᴇᴇɴ</a></b>",
                'parse_mode'=>'html',
                'disable_web_page_preview'=>'true'
                
            ]);}
          
        }else{
          bot('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$messageidtoedit,
            'text'=>"<b>Never Gonna Give you Up!

Provide a Valid SK KEYYYY!</b>",
            'parse_mode'=>'html',
            'disable_web_page_preview'=>'true'
            
        ]);

        }
    }
}


?>
