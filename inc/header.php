<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width">
	<meta name="description" content="A website for buying and selling new and slightly used furniture.">
	<meta name="author" content="Daniel Graham">

	<base href="http://localhost/pristine-furniture/index.php">
	<title><?php echo $pageTitle; ?></title>

	<!-- Material Design fonts -->
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Oswald:400,700" type="text/css">
	<link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons" >
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css"> <!-- load fontawesome -->

	<!-- Load Bootstrap and other CSS from CDN -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css"/>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.2.1/css/material.css" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.9/css/ripples.css" />
	<link rel="stylesheet" href="//cdn.rawgit.com/enyo/dropzone/master/dist/dropzone.css" />
	<link rel="stylesheet" href="//cdn.rawgit.com/IanLunn/Hover/master/css/hover-min.css" />
    <!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.9/css/bootstrap-material-design.css" />-->

    <!-- Load Bootstrap and other CSS Locally -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/toastr.css"/>
    <link rel="stylesheet" href="css/material.css"/>
    <link rel="stylesheet" href="css/ripples.css"/>
    <link rel="stylesheet" href="css/dropzone.css"/>
    <link rel="stylesheet" href="css/material-icons.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
    <!--    <link rel="stylesheet" href="css/bootstrap-material-design.css"/>-->


	<link rel="stylesheet" href="css/main.css" type="text/css">

    <!-- Load Local Scripts -->
	<script src="scripts/js/libs/jquery.min.js"></script><!-- Load JQuery -->
    <script src="scripts/js/libs/parsley.min.js"></script> <!-- Load Parsly for client-side form validation -->

	<!-- Load Local Scripts -->
    <script type="text/javascript" src="scripts/js/fallback.js"></script>
    <script type="text/javascript" src="scripts/js/validate.js"></script>
	<script type="text/javascript" src="scripts/js/custom.js"></script>

    <!-- Load Local Copies of External Stylesheets if Necessary -->
	<script type="text/javascript">
		window.onload = runCheck();
	</script>


	<link rel="shortcut icon" href="favicon.ico">
</head>
<body>

<?php include('nav.php'); ?>

<div id="bootstrapCssTest" class="hidden"></div>

<!-- Load jQuery and other JS from CDN-->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.2.1/js/material.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.2.1/js/ripples.js"></script>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.9/js/material.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.9/js/ripples.js"></script>-->

<script src="//cdn.rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
<script src="//cdn.rawgit.com/briangonzalez/jquery.adaptive-backgrounds.js/master/src/jquery.adaptive-backgrounds.js"></script>



<!-- Manually Load Local Copies of External Scripts Here if Necessary -->

<!-- Dynamically Load Local Copies of External Scripts if Necessary -->
<script>window.jQuery || document.write('<script src="scripts/js/libs/jquery.min.js"><\/script>')</script>
<script>$.fn.modal || document.write('<script src="scripts/js/libs/bootstrap.min.js"><\/script>')</script>
<script>$.fn.material || document.write('<script src="scripts/js/libs/material.js"><\/script>')</script>
<script>$.fn.ripples || document.write('<script src="scripts/js/libs/ripples.js"><\/script>')</script>
<script>$.dropzone || document.write('<script src="scripts/js/libs/dropzone.js"><\/script>')</script>

<!-- Initialize Material Bootstrap -->
<script>
	$(document).ready(function() {
		$.material.init();
	});
</script>

<!-- Initialize Adaptive Background -->
<script>
    $(document).ready(function(){
        $.adaptiveBackground.run();
    });
</script>

<!-- Enable Tooltips -->
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>



<div id="content">