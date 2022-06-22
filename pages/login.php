<!DOCTYPE html>
<html>
<head>
	<link rel = "stylesheet" type = "text/css" href= "css/login.css">

	<title>Login</title>
</head>
<body class = "lol">

	<div class = "login-container">
		<form action = "/air_reservation/authenticate" method = "post">
			<input type = "text" placeholder="Enter your username" name = "email" class = "login-container__input">
			<input type = "password" placeholder="Enter your password" name = "password" class = "login-container__input">
			<input type = "submit" value = "Login" class = "login-btn">

		</form>
	</div>
</body>
</html>