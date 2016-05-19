<?php

//require('../session.php');
$pageTitle = "Login";
$section = "login";

function redirect($DoDie = true) {
    header('Location: profile.php');
    if ($DoDie)
        die();
}
session_start();

// Redirect to profile if already logged in
if(isset($_SESSION['user_id'])) {
    redirect();
}

include('../inc/header.php');


if(isset($_GET["status"]) AND $_GET["status"] == "sessionnotfound"){
    echo "<div class='alert text-center'>
                <h3 class='text-warning'><i class='fa fa-shield fa-3' aria-hidden='true'></i> Access to This Area is Restricted</h3>
                <h4>Please try logging in!</h4>
          </div>";

    echo "<script>
                // Display a success toast, with a title
                toastr.options.showEasing = 'swing';
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.warning('Oops, sorry you must login first...', {timeOut: 5000}, {closeButton: true});
           </script>";

}

if(isset($errors) && !empty($errors)){
    echo "<div class='alert alert-warning text-center'>
                  <h3>Oops! Looks like we have problems:</h3><br>
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
               <h4>Please try again</h4>
          </div>";
}
?>

<div class="container">
    <div class="auth-forms title">
        <br>
        <div id="errorAlert" class="bs-callout bs-callout-warning alert alert-warning hidden">
            <h4>Oh snap!</h4>
            <p>Please Login :(</p>
        </div>

        <div id="doneAlert" class="bs-callout bs-callout-info alert alert-success hidden">
            <h4>Yay!</h4>
            <p>OK, let's try that :)</p>
        </div>
        <br>
        <h2>Login</h2>
        <form id="login" method="post" action="services/auth.php" data-parsley-validate="" data-ajax="false" onsubmit="return validateLogin();">
            <!-- Email Input -->
            <div class="input-group" aria-describedby="email-username-input">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                </div>
                <input type="text" id="email-username-input" name="account" placeholder="Username or Email" class="form-control"
                       aria-label="Username or Email Input" data-parsley-length="[4, 60]"required>
            </div>
            <br>
            <!-- Password Input -->
            <div class="input-group">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                </div>
                <input type="password"  id="passwordInput" name="pass" placeholder="Password" class="form-control"
                       aria-label="Username or Email Input" data-parsley-length="[4,40]" data-parsley-type="alphanum" required>
            </div>
            <br>
            <input type="submit" name="submit_form" value="Login" class="btn btn-info">
        </form>
    </div>
</div>
<?php include('../inc/footer.php') ?>

