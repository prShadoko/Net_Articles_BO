
<ul>
	<?php 
	$errors = BootStrap::getController()->getErrors();
	foreach ($errors as $err) {
		echo '<li>'.$err.'</li>';
	}
	?>
</ul>
