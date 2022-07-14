<link rel = "stylesheet" type = "text/css" href= "css/loggedinbody.css">
<?php include ("layout/header.php")?>


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
		

		<br/><u><h1>My active tickets</h1></u><br/>

		<div class = "loggedinbody__right-side__history-card-container">
            <?php $orderedTickets = $_SESSION["orderedTicketList"]?>

			<?php foreach($orderedTickets as $item):?>

                <div class = "loggedinbody__right-side__history-card-container__card">
				<div><span><?=$item["destination"] ?></span></div>
				<div>QTY <span><?=$item["quantity"] ?></span></div>
				<!-- <div>BDT <span><?=$item["price"] ?></span></div> -->
                <a href = "<?php echo 'confirmorder?ticket_id='.$item["id"] ?>" >Done</a>
                <a href = "<?php echo 'cancelorder?ticket_id='.$item["id"] ?>">Cancell</a>


			</div>
            <?php endforeach;?>
		</div>

	</div>

</div>

<?php include ("layout/footer.php")?>
