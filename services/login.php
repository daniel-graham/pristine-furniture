<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/17/2016
 * Time: 2:33 PM
 *
 * Login-Service validates login attempts and loads a new login page whenever the
 * user needs to sign back in.
 */

//require_once('../config/dao.php'); // create database connection object
require_once ('sanitize.php');
require_once('../loader.php');

//$url = '../views/';
//
///**
// * Loads the appropriate page if user_id exists in Session otherwise
// * redirect to login page.
// * @param string $page default: views/login.php
// *
// */
//function load($page = 'login.php'){
//
//    global $url;
//
//    $url .= $page;
//
//    header('Location: ' . $url);
//
//    exit();
//
//}

/**
 * @param $dbc
 * @param string $account
 * @param string $pwd
 */
function validate($dbc, $account='',  $pwd=''){
    $errors = array();
    // Check that email is not empty
    if(empty($account)){
        $errors[] = 'Enter your email address or username.';
    }else{
        $a = sanitize($account);
    }

    // Check that password is not empty
    if(empty($pwd)){
        $errors[] = 'Enter your password.';
    }else{
        $p = sanitize($pwd);
    }

    // Check that email and password exists
    if(empty($errors)){
        $q1 = "SELECT user_id, first_name, last_name, user_name, email, user_group, date_joined
              FROM users
              WHERE email = '$a'
              AND pass = SHA1('$p')";
        $r1 = mysqli_query($dbc, $q1);

        $q2 = "SELECT user_id, first_name, last_name, user_name, email, user_group, date_joined
              FROM users
              WHERE user_name = '$a'
              AND pass = SHA1('$p')";
        $r2 = mysqli_query($dbc, $q2);

        if(mysqli_num_rows($r1) == 1){
            $row = mysqli_fetch_array($r1, MYSQLI_ASSOC);
            return array(true, $row); // email found: return true and row with the user's information
        }
        elseif(mysqli_num_rows($r2) == 1){
            $row = mysqli_fetch_array($r2, MYSQLI_ASSOC);
            return array(true, $row); // username found: return true and row with the user's information
        }
        else{
            if (strpos($a, '@') !== false) {
                $errors[] = "That email address and password combination was not found. | <a href='views/register.php' class='text-info'>Create Account</a>";
            }else{
                $errors[] = "That username and password combination was not found. | <a href='views/register.php' class='text-info'>Create Account</a>";
            }
        }

    }
    return array(false, $errors); // validation failed return error messages to the caller


}
//echo "<h3>$url</h3>";
