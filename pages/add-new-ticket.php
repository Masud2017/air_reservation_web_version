<!DOCTYPE html>
<html>
<head>
	<link rel = "stylesheet" type = "text/css" href= "css/login.css">

	<title>Login</title>
</head>
<body class = "lol">

	<div class = "login-container">
		<form action = "/air_reservation/addnewticket" method = "get">
			<input type = "text" placeholder="Enter the ticket destination" name = "destination" class = "login-container__input">
			<input type = "text" placeholder="Enter the ticket price" name = "price" class = "login-container__input">
			<input type = "submit" value = "Add ticket" class = "login-btn">

		</form>
	</div>
</body>
</html>