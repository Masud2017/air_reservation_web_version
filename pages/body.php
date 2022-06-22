<div>
	<?php if (isset($_SESSION["username"])): ?>
		<?php include ("loggedinbody.php") ?>
	<?php else : ?>
		<?php include ("homepage.php") ?>

	<?php endif; ?>

</div>