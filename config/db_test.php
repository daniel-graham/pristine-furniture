<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/9/2016
 * Time: 12:52 PM
 */

#Require MySQL db connection script
require('dao.php');

#Display MySQL version and host.
if(mysqli_ping($dbc)){ ?>

    <div class="container">
        <div class="alert-success" style="align-content: center; margin: auto; width: 60%; border: 3px solid #73AD21;
         padding: 10px;">
            <h2 style="align-content: center; color: #0F9D58; text-align: center">Connection to Database Successful </h2>
            <p style="text-align: center">
                <?php echo 'MySQL Server ' . mysqli_get_server_info($dbc).
                    ' on '. mysqli_get_host_info($dbc);
                ?>
            </p>
        </div>
    </div>
<?php }
$userId = 1;
$q1 = "SELECT user_group from users where user_id = $userId";
$stm = $pdo->prepare($q1);
$stm->execute();
$data = $stm->fetch();


echo "<br>". $data['user_group'];
exit; ?>

