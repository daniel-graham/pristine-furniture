<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/22/2016
 * Time: 1:26 PM
 */

$baseUrl = '../views/';

/**
 * Loads the requested page from $page parameter
 * or redirect to login page.
 * @param string $page default: views/login.php
 *
 */
function load($page = 'login.php'){

    global $baseUrl;

    $baseUrl .= $page;

    header('Location: ' . $baseUrl);

    exit();

}