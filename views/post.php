<?php
require('../session.php');
$pageTitle = "Sell an Item";
$section = "post";

include('../inc/header.php');

// Read form submission on post
if($_SERVER["REQUEST_METHOD"] == "POST" ) {

    if( isset( $_POST['submit_form'] ) )
    {
        function sanitize($data){

            $data = trim($data);
            $data = stripslashes($data);
            $data = strip_tags($data);
            $data = htmlspecialchars($data);
            $data = mysqli_real_escape_string($data);
            return $data;
        }

        $title = sanitize($_POST["title"]);
        $type = sanitize($_POST["type"]);
        $price = sanitize($_POST["price"]);
        $minPrice = sanitize($_POST["minPrice"]);
        $description = sanitize($_POST["description"]);

        $inputArray = [$title, $type, $price, $minPrice, $description];

        function validate(){
            if(!empty($title) && !empty($type) && !empty($price) && !empty($minPrice) && !empty($description))
            {
                return "nullError";
            }
            else if($price < $minPrice){
                echo($price." ".$minPrice);
                return "priceError";
            }
        }


        function isValid(){
            $validator = validate();
            switch($validator){
                case "nullError":
                    header("Location: post.php?status=nullError");
                    break;
                case "priceError":
                    header("Location: post.php?status=priceError");
                    break;
                default:
                    header("Location: post.php?status=done");
                    echo $validator;
            }
            exit; //stops execution after redirect
        }

        isValid();



    }

    //TODO: Send Email


}

?>

<div class="container">
    <?php
    if(isset($_GET["status"]) AND $_GET["status"] == "done"){
        echo "<div class='alert text-center'>
                <h3>Your Item Has Been Successfully Posted</h3>
                <p>the page will redirect shortly...</p>
              </div>";

        echo "<script>
                // Display a success toast, with a title
                toastr.options.showEasing = 'swing';
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.success('Great, your item has been posted!', {timeOut: 5000}, {closeButton: true});
              </script>";
        echo'<meta id="redirect" http-equiv="refresh" content="5;url=views/post.php">'; //redirect to post page
        exit;
    }
    else if(isset($_GET["status"]) AND $_GET["status"] == "error"){
        echo "<div class='alert text-center'>
                <h3>There Has Been An Error.</h3>
                <p>please try again...</p>
              </div>";

        echo "<script>
                // Display a danger toast, with a title
                toastr.options.showEasing = 'swing';
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.error('There was an error.', {timeOut: 5000}, {closeButton: true});
              </script>";
        echo'<meta http-equiv="refresh" content="5;url=views/post.php">'; //redirect to post page
        exit;
    }
    else if(isset($errors) && !empty($errors)){
        echo "<div class='alert alert-warning text-center'>
                  <h3>Oops! Looks like we have problems:</h3><br>
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
               <h4>Please try again</h4>
          </div>";
    }
    else

    ?>

    <script>
        $(document).ready(function(){
            $("form#imageUploader").dropzone({
                url: "file-upload.php",
                maxFilesize: 5, // MB
                acceptedFiles: "image/*", // restrict upload to images
                addRemoveLinks: true,
                accept: function(file, done) {
                    if (file.name.length > 40) {
                        done("Sorry, that file name is too long");
                    }
                    else {
                        $("#postImageURL").val('uploads/'+ file.name);
                        done();
                    }
                }
            });
        });
    </script>

    <div class="row title">
        <div class="col-md-6 col-md-offset-3">
            <br>
            <div id="errorAlert" class="bs-callout bs-callout-warning alert alert-warning hidden">
                <h4>Oh snap!</h4>
                <p>This form seems to be invalid :(</p>
            </div>

            <div id="doneAlert" class="bs-callout bs-callout-info alert alert-success hidden">
                <h4>Yay!</h4>
                <p>Everything seems to be ok :)</p>
            </div>
            <br>
            <form method="post" action="file-upload.php" id="imageUploader" class="dropzone" data-parsley-validate="" onsubmit="return validateFileUpload();">
                <div class="fallback">
                    <label for="imageUpload">Upload an Image</label>
                    <input id="imageUpload" name="file" type="file" accept="image/svg+xml, image/gif, image/jpeg,
                    image/png, image/jpg, .gif, .jpeg, .png, .jpg" multiple required aria-required="true"/>
                </div>
<!--                <input type="submit" name="upload_file" value="Upload Image" class="btn btn-info">-->
            </form>
            <br>
            <form id="postItem" method="post" action="services/post.php" data-parsley-validate="" onsubmit="return validate();">
                <input id="postTitle" type="text" class="form-control" name="title" placeholder="Enter a title for this product" data-parsley-length="[4, 30]" required>
                <br>
                <textarea id="postDesc" class="form-control" name="description" placeholder="Write a few sentences describing this item" data-parsley-length="[10, 200]"required></textarea>
                <br>
                <input id="postPrice" type="number" class="form-control" name="price" placeholder="What's your asking price?" step="0.01" data-parsley-type="number" data-parsley-range="[1, 9999.99]"required>
                <br>
                <input id="postMinPrice" type="number" class="form-control" name="minPrice" placeholder="What's your minimum price?" step="0.01" data-parsley-type="number" data-parsley-range="[1, 9999.99]"required>
                <br>
                <input id="postQuantity" type="number" class="form-control" name="quantity" placeholder="How many units of this item do you have?" data-parsley-type="number" min="1" required>
                <br>
                <input id="postImageURL" type="text" class="form-control hidden" name="imageURL" placeholder="uploads/" value="">
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
                <br>
                <input type="submit" name="submit_form" value="Post" class="btn btn-danger">
            </form>

        </div>
    </div>
</div>


