<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<link rel = "stylesheet" type = "text/css" href= "css/index.css">

	<?php if(isset($_SESSION["username"])): ?>
		<title>User Profile</title>
	<?php else: ?>
		<title>Air reservation system | home page</title>
	<?php endif; ?>

</head>
<body class = "container">
	<?php if (isset($_SESSION["username"])): ?>

		<?php $image = $_SESSION["image_url"]; ?>
		<div name = "header" class = "nav-bar">
			<img src = "<?=$image?>" alt ="somthing went wrong" class = "nav-bar__nav-image"/>
			<div class = "nav-bar__nav-item">
				<div class = "nav-bar__nav-item__child"><?=$_SESSION["name"]?></div>
				<div class = "nav-bar__nav-item__child"><a href = "logout">Logout</a></div>

			</div>

		</div>

	<?php else: ?>

		<div name = "header" class = "nav-bar">
			<img src = "image/favicon/pikachu.png" class = "nav-bar__nav-image"/>
			<div class = "nav-bar__nav-item">
				<div class = "nav-bar__nav-item__child"><a href = "login">Login</a></div>
			/
			<div class = "nav-bar__nav-item__child"><a href = "signup">Signup</a></div>
		</div>

	</div>

	<?php endif; ?>
