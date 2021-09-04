<?php

include __DIR__."/../config/config.php";
include_once __DIR__."/../functions/bot.php";

function capture($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, $str[1]);
  return $str[0];
}

function logsummary($summary){
    global $config;
    bot('sendmessage',[
        'chat_id'=>$config['logsID'],
        'text'=>$summary,
        'parse_mode'=>'html'
        
    ]);
}

function add_days($timestamp,$days){
    $future = $timestamp + (60*60*24*str_replace('d','',$days));
    return $future;
}

function add_minutes($timestamp,$minutes){
    $future = $timestamp + (60*str_replace('m','',$minutes));
    return $future;
}

function multiexplode($delimiters, $string){
    $one = str_replace($delimiters, $delimiters[0], $string);
    $two = explode($delimiters[0], $one);
    return $two;
}

function array_in_string($str, array $arr) {
    foreach($arr as $arr_value) { 
        if (stripos($str,$arr_value) !== false) return true; 
    }
    return false;
}
?>