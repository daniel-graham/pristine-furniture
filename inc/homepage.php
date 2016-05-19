<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 5/2/2016
 * Time: 3:53 PM
 */

include('header.php'); ?>

    <div class="jumbotron">
        <div id="heading">
            <?php
                $pathToMain = $section == "index" ?  "inc/partials/main.html" : "partials/main.html";
                include($pathToMain);
            ?>
        </div>
    </div>
    <!-- Carousel
   ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img class="first-slide img-responsive" src="assets/images/heroes/bugsback.jpg" alt="First slide" data-adaptive-background>
                <div class="container">
                    <div class="carousel-caption">
                        <div class="hero-text-brown">
                            <h1>The Bug's R Back!</h1>
                            <h5><code>Note:</code> This website is actively being developed. You may notice major differences while you
                                browse this website. Have a look around and if you see something you like, well... go ahead
                                and buy it of course!
                            </h5>
                        </div>
                        <p><a class="btn btn-lg btn-primary" href="views/register.php" role="button">Sign up today</a></p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img class="second-slide img-responsive" src="assets/images/heroes/anitque-logbed.jpg" alt="Second slide" data-adaptive-background>
                <div class="container">
                    <div class="carousel-caption">
                        <div class="hero-text-grunge">
                            <h1>Caribbean Dream</h1>
                            <h5>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta
                                gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                            </h5>
                        </div>
                        <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img class="third-slide img-responsive" src="assets/images/heroes/chic.jpg" alt="Third slide" data-adaptive-background>
                <div class="container">
                    <div class="carousel-caption">
                        <div class="hero-text-rosemary">
                            <h1>Life of Lavender</h1>
                            <h5>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta
                                gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                            </h5>
                        </div>
                        <p><a class="btn btn-lg btn-primary" href="views/shop.php" role="button">Browse Catalogue</a></p>
                    </div>
                </div>
            </div>
        </div>
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div><!-- /.carousel -->
    </div>
<?php include('footer.php') ?>