<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title> Conference Management System</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	<!-- MDL -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
	<link rel="stylesheet" href="https://code.getmdl.io/1.1.1/material.blue-indigo.min.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="stylesheets/styles.css">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class = "cms mdl-color--grey-100 mdl-base">
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
	  <header class="mdl-layout__header">
		<div class="mdl-layout__header-row">
		  <!-- Title -->
		  <span class="mdl-layout-title">Conference Management System</span>
		  <!-- Add spacer, to align navigation to the right -->
		  <div class="mdl-layout-spacer"></div>
		  <!-- Navigation. We hide it in small screens. -->
		  <nav class="mdl-navigation">
			<a class="mdl-navigation__link" href="index.php">Home</a>
			<a class="mdl-navigation__link" href="register.php">Register</a>
			<a class="mdl-navigation__link" href="login.php">Login</a>
		  </nav>
		</div>
	  </header>
	  	  <div class="mdl-layout__drawer">
		<span class="mdl-layout-title">CMS</span>
		<nav class="mdl-navigation">
		  <a class="mdl-navigation__link" href="">Your Conferences</a>
		  <a class="mdl-navigation__link" href="">Your Events</a>
		</nav>
	  </div>