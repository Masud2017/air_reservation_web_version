<div>
	<?php if (isset($_SESSION["username"])): ?>
		<?php if ($_SESSION["role"] == "user"):?>
			<?php include ("loggedinbody.php") ?>
		<?php else:?>
			<?php include ("adminbody.php")?>
		<?php endif;?>
	<?php else : ?>
		<?php include ("homepage.php") ?>

	<?php endif; ?>

</div>