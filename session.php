<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/18/2016
 * Time: 12:10 PM
 *
 * Session.php creates and checks for valid sessions.
 *
 * If a valid session has not been created or started then session.php
 * redirects the user to the login page for authentication.
 *
 * when a new session is started, session.php creates a new session variable
 * $_SESSION['user_id'] where it stores the id of the currently signed in user
 * and sets a new $userIdCheck variable to the id of the currently signed in user.
 * If the user_id session variable is not set, then the user is redirected to the
 * login page (views/login.php?status=sessionnotfound).
 *
 * Otherwise session.php creates and sets the variables $userId, $firstName, $lastName, $userName, $email,
 * $dateJoined, and $ipAddress with the appropriate values.
 */

require('config/dao.php');

$time = time ();
$limit = 60;
$setTime = time () + $limit;
if (empty ( $_SESSION ['setTime'] ) || !isset ( $_SESSION ['setTime'] )) {
    $_SESSION ['setTime'] = $setTime;
}

// Close session if inactive for more than $limit minutes.
if (time () >= ( int ) $_SESSION ['setTime']) {
    session_unset ();
    session_destroy ();
}

session_start();

$userIdCheck = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$userGroupCheck = isset($_SESSION['user_group']) ? $_SESSION['user_group'] : NULL;

if(!isset($userIdCheck)){
    require('services/login.php');
    load('login.php?status=sessionnotfound');
}else{
    $userId = $userIdCheck;
    $firstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : "" ;
    $lastName = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : "" ;
    $userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "" ;
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : "" ;

    $date = DateTime::createFromFormat('Y-m-d H:i:s', isset($_SESSION['date_joined']) ? $_SESSION['date_joined'] : "" );

    if(isset($date) && !empty($date)){
        $dateJoined = $date->format('m-d-Y'); // Change format as needed
    }else{
        $dateJoined = "N/A";
    }
    $ipAddress = getIp();
}

function isLoggedIn(){
    global $userIdCheck;

    if(isset($userIdCheck)){
        $GLOBALS["signedIn"] = true;
        return true;
    }else{
        $GLOBALS["signedIn"] = false;
        return false;
    }
}
function isAdministrator($pdo){
    global $userId, $userGroupCheck;

    if(isLoggedIn() && isset($userGroupCheck)){

        $q1 = "SELECT user_group from users where user_id = $userId";
        $stm = $pdo->prepare($q1);
        $stm->execute();
        $data = $stm->fetch();

        if($data['user_group'] == "admin"){
            $GLOBALS["admin"] = true;
            return true;
        }else{
            $GLOBALS["admin"] = false;
            return false;
        }

    }else{
        $GLOBALS["admin"] = false;
        return false;
    }
}

function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}

isLoggedIn();
