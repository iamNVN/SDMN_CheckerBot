<?php


include_once __DIR__."/../functions/bot.php";
include __DIR__."/../config/variables.php";
include __DIR__."/../config/config.php";

///////////==[DB Connection]==///////////
$conn = mysqli_connect($config['db']['hostname'],$config['db']['username'],$config['db']['password'],$config['db']['database']);

if(!$conn){
    bot('sendmessage',[
        'chat_id'=>$config['adminID'],
        'text'=>"<b>🛑 DB connection Failed!
        
        ".json_encode($config['db'])."</b>",
        'parse_mode'=>'html'
        
    ]);

    logsummary("<b>🛑 DB connection Failed!\n\n".json_encode($config['db'])."</b>");
}

////////////////////////////////////////////

function fetchUser($userID){
    global $conn;
    $dataf = mysqli_query($conn,"SELECT * FROM users WHERE userid='$userID'");

    if(mysqli_num_rows($dataf) == 0){
        return False;
    }

    $userData = $dataf->fetch_assoc();
    
    return $userData;

}

function isBanned($userID){
    global $chat_id;
    global $message_id;
    $userData = fetchUser($userID);

    if($userData['is_banned'] == "True"){
        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"<b>Hehe Boi! Suck your Mum</b>",
        'parse_mode'=>'html',
        'reply_to_message_id'=> $message_id
        ]);
        return True;
    }else{
        return False;
    }

}

function isMuted($userID){
    global $chat_id;
    global $message_id;
    global $conn;
    $userData = fetchUser($userID);

    if($userData['is_muted'] == "True"){
        $muted_for = $userData['mute_timer']-time();

        if($muted_for >= 0){
        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"<b>🛑You are Muted!
            
Try Again after <code>".date("F j, Y, g:i a",$userData['mute_timer'])."</code></b>",
        'parse_mode'=>'html',
        'reply_to_message_id'=> $message_id
        ]);
        return True;
        }else{
            mysqli_query($conn,"UPDATE users SET is_muted = 'False',mute_timer = '0' WHERE userid = '$userID'");
            return False;
        }
    }else{
        return False;
    }

}

function addUser($userID){
    global $conn;
    $userData = fetchUser($userID);

    if(!$userData){
        $addtodb = mysqli_query($conn,"INSERT INTO users (userid,registered_on,is_banned,is_muted,mute_timer,sk_key,total_checked,total_cvv,total_ccn) VALUES ('$userID','".time()."','False','False','0','0','0','0','0')");
        logsummary("<b>🛑 [LOG] New User - $userID</b>");
        return True;
    }else{
        return False;
    }

}

function muteUser($userID,$time){
    global $conn;
    $userData = fetchUser($userID);

    if(!$userData){
        return "Uhmm, This user isn't in my db!";
    }else{
        $muteuser = mysqli_query($conn,"UPDATE users SET is_muted = 'True',mute_timer = '$time' WHERE userid = '$userID'");
        logsummary("<b>🛑 [LOG] Muted $userID</b>");
        return "Successfully Muted <code>$userID</code> until <code>".date("F j, Y, g:i a",$time)."</code>";
    }

}

function unmuteUser($userID){
    global $conn;
    $userData = fetchUser($userID);

    if(!$userData){
        return "Uhmm, This user isn't in my db!";
    }else{
        $muteuser = mysqli_query($conn,"UPDATE users SET is_muted = 'False',mute_timer = '0' WHERE userid = '$userID'");
        logsummary("<b>🛑 [LOG] Unmuted $userID</b>");
        return "Successfully Unmuted $userID";
    }

}

function banUser($userID){
    global $conn;
    $userData = fetchUser($userID);

    if(!$userData){
        return "Uhmm, This user isn't in my db!";
    }else{
        $muteuser = mysqli_query($conn,"UPDATE users SET is_banned = 'True' WHERE userid = '$userID'");
        logsummary("<b>🛑 [LOG] Banned $userID</b>");
        return "Successfully Banned <code>$userID</code>";
    }

}

function unbanUser($userID){
    global $conn;
    $userData = fetchUser($userID);

    if(!$userData){
        return "Uhmm, This user isn't in my db!";
    }else{
        $muteuser = mysqli_query($conn,"UPDATE users SET is_banned = 'False' WHERE userid = '$userID'");
        
        logsummary("<b>🛑 [LOG] Unbanned $userID</b>");

        return "Successfully Unbanned <code>$userID</code>";

        
    }

}

function fetchMutelist(){
    global $conn;

    $data = mysqli_query($conn,"SELECT userid FROM users WHERE is_muted = 'True'");
    if(mysqli_num_rows($data) == 0){
        return False;
    }

    $data = $data->fetch_assoc();
    return $data;
}

function fetchMuteTimer($userID){
    global $conn;

    $data = mysqli_query($conn,"SELECT mute_timer FROM users WHERE userid = '$userID'");
    if(mysqli_num_rows($data) == 0){
        return False;
    }

    $data = $data->fetch_assoc();
    return $data;
}

function fetchBanlist(){
    global $conn;

    $data = mysqli_query($conn,"SELECT userid FROM users WHERE is_banned = 'True'");
    if(mysqli_num_rows($data) == 0){
        return False;
    }

    $data = $data->fetch_assoc();
    return $data;
}


function totalBanned(){
    global $conn;

    $data = mysqli_query($conn,"SELECT * FROM users WHERE (is_banned = 'True')");
    return mysqli_num_rows($data);

}

function totalMuted(){
    global $conn;

    $data = mysqli_query($conn,"SELECT * FROM users WHERE (is_muted = 'True')");
    return mysqli_num_rows($data);

}


///////===[ANTI-SPAM]===///////

function existsLastChecked($userID){
    global $conn;
    $dataf = mysqli_query($conn,"SELECT * FROM antispam WHERE userid='$userID'");

    if(mysqli_num_rows($dataf) == 0){
        return False;
    }

    $userData = $dataf->fetch_assoc();
    
    return $userData['last_checked_on'];

}

function antispamCheck($userID){
    global $conn;
    global $config;

    $antiSpamGey = existsLastChecked($userID);
    
    if($userID == $config['adminID']){
        return False;
    }
    if($antiSpamGey == False){
        $addtodb = mysqli_query($conn,"INSERT INTO antispam (userid,last_checked_on) VALUES ('$userID','".time()."')");
        return False;
    }else{
        if(time() - $antiSpamGey > $config['anti_spam_timer']){
            $addtodb = mysqli_query($conn,"UPDATE antispam set last_checked_on = '".time()."' WHERE userid = '$userID'");
            return False;
        }else{
            return $config['anti_spam_timer'] - (time() - $antiSpamGey);
        }
        
    }

}

///////===[CHECKER STATS]===///////

function fetchGlobalStats(){
    global $conn;
    $stats = mysqli_query($conn,"SELECT * FROM global_checker_stats");
    $stats = $stats->fetch_assoc();
    return $stats;

}

function addTotal(){
    global $conn;
    mysqli_query($conn,"UPDATE global_checker_stats SET total_checked = total_checked + 1");

}

function addCVV(){
    global $conn;
    mysqli_query($conn,"UPDATE global_checker_stats SET total_cvv = total_cvv + 1");

}

function addCCN(){
    global $conn;
    mysqli_query($conn,"UPDATE global_checker_stats SET total_ccn = total_ccn + 1");

}


function fetchUserStats($userID){
    global $conn;
    $stats = mysqli_query($conn,"SELECT total_checked,total_cvv,total_ccn FROM users WHERE userid = '$userID'");
    $stats = $stats->fetch_assoc();
    return $stats;

}

function addUserTotal($userID){
    global $conn;
    mysqli_query($conn,"UPDATE users SET total_checked = total_checked + 1 WHERE userid = '$userID'");

}

function addUserCVV($userID){
    global $conn;
    mysqli_query($conn,"UPDATE users SET total_cvv = total_cvv + 1 WHERE userid = '$userID'");

}

function addUserCCN($userID){
    global $conn;
    mysqli_query($conn,"UPDATE users SET total_ccn = total_ccn + 1 WHERE userid = '$userID'");

}

///////===[API KEY]===///////

function fetchAPIKey($userID){
    global $conn;
    $key = mysqli_query($conn,"SELECT sk_key FROM users WHERE userid = '$userID'");
    $key = $key->fetch_assoc();
    return $key['sk_key'];

}

function updateAPIKey($userID,$apikey){
    global $conn;
    mysqli_query($conn,"UPDATE users SET sk_key = '$apikey' WHERE userid = '$userID'");

}

?>