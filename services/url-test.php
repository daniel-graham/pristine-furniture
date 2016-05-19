<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/17/2016
 * Time: 9:03 PM
 */

$page = "login.php";

//Build url from protocol, current domain, host, and directory
$loginServiceUrl = 'http://'. $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF']);
$loginServiceUrl = rtrim($loginServiceUrl, '/\\'); // remove trailing slashes from url

$pageUrl = $loginServiceUrl;

$pageUrl = rtrim($pageUrl, 'services'); // remove 'services' from url (go up a directory)
//    $pageUrl = rtrim($pageUrl, '/\\'); // remove trailing slashes from url

$pageUrl .= 'views/' .$page; //append /views/ to the url and the specified page argument

echo $pageUrl;

$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/home';
echo"<br>$home_url";