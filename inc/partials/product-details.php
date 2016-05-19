<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/27/2016
 * Time: 1:37 PM
 */

?>

<div class="modal fade" id="productmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal Content -->
        <div class="modal-content">
            <!-- Modal Body -->
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <div class="row title">
                    <div class="col-md-6 col-md-offset-3">
                        <img src="" class="imagepreview" style="width: 100%;">
                        <hr>
                    </div>
                </div>
                <div class="row title">
                    <!-- BEGIN: Form -->
                    <form id="postItem" method="post" action="views/shop.php?update=false&id=" data-parsley-validate="" onsubmit="return validate();">
                        <!-- Product Name -->
                        <fieldset class="form-group">
                            <div class="">
                                <?php $itemId = $item['item_id'];
                                list($isValid, $posterId) = getItemPoster($itemId, $pdo); ?>
                                <input id="postTitle" type="text" class="form-control" name="name" placeholder="Enter a title for this product" data-parsley-length="[4, 30]" required>
                                <span class="help-block">Product name</code></span>
                            </div>
                            <span class="material-input"></span>
                        </fieldset>
                        <!-- Product Description -->
                        <fieldset class="form-group">
                            <div class="">
                                <textarea id="postDesc" class="form-control" name="description" placeholder="Write a few sentences describing this item" data-parsley-length="[10, 200]"required></textarea>
                                <span class="help-block">Product Description</code></span>
                            </div>
                            <span class="material-input"></span>
                        </fieldset>
                        <div class="row">
                            <!-- Product Price -->
                            <fieldset class="form-group col-md-4">
                                <div class="">
                                    <input id="postPrice" type="number" class="form-control text-center" name="price" placeholder="What's your asking price?" step="0.01" data-parsley-type="number" data-parsley-range="[1, 9999.99]" required>
                                    <span class="help-block">Price</code></span>
                                </div>
                                <span class="material-input"></span>
                            </fieldset>
                            <!-- Product Min. Price -->
                            <fieldset class="form-group col-md-4">
                                <div class="">
                                    <input id="postMinPrice" type="number" class="form-control text-center" name="minPrice" placeholder="What's your minimum price?" step="0.01" data-parsley-type="number" data-parsley-range="[1, 9999.99]" required>
                                    <span class="help-block">Min. Price</code></span>
                                </div>
                                <span class="material-input"></span>
                            </fieldset>
                            <!-- Product Quantity -->
                            <fieldset class="form-group col-md-4">
                                <div class="">
                                    <input id="postQuantity" type="number" class="form-control text-center" name="quantity" placeholder="How many units of this item do you have?" data-parsley-type="number" min="0" required>
                                    <span class="help-block">Quantity</code></span>
                                </div>
                                <span class="material-input"></span>
                            </fieldset>
                        </div>
                        <input id="postImageURL" type="text" class="form-control hidden" name="imageURL" placeholder="uploads/" value="">
                        <input id="currPage" type="text" class="form-control hidden" name="currentURL" placeholder="views/shop.php" value="<?php echo $_SERVER['REQUEST_URI'];?>">
                        <!-- Product Type -->
                        <fieldset class="form-group">
                            <select id="postType" class="c-select text-center" name="type" required>
                                <option value="">Product Type</option>
                                <option value="beds">Bed</option>
                                <option value="tables">Table</option>
                                <option value="desks">Desk</option>
                                <option value="chairs">Chair</option>
                                <option value="couches">Couch</option>
                                <option value="sofas">Sofa</option>
                                <option value="drawers">Drawer</option>
                                <option value="wardrobes">Wardrobe</option>
                                <option value="decoration">Decoration</option>
                                <option value="accessories">Accessories</option>
                            </select>
                        </fieldset>
                        <div class="">
                            <input id="updateButton" type="submit" name="submit_form" value="Update" class="btn btn-warning">
                        </div>
                    </form>
                    <!-- END: Form -->
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

