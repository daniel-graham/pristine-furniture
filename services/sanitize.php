<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/17/2016
 * Time: 2:27 PM
 */

require_once('../config/dao.php'); // database connection object

function sanitize($data)
{
    global $dbc;

    $data = trim($data);
    $data = stripslashes($data);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($dbc, $data);
    return $data;
}
