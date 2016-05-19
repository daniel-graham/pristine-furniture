<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 4/27/2016
 * Time: 10:24 AM
 */


//session_start();
require_once('../config/dao.php'); // database connection object
require ('sanitize.php');

function searchItem($dbc, $name='*'){
    $errors = array();

    // Check that name is not empty
    if(empty($name)){
        $errors[] = 'Enter the name of a product to search for.';
    }else{
        $n = sanitize($name);
    }


    // Check that email and password exists
    if(empty($errors)){


        $q1 = "SELECT $n
              FROM shop";
        $r1 = mysqli_query($dbc, $q1);


        if(mysqli_num_rows($r1) > 0){
            $row = mysqli_fetch_array($r1, MYSQLI_ASSOC);
            return array(true, $row); // product found: return true and rows with the list of products.
        }else{
            $errors[] = 'No product found with the name specified.';
        }

    }
    return array(false, $errors); // validation failed return error messages to the caller


}

function getItem($dbc, $id=1){
    $errors = array();
    // Check that email is not empty
    if(empty($id)){
        $errors[] = 'id parameter must not be blank';
    }else{
        $id = intval(sanitize($id));
    }

    // Check that email and password exists
    if(empty($errors)){


        $q1 = "SELECT *
              FROM shop
              WHERE item_id = '$id'";
        $r1 = mysqli_query($dbc, $q1);


        if(mysqli_num_rows($r1) == 1){
            $row = mysqli_fetch_array($r1, MYSQLI_ASSOC);

            return array(true, $row); // product found: return true and row with the product details.
        }else{
            $errors[] = 'There are currently no items with that id in the shop.';
        }

    }
    return array(false, $errors); // validation failed return error messages to the caller

}

function updateItem($itemId, $itemName, $itemType, $itemDesc, $itemPrice, $itemMinPrice, $itemQuantity, $pdo){
    $errors = array();
    $params = array();

    // Check that itemId is not empty
    if(empty($itemId)){
        $errors[] = 'itemId parameter must not be blank';
    }else{
        $itemId = intval(sanitize($itemId));
    }

    //TODO dynamic queries based on parameters passed
    if(empty($itemName)){
        $q2 = "";
    }

    // Check that item exists
    if(empty($errors)){

        $q1 = "UPDATE
               shop
               SET item_name = ?, item_type = ?,
               item_desc = ?, item_price = ?,
               item_min_price = ?, item_quantity = ?
               WHERE item_id = $itemId";

        $stm = $pdo->prepare($q1);
        $result = $stm->execute(array($itemName, $itemType, $itemDesc, $itemPrice, $itemMinPrice, $itemQuantity));

        if($result && $stm->rowCount()){
            return array(true, "The requested item has been updated"); // product found: return true and inform the user of the update.
        }else{
            $errors[] = 'There are currently no items with that item Id in the shop.';
        }

    }
    return array(false, $errors); // validation failed return error messages to the caller

}

function removeItem($itemId, $pdo){
    $errors = array();
    // Check that itemId is not empty
    if(empty($itemId)){
        $errors[] = 'itemId parameter must not be blank';
    }else{
        $itemId = intval(sanitize($itemId));
    }

    // Check that item exists
    if(empty($errors)){

        $q1 = "DELETE
              FROM shop
              WHERE item_id = $itemId";

        $stm = $pdo->prepare($q1);
        $result = $stm->execute();

        if($result && $stm->rowCount()){
            return array(true, "That item has been removed from the store"); // product found: return true and the poster_id of the item.
        }else{
            $errors[] = 'There are currently no items with that item Id in the shop.';
        }

    }
    return array(false, $errors); // validation failed return error messages to the caller

}


function getItemPoster($itemId, $pdo){
    $errors = array();
    // Check that itemId is not empty
    if(empty($itemId)){
        $errors[] = 'itemId parameter must not be blank';
    }else{
        $itemId = intval(sanitize($itemId));
    }

    // Check that item exists
    if(empty($errors)){

        $q1 = "SELECT poster_id
              FROM shop
              WHERE item_id = $itemId";

        $stm = $pdo->prepare($q1);
        $stm->execute();
        $data = $stm->fetch();

        if(!empty($data)){

            return array(true, $data['poster_id']); // product found: return true and the poster_id of the item.
        }else{
            $errors[] = 'There are currently no items with that id in the shop.';
        }

    }
    return array(false, $errors); // validation failed return error messages to the caller

}

function getTotalItems($pdo){

    $q1 = "SELECT *
              FROM shop WHERE item_quantity > 0";


    $stm = $pdo->prepare($q1);
    $stm->execute();
    $data = $stm->rowCount();

    return $data;

}

function getItems($pdo, $from=0, $amount=6){
    $errors = array();

    // Check that from and amount is not empty
    if(empty($from) && empty($amount)){
        getAllItems($pdo);
    }


    // Fetch Items
    if(empty($errors)){


        $q1 = "SELECT *
              FROM shop WHERE item_quantity > 0 LIMIT $from, $amount";


        $stm = $pdo->prepare($q1);
        $stm->execute();
        $data = $stm->fetchAll();

        if(!empty($data)){
            return array(true, $data); // products found: return true and rows with the list of products.
        }else{
            $errors[] = 'There are currently no items in the shop.';
        }

    }
    return array(false, $errors); // validation failed return error messages to the caller

}

function getAllItems($pdo){
    $errors = array();
    $items = array();


    // Check that email and password exists
    if(empty($errors)){


        $q1 = "SELECT *
              FROM shop WHERE item_quantity > 0";


        $stm = $pdo->prepare($q1);
        $stm->execute();
        $data = $stm->fetchAll();

        if(!empty($data)){
            return array(true, $data); // products found: return true and rows with the list of products.
        }else{
            $errors[] = 'There are currently no items in the shop.';
        }

    }
    return array(false, $errors); // validation failed return error messages to the caller

}
