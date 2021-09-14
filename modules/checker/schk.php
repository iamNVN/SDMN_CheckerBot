<?php

/*

///==[Stripe User Merchant Commands]==///

/schk creditcard - Checks the Credit Card

*/


include __DIR__."/../config/config.php";
include __DIR__."/../config/variables.php";
include_once __DIR__."/../functions/bot.php";
include_once __DIR__."/../functions/db.php";
include_once __DIR__."/../functions/functions.php";


////////////====[MUTE]====////////////
if(strpos($message, "/schk ") === 0 || strpos($message, "!schk ") === 0){   
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
        $messageidtoedit1 = bot('sendmessage',[
          'chat_id'=>$chat_id,
          'text'=>"<b>Wait for Result...</b>",
          'parse_mode'=>'html',
          'reply_to_message_id'=> $message_id

        ]);

        $messageidtoedit = capture(json_encode($messageidtoedit1), '"message_id":', ',');
        $lista = substr($message, 6);
        $bin = substr($cc, 0, 6);
        
        if(preg_match_all("/(\d{16})[\/\s:|]*?(\d\d)[\/\s|]*?(\d{2,4})[\/\s|-]*?(\d{3})/", $lista, $matches)) {
            $creditcard = $matches[0][0];
            $cc = multiexplode(array(":", "|", "/", " "), $creditcard)[0];
            $mon = multiexplode(array(":", "|", "/", " "), $creditcard)[1];
            $year = multiexplode(array(":", "|", "/", " "), $creditcard)[2];
            $cvv = multiexplode(array(":", "|", "/", " "), $creditcard)[3];
            $sec = fetchAPIKey($userId);
            
            if(!preg_match_all("/sk_(test|live)_[A-Za-z0-9]+/", $sec, $matches)) {
                bot('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$messageidtoedit,
                    'text'=>"<b>Add a SK Key First by using /apikey sk_live</b>",
                    'parse_mode'=>'html',
                    'disable_web_page_preview'=>'true'
                    
                ]);
                return;
            }
        

            ###CHECKER PART###  
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$cc.'');
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Host: lookup.binlist.net',
            'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, '');
            $fim = curl_exec($ch);
            $bank = capture($fim, '"bank":{"name":"', '"');
            $cname = capture($fim, '"name":"', '"');
            $brand = capture($fim, '"brand":"', '"');
            $country = capture($fim, '"country":{"name":"', '"');
            $phone = capture($fim, '"phone":"', '"');
            $scheme = capture($fim, '"scheme":"', '"');
            $type = capture($fim, '"type":"', '"');
            $emoji = capture($fim, '"emoji":"', '"');
            $currency = capture($fim, '"currency":"', '"');
            $binlenth = strlen($bin);
            $schemename = ucfirst("$scheme");
            $typename = ucfirst("$type");
            
            
            /////////////////////==========[Unavailable if empty]==========////////////////
            
            
            if (empty($schemename)) {
            	$schemename = "Unavailable";
            }
            if (empty($typename)) {
            	$typename = "Unavailable";
            }
            if (empty($brand)) {
            	$brand = "Unavailable";
            }
            if (empty($bank)) {
            	$bank = "Unavailable";
            }
            if (empty($cname)) {
            	$cname = "Unavailable";
            }
            if (empty($phone)) {
            	$phone = "Unavailable";
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/sources');
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERPWD, $sec. ':' . '');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type: application/x-www-form-urlencoded',));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&owner[name]=Aju Bose&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mon.'&card[exp_year]='.$year);
            $result = curl_exec($ch);

            if(strpos($result, 'error')){
                $stripemessage = capture($result,'"code": "','"');
                bot('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$messageidtoedit,
                    'text'=>"<b>Card:</b> <code>$lista</code>
<b>Status -» Dead ❌
Response -» <code>SK Key is Dead</code>
Gateway -» User Stripe Merchant
Time -» <b>$time</b><b>s</b>

------- Bin Info -------</b>
<b>Bank -»</b> $bank
<b>Brand -»</b> $schemename
<b>Type -»</b> $typename
<b>Currency -»</b> $currency
<b>Country -»</b> $cname ($emoji - 💲$currency)
<b>Issuers Contact -»</b> $phone
<b>----------------------------</b>

<b>Checked By <a href='tg://user?id=$userId'>$firstname</a></b>
<b>Bot By: <a href='t.me/ninjanaveen'>ɴɪɴᴊᴀ ɴᴀᴠᴇᴇɴ</a></b>",
                    'parse_mode'=>'html',
                    'disable_web_page_preview'=>'true'
                    
                ]);
                return;

            }
            
            $id = capture($result,'"id": "','"');
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERPWD, $sec. ':' . '');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type: application/x-www-form-urlencoded',));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'description=Aju Bose&source='.$id);
            $result1 = curl_exec($ch);
            $info = curl_getinfo($ch);
            $time = $info['total_time'];
            $time = substr_replace($time, '',4);
            
            ###END OF CHECKER PART###
            if (array_in_string($result1, $live_array)) {
                $stripemessage = trim(strip_tags(capture($result1,'"message": "','"')));
                $live = True;
            }else{
                $stripemessage = capture($result1,'"decline_code": "','"');
                if(empty($stripemessage)){
                    $stripemessage = $result;
                }
                $live = False;
            }
            
            if($live) {
              addTotal();
              addUserTotal($userId);
              addCCN();
              addUserCCN($userId);
              addCVV();
              addUserCVV($userId);
              bot('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$messageidtoedit,
                'text'=>"<b>Card:</b> <code>$lista</code>
<b>Status -» Approved ✅
Response -» $stripemessage
Gateway -» User Stripe Merchant
Time -» <b>$time</b><b>s</b>

------- Bin Info -------</b>
<b>Bank -»</b> $bank
<b>Brand -»</b> $schemename
<b>Type -»</b> $typename
<b>Currency -»</b> $currency
<b>Country -»</b> $cname ($emoji - 💲$currency)
<b>Issuers Contact -»</b> $phone
<b>----------------------------</b>

<b>Checked By <a href='tg://user?id=$userId'>$firstname</a></b>
<b>Bot By: <a href='t.me/ninjanaveen'>ɴɪɴᴊᴀ ɴᴀᴠᴇᴇɴ</a></b>",
                'parse_mode'=>'html',
                'disable_web_page_preview'=>'true'
                
            ]);}

            else{
              addTotal();
              addUserTotal($userId);

              bot('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$messageidtoedit,
                'text'=>"<b>Card:</b> <code>$lista</code>
<b>Status -» Dead ❌
Response -» <code>$stripemessage</code>
Gateway -» User Stripe Merchant
Time -» <b>$time</b><b>s</b>

------- Bin Info -------</b>
<b>Bank -»</b> $bank
<b>Brand -»</b> $schemename
<b>Type -»</b> $typename
<b>Currency -»</b> $currency
<b>Country -»</b> $cname ($emoji - 💲$currency)
<b>Issuers Contact -»</b> $phone
<b>----------------------------</b>

<b>Checked By <a href='tg://user?id=$userId'>$firstname</a></b>
<b>Bot By: <a href='t.me/ninjanaveen'>ɴɪɴᴊᴀ ɴᴀᴠᴇᴇɴ</a></b>",
                'parse_mode'=>'html',
                'disable_web_page_preview'=>'true'
                
            ]);}
          
        }else{
            bot('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$messageidtoedit,
                'text'=>"<b>Cool! Fucking provide a CC to Check!!</b>",
                'parse_mode'=>'html',
                'disable_web_page_preview'=>'true'
                
            ]);
        }
    }
}


?>
