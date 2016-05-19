<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/27/2016
 * Time: 3:16 PM
 */

require('../session.php');
require('../services/shop.php');
$pageTitle = "Cart Addition";
$section = "addToCart";

include('../inc/header.php');

if(isset($_GET['id']))
    $id = $_GET['id'];

list($check, $data) = getItem($dbc, $id); // fetch item with requested id from database.
$item = $data;


if ($check) {
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++; // increase product quantity by 1
        echo "<div class='alert alert-success text-center'>
                  <h3>Another " . "<span class='text-active'>&#34" . $item['item_name'] . "&#34</span>" . " has been added to your cart</h3>
                  <br>
                  <div class='row'>
                      <div class='col-md-4'>
                          <h4 class='text-info'>
                            <a href='views/cart.php'><i class='fa fa-shopping-cart' aria-hidden='true'></i> Cart</a>
                          </h4>
                      </div>
                      <div class='col-md-4'>
                          <h4 class='text-info'>
                          <a href='views/shop.php'><i class='fa fa-shopping-basket' aria-hidden='true'></i> Continue Shopping</a>
                          </h4>
                      </div>
                      <div class='col-md-4'>
                          <h4 class='text-info'>
                          <a href='views/checkout.php?proceed=true'><i class='fa fa-credit-card' aria-hidden='true'></i> Proceed to Checkout</a>
                      </h4>
                      </div>
                  </div>
           </div>";


    } else {
        $_SESSION['cart'][$id] = array('quantity' => 1, 'price' => $item['item_price']);
        echo "<div class='alert alert-success text-center'>
                  <h3>" . "<span class='text-active'>&#34" . $item['item_name'] . "&#34</span>" . " has been added to your cart.</h3><br>
                  <div class='row'>
                    <div class='col-md-4'>
                          <h4 class='text-info'>
                            <a href='views/cart.php'><i class='fa fa-shopping-cart' aria-hidden='true'></i> Cart</a>
                          </h4>
                      </div>
                      <div class='col-md-4'>
                          <h4 class='text-info'>
                          <a href='views/shop.php'><i class='fa fa-shopping-basket' aria-hidden='true'></i> Continue Shopping</a>
                          </h4>
                      </div>
                      <div class='col-md-4'>
                          <h4 class='text-info'>
                          <a href='views/checkout.php?proceed=true'><i class='fa fa-credit-card' aria-hidden='true'></i> Proceed to Checkout</a>
                      </h4>
                      </div>
                  </div>
           </div>";
    }
} else {
echo "<div class='alert alert-warning text-center'>
                  <h3>Oops! Looks like we have problems:</h3><br>
           </div>";
?>
<div class='well text-center'>
    <?php
    foreach ($data as $msg) {
        echo "<h5>- $msg<br></h5>";
    }?>
</div>

<?php }

mysqli_close($dbc);

include('../inc/footer.php');

?>


