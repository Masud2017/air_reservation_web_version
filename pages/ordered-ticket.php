<link rel = "stylesheet" type = "text/css" href= "css/loggedinbody.css">
<link rel = "stylesheet" type = "text/css" href= "css/walletpage.css">


<?php include("layout/header.php") ?>
<div class = "loggedinbody">
	<div class = "loggedinbody__left-side">
		<img src = "<?=$_SESSION["image_url"]?>" class = "loggedinbody__left-side__profile-image"/>
		<h1 style ="display: inline">Name : </h1><h2 style = "display: inline">
			<?php if(isset($_SESSION["name"])): ?>
			<?=$_SESSION["name"]?>
			<?php endif; ?>
		</h2>
		<h2>User Address info: </h2>
		<?php if (isset($_SESSION["variableObj"])): ?>

			<h4>Address: <?=$_SESSION["variableObj"]["address"]?> </h4>
			<h4>Email: <?=$_SESSION["variableObj"]["email"]?></h4>
			<h4>Phone number: <?=$_SESSION["variableObj"]["phone"]?> </h4>
			<h4>Postal code : <?=$_SESSION["variableObj"]["postal_code"]?> </h4>
			<h4>City : <?=$_SESSION["variableObj"]["city"]?> </h4>
			<h4>District : <?=$_SESSION["variableObj"]["district"]?> </h4>
			<a href = "edituser">Edit user info</a>
		<?php else: ?>
			<span>No info available</span>
			<a href = "addaddress">Add Address Info</a>
		<?php endif;?>

	</div>
	<div class ="ordered-ticket__right-side">
		This is ordered ticket list view
            
	</div>

</div>
<?php include("layout/footer.php") ?>
