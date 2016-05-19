<?php

$pageTitle = "Create an account";
$section = "register";
include('../inc/header.php');

// Read form submission on post
if($_SERVER["REQUEST_METHOD"] == "POST" ) {

    if (isset($_POST['submit_form'])) {
        require('../config/dao.php'); // create database connection object
        require('../config/mail.php'); // mailer settings
        require('../services/sanitize.php'); // cleanup input
        require('../services/email.php'); //sending emails

        $errors = array();

        $fName = "";
        $lName = "";
        $userName = "";
        $email = "";
        $password = "";

        function validate()
        {

            global $fName, $lName, $userName, $email, $password, $errors;

            if (empty($_POST["first_name"])) {
                $errors[] = "Enter your first name.";
            } else {
                $fName = sanitize($_POST["first_name"]);
            }
            if (empty($_POST["last_name"])) {
                $errors[] = "Enter your last name.";

            } else {
                $lName = sanitize($_POST["last_name"]);
            }
            if (empty($_POST["user_name"])) {
                $errors[] = "Enter your username.";
            } else {
                $userName = sanitize($_POST["user_name"]);
            }
            if (empty($_POST["email"])) {
                $errors[] = "Enter your email address.";
            } else {
                $email = sanitize($_POST["email"]);
            }
            if (!empty($_POST["pass1"])) {
                if ($_POST["pass1"] != $_POST["pass2"]) {
                    $errors[] = "Passwords do not match.";
                } else {
                    $password = sanitize($_POST["pass1"]);
                }
            } else {
                $errors[] = "Enter your password.";
            }

        }


        function isValid()
        {
            global $fName, $lName, $userName, $email, $password, $errors, $dbc, $settings;
            validate();

            // Check if email or username already exists
            if (empty($errors)) {
                $q1 = "SELECT user_id FROM users WHERE email ='$email'";
                $q2 = "SELECT user_id FROM users WHERE user_name ='$userName'";
                $r1 = mysqli_query($dbc, $q1);
                $r2 = mysqli_query($dbc, $q2);
                if (mysqli_num_rows($r1) != 0) {
                    $errors[] = 'Email address is already registered. <a class="text-info" href="views/login.php">Login</a> or try another email.';
                }
                if (mysqli_num_rows($r2) != 0) {
                    $errors[] = 'Username is already registered. <a class="text-info" href="views/login.php">Login</a> or try another username.';
                }
            }
            if (empty($errors)) {
                $qCreateUser = "INSERT INTO users(first_name, last_name, user_name, email, pass, date_joined, status, user_group, user_lang )
                       VALUES('$fName','$lName', '$userName', '$email', SHA1('$password'), NOW(), 'basic', 'merchant', 'English')";
                $r = mysqli_query($dbc, $qCreateUser);

                if ($r) {

                    //TODO: Send Email
//                    list($check, $data) = sendRegistrationEmail($fName, $lName, $email, $settings);
//
//                    if ($check) {
//                        echo "<div class='alert alert-success text-center'>
//                            <h3>$data</h3>
//                          </div>";
//
//                    }else{
//                        echo"<div class='well text-center'>";
//
//                        foreach ($data as $error) {
//                            echo "<h5>- $error<br></h5>";
//                        }
//                        echo"</div>";
//                    }
                    echo "<div class='alert alert-success text-center'>
                            <h3>Registration Successful</h3>
                            <p>this page will redirect shortly...<br></p>
                      </div>";

                    echo'<meta id="redirect" http-equiv="refresh" content="5;url=views/login.php">'; //redirect to login page

                    echo "<script>
                            // Display a success toast, with a title
                            toastr.options.showEasing = 'swing';
                            toastr.options.positionClass = 'toast-bottom-right';
                            toastr.success('Great, registration successful!', {timeOut: 5000}, {closeButton: true});
                          </script>";
                }
                mysqli_close($dbc);
                include('../inc/footer.php');
                exit();
            } else {
                echo "<div class='alert alert-warning text-center'>
                            <h3>Registration not successful.</h3>
                            <p>The following error(s) occurred: <br></p>
                      </div>";
                ?>
                <div class='well text-center'>
                    <?php
                    foreach ($errors as $msg) {
                        echo "<h5>- $msg<br></h5>";
                    }?>
                </div>
                <?php
                echo "<div class='alert text-center'>
                            <h4>Please try again.</h4>
                          </div>";
                mysqli_close($dbc);

                echo "<script>
                            // Display a danger toast, with a title
                            toastr.options.showEasing = 'swing';
                            toastr.options.positionClass = 'toast-bottom-right';
                            toastr.error('There was an error.', {timeOut: 5000}, {closeButton: true});
                      </script>";

            }

        }

        isValid();


    }
}

?>

<div class="container">
    <div class="auth-forms title">
        <br>
        <div id="errorAlert" class="bs-callout bs-callout-warning alert alert-warning hidden">
            <h4>Oh snap!</h4>
            <p>This form seems to be invalid :(</p>
        </div>

        <div id="doneAlert" class="bs-callout bs-callout-info alert alert-success hidden">
            <h4>Yay!</h4>
            <p>Everything seems to be ok :)</p>
        </div>
        <br>
        <h2>Create a New Account</h2>
        <br>
        <form id="postItem" method="post" action="views/register.php" data-parsley-validate="" onsubmit="return validate();">
            <!-- Name Input -->
            <div class="input-group" aria-describedby="firstName lastName">
                <!-- Prepend Glyphicon to Form-Control Input -->
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                </div>
                <input type="text" id="firstName" class="form-control" name="first_name" placeholder="First Name"
                       aria-label="Enter your first name" data-parsley-length="[4, 20]" required>

                <input type="text" id="lastName" class="form-control" name="last_name" placeholder="Last Name"
                       aria-label="Enter your last name" data-parsley-length="[4, 20]" required>
            </div>
            <br>
            <!-- Username Input -->
            <div class="input-group" aria-describedby="userName">
                <!-- Prepend Glyphicon to Form-Control Input -->
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                </div>
                <input type="text" id="userName" type="text" class="form-control" name="user_name" placeholder="Username" aria-label="Username Input" data-parsley-length="[6, 30]"required>
            </div>
            <br>
            <!-- Email Input -->
            <div class="input-group" aria-describedby="email">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                </div>
                <input type="email" id="email" name="email" placeholder="Email" class="form-control" aria-label="Email Input" data-parsley-length="[4, 60]" required>
            </div>
            <br>
            <!-- Password Inputs -->
            <div class="input-group" aria-describedby="password confirmPassword">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                </div>
                <input type="password" id="password" name="pass1" placeholder="Password" class="form-control" aria-label="Password Input" data-parsley-length="[4, 40]" data-parsley-type="alphanum" required>
                <input type="password" id="confirmPassword" name="pass2" placeholder="Confirm Password" class="form-control" aria-label="Confirm Password" data-parsley-length="[4, 40]" data-parsley-type="alphanum" data-parsley-equalto="#password"required>
            </div>
            <br>
            <input type="submit" name="submit_form" value="Register" class="btn btn-danger">
        </form>
    </div>
</div>