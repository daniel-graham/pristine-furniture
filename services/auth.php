<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/17/2016
 * Time: 3:23 PM
 *
 * AuthService processes login attempts and creates a new session for the user.
 * AuthService retrieves the user's info and sets it as session data.
 */

//session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if (isset($_POST['submit_form'])) {
        require('../config/dao.php'); // database connection object
        require('login.php'); // login service

        list($check, $data) = validate($dbc, $_POST['account'], $_POST['pass']);

        if ($check) {
            session_start();

            $_SESSION['user_id'] = $data['user_id'];
            $_SESSION['first_name'] = $data['first_name'];
            $_SESSION['last_name'] = $data['last_name'];
            $_SESSION['user_name'] = $data['user_name'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['status'] = $data['status'];
            $_SESSION['user_group'] = $data['user_group'];
            $_SESSION['date_joined'] = $data['date_joined'];

            load('profile.php');
        } else {
            $errors = $data;
        }
    }

    mysqli_close($dbc);
}
include('../views/login.php');

