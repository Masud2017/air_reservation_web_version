<?php include ("layout/header.php")?>
<link rel = "stylesheet" type = "text/css" href= "css/add-user-address.css">
<body>
<div class = "add-user-info-container">
	<form action = "adduseraddress" method ="get">
		<input type = "text" placeholder="Enter your address" class ="add-user-info-container__input" name = "address">
		<input type = "text" placeholder="Enter your phone number" class = "add-user-info-container__input" name = "phone">
		<input type = "text" placeholder="Enter your city" class ="add-user-info-container__input" name = "city">
		<input type = "text" placeholder="Enter your district" class= "add-user-info-container__input" name = "district">
		<input type = "text" placeholder="postal_code" class = "add-user-info-container__input" name= "postal_code">
		<input type = "submit" value = "Add" class = "add-user-info-container__input"/>
	</form>
</div>
<?php include ("layout/footer.php")?>