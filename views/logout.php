<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/18/2016
 * Time: 3:20 PM
 */

require('../session.php');
$pageTitle = "Logout";
$section = "logout";

include('../inc/header.php');

global $firstName;

$userFirstName = $firstName;

$_SESSION = array(); // clear any existing session variables

session_destroy(); // end the session

?>
<script>
    // Display a success toast, with a title
    toastr.options.showEasing = 'swing';
    toastr.options.positionClass = 'toast-top-right';
    toastr.warning('Logging you out...Toodles!', {timeOut: 5000}, {closeButton: true});
</script>
<div class='alert text-center'>
            <h3 class='text-warning'>
                Goodbye <?php echo $userFirstName ?>!
            </h3>
           <div class="">
               <div class="alert alert-info">
                   <div class="row"><h4 class="">You have been logged out...</h4></div>
                   <h5 class="row">
                       <h4 class="">
                           <a class="" href="views/login.php">Login
                               <i class='fa fa-sign-in' aria-hidden='true'></i>
                           </a>
                       </h4>
                       <h4 class=""><a class="" href="index.php">Home
                               <i class='fa fa-home' aria-hidden='true'></i>
                           </a>
                       </h4>
                   </div>
               </div>
           </div>
<!--           --><?php //echo'<meta http-equiv="refresh" content="5;url=index.php">'; //redirect to home page ?>
</div>

<?php include('../inc/footer.php'); ?>