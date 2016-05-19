<?php

require('../session.php');
require('../services/shop.php');
$pageTitle = "Buy an Item";
$section = "shop";

include('../inc/header.php');

if(isset($_GET["update"]) && isset($_GET["id"])){

    $itemCount = getTotalItems($pdo);
    $itemToUpdate = intval($_GET["id"]);

//    echo "params found <br>";
//    echo "_GET update ". $_GET["update"]."<br>";
//    echo "is_numeric id ". is_numeric($_GET["id"])."<br>";
//    echo "itemToUpdate ". $itemToUpdate;

    if($_GET["update"] == "true" && is_numeric($_GET["id"]) && $itemToUpdate >= 0){
        list($isValid, $posterId) = getItemPoster($itemToUpdate, $pdo);
        if(($isValid && ($posterId == $_SESSION['user_id'])) || isAdministrator($pdo)){
            // Read form submission on post
            if($_SERVER["REQUEST_METHOD"] == "POST" ) {

                if(isset( $_POST['submit_form'] ) )
                {
                    $name = sanitize($_POST["name"]);
                    $type = sanitize($_POST["type"]);
                    $price = sanitize($_POST["price"]);
                    $minPrice = sanitize($_POST["minPrice"]);
                    $quantity = sanitize($_POST["quantity"]);
                    $description = sanitize($_POST["description"]);
                    $prevURL = ltrim($_POST["currentURL"], "/~grahamd/");
                    $prevURL = ltrim($prevURL, "/pristine-furniture/");

                    $inputArray = [$name, $type, $price, $minPrice, $quantity, $description];
                }

            }
            list($successful, $data) = updateItem($itemToUpdate, $name, $type, $description, $price,
                                                    $minPrice, $quantity, $pdo);
            if($successful){
                echo "<div class='alert text-center'>
                        <h3>Product Update Successful</h3>
                        <p>the page will redirect shortly...</p>
                      </div>";
            }
            else{
                echo "<div class='alert alert-warning text-center'>
                        <h3>Oops! Looks Like Something Happened!</h3>
                      </div>";
                echo"<div class='well text-center'>";
                foreach ($data as $error) {
                    echo"<h4>- {$error} <br></h4>";
                }
                echo "</div>";
                echo "<div class='alert text-center'>
                        <p>the page will redirect shortly...</p>
                      </div>";
            }
        }else{
            // User not authorized to remove this item
        }
    } // invalid parameter passed redirect

    echo"<meta id='redirect' http-equiv='refresh' content='2;url=$prevURL'>"; //redirect to shop page
    exit;

}

if(isset($_GET["remove"])){

    $itemCount = getTotalItems($pdo);
    $itemToRemove = intval($_GET["remove"]);

    if(is_numeric($_GET["remove"]) && $itemToRemove >= 0){
        list($isValid, $posterId) = getItemPoster($itemToRemove, $pdo);
        if(($isValid && ($posterId == $_SESSION['user_id'])) || isAdministrator($pdo)){
            list($successful, $data) = removeItem($itemToRemove, $pdo);
            if($successful){
                echo "<div class='alert text-center'>
                        <h3>That Item Has Been Successfully Removed From The Store</h3>
                        <p>the page will redirect shortly...</p>
                      </div>";
            }
            else{
                echo "<div class='alert alert-warning text-center'>
                        <h3>Oops! Looks Like Something Happened!</h3>
                      </div>";
                echo"<div class='well text-center'>";
                foreach ($data as $error) {
                    echo"<h4>- {$error} <br></h4>";
                }
                echo "</div>";
                echo "<div class='alert text-center'>
                        <p>the page will redirect shortly...</p>
                      </div>";
            }
        }else{
            // User not authorized to remove this item
        }
    } // invalid parameter passed redirect

    echo'<meta id="redirect" http-equiv="refresh" content="2;url=views/shop.php">'; //redirect to shop page
    exit;

}

if (isset($_GET["page"])) {

    define("PAGE_SIZE", 6);
    $page = intval($_GET["page"]);
    $itemCount = getTotalItems($pdo);
    $pages = $itemCount/PAGE_SIZE;
    $pages = ceil($pages);

    if(is_numeric($_GET["page"]) && $page > 0 && $page <= $pages){

        if($page == 1){
            list($check, $data) = getItems($pdo);
        }else{
            $from = ($page * PAGE_SIZE)-PAGE_SIZE; // calculate appropriate starting point
            list($check, $data) = getItems($pdo, $from);
        }
    }else{
        echo'<meta id="redirect" http-equiv="refresh" content="2;url=views/shop.php?page=1">'; //redirect to shop page
        exit;
    }

}else{
    list($check, $data) = getAllItems($pdo);

}

if(isset($_GET["status"]) AND $_GET["status"] == "done"){
    echo "<div class='alert text-center'>
                <h3>Update Successful</h3>
                <p>the page will redirect shortly...</p>
              </div>";

    echo "<script>
                // Display a success toast, with a title
                toastr.options.showEasing = 'swing';
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.success('Great, the requested item has been updated!', {timeOut: 5000}, {closeButton: true});
              </script>";
    echo'<meta id="redirect" http-equiv="refresh" content="5;url=views/shop.php">'; //redirect to post page
    exit;
}


?>

<div class="container" xmlns="http://www.w3.org/1999/html">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="list-group">
                <div class="form-group">
                    <br>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </div>
                        <input type="search" class="form-control row" placeholder="Search">
                    </div>
                </div>
                <div class="col-md-12">
                    <h3 class="boxes-title"><span>NEW ARRIVALS</span></h3>
                </div>
                <div style="clear:both;"></div>
                <!-- BEGIN: LIST OF ITEMS -->
                <div class="col-md-12 pft">
                    <div class="pft-wrapper-outer row-fluid">
                        <div class="pft-wrapper row-fluid" style="left: 0px; display: block;">
                            <?php

                            function isAuthorized($itemId, $pdo){
                                $itemId = $itemId;
                                list($isValid, $posterId) = getItemPoster($itemId, $pdo);

                                if(($isValid && ($posterId == $_SESSION['user_id'])) || isAdministrator($pdo)){
                                    return true;
                                }else{
                                    return false;
                                }
                            }

                            if ($check) {

                                foreach ($data as $item) {?>
                                    <div class='col-md-6'>
                                        <div class='pft-item' style='width: 330px;'>
                                            <!-- BEGIN: ITEM -->
                                            <div class='item'>
                                                <div class='product'>
                                                    <a class='add-fav tooltipHere hidden' data-toggle='tooltip' data-original-title='Add to Wishlist' data-placement='left'>
                                                        <i class='glyphicon glyphicon-heart'></i>
                                                    </a>
                                                    <div class='item-id hidden'><?php $itemId = $item['item_id']; echo $itemId; ?></div>
                                                    <!-- BEGIN: IMAGE -->
                                                    <div class='image'>
                                                        <a class="<?php if(isAuthorized($itemId, $pdo)){echo 'popDetails';} else{echo 'popImage';}  ?>" href='#'><img src='<?php echo $item['item_image']; ?>' alt='product image' class='img-responsive'></a>
                                                        <div class='promotion'>
                                                            <span class='new-product'> NEW</span>
                                                            <a href="">
                                                                <?php
                                                                if(isAuthorized($itemId, $pdo)){
                                                                    echo "<span class='remove-product hvr-shadow-radial'> REMOVE ITEM <i class='glyphicon glyphicon-remove-circle'></i>
                                                                            <span class='item-id hidden'>{$itemId}</span>
                                                                          </span>";
                                                                }
                                                                ?>
                                                            </a>
                                                            <span class='discount hidden'>15% OFF</span>
                                                        </div>
                                                    </div><!-- END: IMAGE-->
                                                    <!-- BEGIN: PRODUCT DESCRIPTION-->
                                                    <div class='description'>
                                                        <h4 class='lead'>
                                                            <a class="productName" href='product-details.php?id=<?php echo $item['item_id']; ?>'><?php echo stripslashes($item['item_name']); ?></a>
                                                        </h4>
                                                        <p class="productDesc"><?php echo stripslashes($item['item_desc']); ?></p>
                                                        <div class="category">
                                                            Category:
                                                            <span class='productType'><?php echo $item['item_type']; ?></span>
                                                        </div>

                                                    </div>
                                                    <div class='price'><span>$<?php echo $item['item_price']; ?></span></div>
                                                    <div class="productInfo hidden">
                                                        <span class="minPrice">$<?php echo $item['item_min_price']; ?></span>
                                                        <span class="quantity"><?php echo $item['item_quantity']; ?></span>
                                                    </div>
                                                    <div class='action-control'>
                                                        <a href='views/added.php?id=<?php echo $item['item_id']; ?>' class='btn btn-primary'>
                                                            <span class='add2cart'>
                                                                <i class='glyphicon glyphicon-shopping-cart'> </i> Add to cart
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- END: PRODUCT DESCRIPTION-->
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            <?php } else {
                                $errors = $data;
                            }?>

                        </div>
                    </div>
                    <!-- END: ITEMS -->
                    <?php if(isset($pages)){?>
                        <div class="text-center">
                            <ul class="pagination">
                                <li id="prevPage" class="<?php if ($page == 1) echo 'disabled';?>">
                                    <a class="hvr-shadow" href="views/shop.php?page=<?php $previousPage = ($page > 1) ? $page -1 : 1; echo $previousPage; ?>" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                                <?php
                                for($pageNum = 1; $pageNum <= $pages; $pageNum++) {?>
                                    <li class="<?php if ($pageNum == $page) echo 'active';?>">
                                        <a href="views/shop.php?page=<?php echo $pageNum; ?>"><?php echo $pageNum; ?></a>
                                    </li> <?php
                                }
                                ?>
                                <li class="text-muted">
                                    <a href="views/shop.php">All Items</a>
                                </li>
                                <li id="nextPage" class="<?php if ($page == $pages) echo 'disabled';?>">
                                    <a class="hvr-shadow" href="views/shop.php?page=<?php $nextPage = ($page < $pages) ? $page +1 : $pages; echo $nextPage; ?>" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    include('../inc/partials/product-image.html');
    include('../inc/partials/remove-product.html');
    include('../inc/partials/product-details.php');
    mysqli_close($dbc);
    ?>
</div>

</body>
</html>