<!DOCTYPE html>
<html>
<head>
	<link rel = "stylesheet" type = "text/css" href= "css/login.css">

	<title>Signup</title>
</head>
<body class = "lol">

	<div class = "login-container">
		<form action = "/air_reservation/registration" method = "post" enctype="multipart/form-data">
			<input type = "text" placeholder="Enter your first name" name = "fname" class = "login-container__input">
			<input type = "text" placeholder="Enter your last name" name = "lname" class = "login-container__input">
			<input type = "text" placeholder="Enter your username" name = "email" class = "login-container__input">
			<input type = "password" placeholder="Enter your password" name = "password" class = "login-container__input">
			<input type = "file" name = "image"><br>
			<input type = "submit" value = "Signup" class = "login-btn">
			<a href = "/air_reservation/login">Already have an account ? </a>

		</form>
	</div>
</body>
</html>