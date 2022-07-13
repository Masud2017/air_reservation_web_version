<?php include ("util/VariableBucket.php");use Util\VariableBucket ?>
<link rel = "stylesheet" type = "text/css" href= "css/loggedinbody.css">


<div class = "loggedinbody">
	<div class = "loggedinbody__left-side">
		<img src = "<?=$_SESSION["image_url"]?>" class = "loggedinbody__left-side__profile-image"/><br>

		<div>
		<!-- <h3 style ="display: inline">Name : </h3>	 -->
			<h3 style = "display: inline">
				<?php if(isset($_SESSION["name"])): ?>
				<?=$_SESSION["name"]?>
				<?php endif; ?>
			</h3>
		</div>

		<div>
			<h2>User Address info: </h2>
			<br>
			<?php if (isset($_SESSION["variableObj"])): ?>

				<h4>--> Address: <?=$_SESSION["variableObj"]["address"]?> </h4>
				<h4>--> Email: <?=$_SESSION["variableObj"]["email"]?></h4>
				<h4>--> Phone number: <?=$_SESSION["variableObj"]["phone"]?> </h4>
				<h4>--> Postal code : <?=$_SESSION["variableObj"]["postal_code"]?> </h4>
				<h4>--> City : <?=$_SESSION["variableObj"]["city"]?> </h4>
				<h4>--> District : <?=$_SESSION["variableObj"]["district"]?> </h4>
				<a href = "edituser">Edit user info</a>
			<?php else: ?>
				<span>No info available</span>
				<a href = "addaddress">Add Address Info</a>
			<?php endif;?>
		</div>

	</div>
	<div class ="loggedinbody__right-side">
		<!-- <img src = "image/maintanance.png" class = "loggedinbody__right-side__maintanance-image"> -->
		<!-- <h1>This portion is under development</h1> -->
		<div class = "loggedinbody__right-side__card__container">
			<a href = "navigateticket"><div name = "card" class = "loggedinbody__right-side__card__container__card">Navigate tickets</div></a>
			<!-- <div name = "card" class = "loggedinbody__right-side__card__container__card">See schedule</div> -->
			<a href = "orderedticket"><div name = "card" class = "loggedinbody__right-side__card__container__card">My ordered tickets</div></a>
			<a href=  "mywallet"><div name = "card" class = "loggedinbody__right-side__card__container__card">My wallet</div></a>
		</div>

		<br/><u><h1>Transaction history</h1></u><br/>

		<div class = "loggedinbody__right-side__history-card-container">
			<div class = "loggedinbody__right-side__history-card-container__card">
				<div>History string</div>
				<div>Date: <?php echo date("d:m:y-h:i:s") ?></div>
				<div>BDT 5</div>
				<div>Done/cancelled</div>
				<div style = "background-color : white;border-radius: 50%; width : 30px; height : 30px;display : flex;justify-content:center;align-items:center;cursor:pointer">X</div>

			</div>
		</div>

	</div>

</div>