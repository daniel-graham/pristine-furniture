<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/29/2016
 * Time: 4:06 PM
 */

require('../session.php');
require('../services/sanitize.php');
$pageTitle = "Checkout";
$section = "checkout";

include('../inc/header.php');

/**
 * Stores items in database and initiate the checkout process if total is > 0 and the cart isn't empty.
 */
if(isset($_GET['total']) && ($_GET['total'] > 0) && (!empty($_SESSION['cart']))) {
    require_once('../config/dao.php');

    $values = array($_SESSION['user_id'], $_GET['total']);
    $q1 = "INSERT INTO orders (user_id, total, order_date) VALUES (?, ?, NOW())";


    $stm = $pdo->prepare($q1);
    $stm->execute($values);
//    $data = $stm->fetchAll();

    $order_id = $pdo->lastInsertId(); // get id of the current order

    // retrieve the selected cart item details
    $in = "";
    foreach($_SESSION['cart'] as $id => $value){
        $in .= $id. ',';
    }
    $in = substr($in, 0, -1);
    $q2 = "SELECT * FROM shop WHERE item_id IN ($in) ORDER BY item_id ASC";

    $stm = $pdo->prepare($q2);
    $stm->execute();
    $data = $stm->fetchAll();

    foreach($data as $item){
        $q3 = "INSERT INTO order_contents (order_id, item_id, quantity, price)
               VALUES (?, ?, ?, ?)";

        $q4 = "UPDATE shop SET item_quantity = item_quantity -1
               WHERE item_id = {$item['item_id']}";

        $stm = $pdo->prepare($q3);
        $stm->execute(array($order_id, $item['item_id'],
                            $_SESSION['cart'][$item['item_id']]['quantity'],
                            $_SESSION['cart'][$item['item_id']]['price']));

        // update item quantity
        $stm = $pdo->prepare($q4);
        $stm->execute();
    } ?>
<!-- Order Confirmation Message -->
<div class='alert alert-success text-center'>
    <h3>Thanks For Your Order!</h3>
    <br>
    <div class='row'>
        <div class='col-md-4 col-lg-offset-4'>
            <h4 class='text-info'>
                <a href='views/profile.php'>Your Order Number Is #<?php echo $order_id; ?> <i class='fa fa-wpforms' aria-hidden='true'></i></a>
            </h4>
            <div class="checkmark">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 161.2 161.2" enable-background="new 0 0 161.2 161.2" xml:space="preserve">
                    <path class="path" fill="none" stroke="#5CCC29" stroke-miterlimit="10" d="M425.9,52.1L425.9,52.1c-2.2-2.6-6-2.6-8.3-0.1l-42.7,46.2l-14.3-16.4
	                    c-2.3-2.7-6.2-2.7-8.6-0.1c-1.9,2.1-2,5.6-0.1,7.7l17.6,20.3c0.2,0.3,0.4,0.6,0.6,0.9c1.8,2,4.4,2.5,6.6,1.4c0.7-0.3,1.4-0.8,2-1.5
	                    c0.3-0.3,0.5-0.6,0.7-0.9l46.3-50.1C427.7,57.5,427.7,54.2,425.9,52.1z"/>
                    <circle class="path" fill="none" stroke="#5CCC29" stroke-width="4" stroke-miterlimit="10" cx="80.6" cy="80.6" r="62.1"/>
                    <polyline class="path" fill="none" stroke="#5CCC29" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="113,52.8
	                74.1,108.4 48.2,86.4 "/>

                    <circle class="spin" fill="none" stroke="#a1cc2a" stroke-width="4" stroke-miterlimit="10" stroke-dasharray="12.2175,12.2175" cx="80.6" cy="80.6" r="73.9"/>

                </svg>
            </div>
        </div>
    </div>
</div>

<?php

    $_SESSION['cart'] = NULL; //empty the cart
}
elseif(isset($_GET['proceed']) && $_GET['proceed'] == 'true'){ ?>
    <meta http-equiv="refresh" content="3;url=views/cart.php">'; <!-- redirect to cart page -->
    <div class='alert text-center'>
        <h3>Redirecting to Cart Where You Can Verify and Complete Your Order</h3>
        <p>the page will redirect shortly...</p>
    </div>";
<?php }
else{
    echo "<div class='alert alert-info text-center'>
                  <h3>There are no items in your cart.</h3><br>
                  <div class='row'>
                    <div class='col-md-4 col-lg-offset-4'>
                          <h4 class='text-info'>
                          <a href='views/shop.php'><i class='fa fa-shopping-basket' aria-hidden='true'></i> Continue Shopping</a>
                          </h4>
                     </div>
                  </div>
           </div>";

}

