<?php

///////////===[Bot Functions]===///////////
function bot($method,$datas=[]){
    global $config;
    $url = "https://api.telegram.org/bot".$config['botToken']."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

function sendMessage($chat_id,$text,$keyboard){
	bot('sendMessage',[
	'chat_id'=>$chat_id,
	'text'=>$text,
	'reply_markup'=>$keyboard]);
}

function editMessage($chat_id,$message_id,$text,$reply_markup){
	bot('editMessageText',[
	'chat_id'=>$chat_id,
	'message_id'=>$message_id,
	'text'=>$text,
	'reply_markup'=>$reply_markup]);
}

function forwardMessage($chatid,$from_chat_id,$message_id){
	bot('forwardMessage',[
	'chat_id'=>$chatid,
	'from_chat_id'=>$from_chat_id,
	'message_id'=>$message_id]);
}

function copyMessage($chatid,$from_chat_id,$message_id){
	bot('copyMessage',[
	'chat_id'=>$chatid,
	'from_chat_id'=>$from_chat_id,
	'message_id'=>$message_id]);
}

function sendPhoto($chat_id,$photo,$keyboard){
	bot('sendPhoto',[
	'chat_id'=>$chat_id,
	'photo'=>$photo,
	'reply_markup'=>$keyboard]);
}

?>