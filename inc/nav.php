<?php
$brandName = "Pristine Furniture";

function isSignedIn(){

    $signedIn = isset($GLOBALS["signedIn"]) ? $GLOBALS["signedIn"] : NULL ;
    return $signedIn;
}

?>
<header>
    <nav class="navbar navbar-material-pristinegreen navbar-success" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle gets grouped for better UX on mobile -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <div role="presentation">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </div>
                </button>
                <a class="navbar-brand" href="<?php $homePage =  $section == "index" || $section == "login"||  $section == "register" ?  "index.php" : "views/home.php"; echo $homePage;?> "><?php echo $brandName; ?></a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left">
                    <?php if(isSignedIn()){?>
                        <li class=<?php if($section == "post"){ echo "nav-current";}?> role="presentation"><a role="menuitem" href="views/post.php">Post an Item</a></li>
                    <?php }?>
                    <?php if(isSignedIn()){?>
                        <li class=<?php if($section == "browse"){ echo "nav-current";}?> role="presentation"><a role="menuitem" href="views/shop.php?page=1">Shop</a></li>
                    <?php }?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if(!isSignedIn()){?>
                        <li class=<?php if($section == "login"){ echo "nav-current";}?> role="presentation"><a role="menuitem" href="views/login.php">Login</a></li>
                        <li class=<?php if($section == "register"){ echo "nav-current";}?> role="presentation"><a role="menuitem" href="views/register.php">Register</a></li>
                    <?php }?>

                    <?php if(isSignedIn()){?>
                        <li class="dropdown">
                            <a href="views/profile.php" class="dropdwon-toggle" data-toggle="dropdown">
                                <!--<span class="mdi-navigation-expand-more"></span> &lt;!&ndash; MDI caret icon [deprecated]&ndash;&gt;-->
                                <img src="https://www.gravatar.com/avatar/<?php echo md5($email)?>.jpg?d=identicon"
                                     class="img-circle gravatar"> <!-- Gravatar Image -->
                                &nbsp;
                                <?php echo $firstName?>
                                <i class="material-icons">arrow_drop_down</i> <!-- MD Drop Down Icon -->
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li role="presentation">
                                    <a role="menuitem" href="views/profile.php" data-toggle="modal">
                                        <i class="mdi-social-person-outline"></i> Profile
                                    </a>
                                </li>
                                <li class=<?php if($section == "cart"){ echo "dropdown-active";}?> role="presentation">
                                    <a role="menuitem" href="views/cart.php">
                                        <!-- MD Shopping Cart Icon -->
                                        <i class="mdi-action-shopping-cart"></i> Cart
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" href="views/logout.php">
                                        <i class="mdi-action-exit-to-app"></i> Logout
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" href="" data-toggle="modal" data-target="#pasModal">
                                        <i class="mdi-action-lock"></i> Change Password
                                    </a>
                                </li>

                            </ul>
                        </li>
                    <?php }?>


                </ul>
            </div>
        </div>

        <?php if(isSignedIn()){?>
            <div>
                <?php include('partials/changepass.php') ?>
            </div>
        <?php }?>

    </nav>
</header>