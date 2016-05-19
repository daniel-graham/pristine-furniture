<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/27/2016
 * Time: 4:48 PM
 */

require('../session.php');
require('../services/sanitize.php');
$pageTitle = "Cart";
$section = "cart";

include('../inc/header.php');

$total = 0;
$errors = array();
unset($errors); // clear array

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    foreach($_POST['qty'] as $item_id => $item_qty){
        // Ensures that values are integers.
        $id = (int) sanitize($item_id);
        $qty = (int) sanitize($item_qty);

        $q1 = "SELECT item_name, item_quantity FROM shop WHERE item_id = $id";

        $stm = $pdo->prepare($q1);
        $stm->execute();
        $data = $stm->fetch();

        $amountInStock = $data['item_quantity'];
        $itemName = $data['item_name'];

        // Change quantity if amount is available or delete if set to zero
        if($qty == 0){
            unset($_SESSION['cart'][$id]);
        }elseif(($qty > 0) && ($amountInStock >= $qty)){
            $_SESSION['cart'][$id]['quantity'] = $qty;
        }else{
            if($amountInStock > 1){
                $errors[] = "There are only $amountInStock units of \"$itemName\" currently in stock";
            }else{
                $errors[] = "There is only $amountInStock unit of \"$itemName\" currently in stock";
            }

        }
    }
}

if(!empty($_SESSION['cart'])){
    require_once('../config/dao.php');


    $in = "";
    foreach($_SESSION['cart'] as $id => $value){
        $in .= $id. ',';
    }
    $in = substr($in, 0, -1);
    $q1 = "SELECT * FROM shop WHERE item_id IN ($in) ORDER BY item_id ASC";

    $stm = $pdo->prepare($q1);
    $stm->execute();
    $data = $stm->fetchAll();

    if(isset($errors) && !empty($errors)){
        echo "<div class='alert alert-warning text-center'>
                  <h3>Oops! Looks like we have a few problems:</h3><br>
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
               <h4>Please Update Your Cart and Try Again</h4>
          </div>";

    }


    echo '<div class="col-md-12">
        <h3 class="boxes-title"><span>ITEMS IN YOUR CART</span></h3>
    </div>';

    echo "<form action='views/cart.php' method='POST'>
          <table class='table table-responsive table-hover table-striped'>
              <thead>
                  <tr>
                      <th>Product</th>
                      <th>Description</th>
                      <th class='center-heading'>Quantity</th>
                      <th>Price</th>
                      <th>Subtotal</th>
                  </tr>
              </thead>
    <tbody>";

   foreach($data as $row){
        // Calculate sub-totals and grand total.
        $subtotal = $_SESSION['cart'][$row['item_id']]['quantity'] * $_SESSION['cart'][$row['item_id']]['price'];
        $total += $subtotal;

        // Display the row
       echo "<tr>
           <td><span class=''>{$row['item_name']}</span></td>
           <td><span class='text-muted'>{$row['item_desc']}</span></td>
           <td style='text-align: center'><input class='quantity text-center' type='number' size='3' name=\"qty[{$row['item_id']}]\"
                      value=\"{$_SESSION['cart'][$row['item_id']]['quantity']}\"</td>
           <td>{$row['item_price']}</td>
           <td>".number_format($subtotal, 2)."</td>
           <td><a href='#' type='button' class='delete red-tooltip' data-toggle='tooltip' title='Remove'><i class='fa fa-times text-danger' aria-hidden='true'></i></button></td>
       </tr>";


    }

    echo '<tr>
        <td></td>
        <td></td>
        <td></td>
        <td><span style="font-weight: bold">Total</span> = </td>
        <td colspan="5" class="pull-right"><span class="mdi-material-teal price-tag">'.number_format($total, 2).'</span></td>
    </tr>
    </table>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="form-actions">
                <input type="submit" name="updateCartBtn" value="Update My Cart" class="btn btn-warning btn-lg">
            </div>
        </div>' ?>

        <?php
        if(!isset($errors) && empty($errors)){ ?>
            <div class="col-md-3">
                <div class="form-actions pull-right">
                    <a href="views/checkout.php?total=<?php echo $total; ?>">
                        <button type="button" name="checkoutBtn"  class="btn btn-success btn-lg">Checkout</button>
                    </a>
                </div>
            </div>
        <?php }?>
    <?php
    echo '</div>
         </form>';

    mysqli_close($dbc);

}
else{
    echo "<div class='alert alert-info text-center'>
                  <h3>Your cart is currently empty.</h3><br>
                  <div class='row'>
                    <div class='col-md-4 col-lg-offset-4'>
                          <h4 class='text-info'>
                          <a href='views/shop.php'><i class='fa fa-shopping-basket' aria-hidden='true'></i> Continue Shopping</a>
                          </h4>
                     </div>
                  </div>
           </div>";
}
