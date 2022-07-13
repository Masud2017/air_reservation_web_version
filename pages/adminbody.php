<?php include ("util/VariableBucket.php");use Util\VariableBucket ?>
<link rel = "stylesheet" type = "text/css" href= "css/loggedinbody.css">
<link rel = "stylesheet" type = "text/css" href= "css/navigate-tickets.css">
<link rel = "stylesheet" type = "text/css" href= "css/adminbody.css">




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
	<div class ="navigate-ticket__right-side">
		<!-- <img src = "image/maintanance.png" class = "loggedinbody__right-side__maintanance-image"> -->
		<!-- <h1>This portion is under development</h1> -->
        <br><a class = "adminbody__add-ticket-btn" href="addticket">Add new ticket</a><br>
		<br><h1>Ticket list</h1><br>

        <div class = "navigate-ticket__right-side__ticket-card-container">
            
            <?php foreach($_SESSION["ticketList"] as $item): ?>
                <div class = "navigate-ticket__right-side__ticket-card-container__body"><span><?=$item["destination"] ?></span> <span>BDT <?=$item["price"] ?></span></div>
            <?php endforeach;?>
			
	

		</div>


		

	</div>

</div>