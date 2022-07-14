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
			<a href = "fetchorderedticket"><div name = "card" class = "loggedinbody__right-side__card__container__card">My ordered tickets</div></a>
			<a href=  "fetchwalletinfo"><div name = "card" class = "loggedinbody__right-side__card__container__card">My wallet</div></a>
		</div>

		<br/><u><h1>Transaction history</h1></u><br/>

		<div class = "loggedinbody__right-side__history-card-container">
			<?php $history = $_SESSION["history"] ?>
			<?php foreach($history as $item):?>

				<div class = "loggedinbody__right-side__history-card-container__card">
					<div><span><?=$item['destination'] ?></span></div>
					<div><span>QTY <?=$item['qty'] ?> X <?=$item['price'] ?> BDT </span></div>
					<?php if($item['cancelled']): ?>
						<div><span>Cancelled</span></div>
					<?php else: ?>
						<div><span>Done</span></div>
						
					<?php endif; ?>
					<div><span>BDT <?=$item['total'] ?></span></div>
				</div>
			<?php endforeach;?>
		</div>

	</div>

</div>