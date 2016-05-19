<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/9/2016
 * Time: 12:52 PM
 */

#Require MySQL db connection script
require('mail.php');

#Display MySQL version and host.
if(isset($settings)){ ?>

    <div class="container">
        <div class="alert-success" style="align-content: center; margin: auto; width: 60%; border: 3px solid #73AD21;
         padding: 10px;">
            <h2 style="align-content: center; color: #0F9D58; text-align: center">Mail Settings </h2>
            <p style="text-align: center">
                <?php
                    foreach($settings as $s){
                    echo $s.'<br>';
                }
                ?>
            </p>
        </div>
    </div>
<?php } exit; ?>

