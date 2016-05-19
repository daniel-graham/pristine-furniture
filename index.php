<?php
header('Location: views/home.php'); // comment out this line to allow visitors to access home page without being authenticated
$pageTitle = "Pristine Furniture Trading Co.";
$section = "index";

include('inc/homepage.php');