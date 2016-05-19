<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/17/2016
 * Time: 3:23 PM
 *
 * AuthService processes login attempts and creates a new session for the user.
 * AuthService retrieves the user's info and sets it as session data.
 */

//session_start();
require('../config/dao.php'); // database connection object
require ('sanitize.php');

function postItem($dbc, $posterId, $itemName='', $itemType='', $itemDescription='', $itemImageURL='', $itemPrice, $itemMinPrice, $itemQuantity=1 ){
    $errors = array();

    // Check that posterId is not empty
    if(empty($posterId)){
        $errors[] = 'Poster id empty.';
    }else{
        $posterId = intval(sanitize($posterId));
    }

    // Check that name is not empty
    if(empty($itemName)){
        $errors[] = 'Enter the name of this product.';
    }else{
        $name = sanitize($itemName);
    }

    // Check that type is not empty
    if(empty($itemType)){
        $errors[] = 'Enter a product type.';
    }else{
        $type = sanitize($itemType);
    }

    // Check that description is not empty
    if(empty($itemDescription)){
        $errors[] = 'Enter a description of this product.';
    }else{
        $desc = sanitize($itemDescription);
    }

    // Check that imageURL is not empty
    if(empty($itemImageURL)){
        $errors[] = 'Enter the image URL of this product.';
    }else{
        $image = sanitize($itemImageURL);
    }

    // Check that price is not empty
    if(empty($itemPrice)){
        $errors[] = 'Enter the price of the product.';
    }else{
        $price = floatval(sanitize($itemPrice));
    }

    // Check that minimum price is not empty
    if(empty($itemMinPrice)){
        $errors[] = 'Enter the price of the product.';
    }else{
        $minPrice = floatval(sanitize($itemMinPrice));
    }

    // Check that quantity is not empty
    if(empty($itemQuantity)){
        $errors[] = 'Enter the quantity of the product.';
    }else{
        $quantity = intval(sanitize($itemQuantity));
    }

    // Check that fields are set
    if(empty($errors)){

        $postVars= array();
        $postVars[] = $posterId." : ". gettype($posterId);
        $postVars[] = $name." : ". gettype($name);
        $postVars[] = $desc." : ". gettype($desc);
        $postVars[] = $type." : ". gettype($type);
        $postVars[] = $image." : ". gettype($image);
        $postVars[] = $price." : ". gettype($price);
        $postVars[] = $minPrice." : ". gettype($minPrice);
        $postVars[] = $quantity." : ". gettype($quantity);


        $q1 = "INSERT INTO shop(poster_id, item_name,  item_desc, item_type, item_image, item_price, item_min_price, item_quantity)
               VALUES ('$posterId', '$name', '$desc', '$type', '$image', '$price', '$minPrice', '$quantity')";

        $r1 = mysqli_query($dbc, $q1);

        if(mysqli_affected_rows($dbc) == 1){
            return array(true, 1); // insertion successful.
        }else{
            $errors[] = 'Error: '.mysqli_error($dbc);
            $errors[] = 'Post Variables: '.implode(", ", $postVars);
        }

    }
    return array(false, $errors); // validation failed return error messages to the caller


}



if($_SERVER['REQUEST_METHOD'] == 'POST'){

//    require('../session.php'); // session

    function uploadImage()
    {
        if (!empty($_FILES)) {

            echo "Inside upload()";

           require('../file-upload.php');

        }
    }

    if (isset($_POST['submit_form'])) {

        require('../session.php'); // session
//        require('login.php'); // login service
        require('../loader.php'); // loader

        $posterId = sanitize($userId);
        $title = sanitize($_POST["title"]);
        $type = sanitize($_POST["type"]);
        $price = sanitize($_POST["price"]);
        $url = sanitize($_POST["imageURL"]);
        $minPrice = sanitize($_POST["minPrice"]);
        $quantity = sanitize($_POST["quantity"]);
        $description = sanitize($_POST["description"]);


        list($check, $data) = postItem($dbc, $posterId, $title, $type, $description, $url, $price, $minPrice, $quantity);


        if ($check) {
            uploadImage();
            header('Location: ../views/post.php?status=done');

        } else {
            $errors = $data;
        }
    }

    mysqli_close($dbc);
}
//include('../views/login.php');

