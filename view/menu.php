<?php 
	$name = BootStrap::getController()->getName();;
?>
<nav>
	<ul>
		<li><a <?php if($name == 'article') echo 'id="selected"'; ?>  href="<?php echo BootStrap::getRequest()->getURL('article', 'read'); ?>">Gestion des articles</a></li>
		<li><a <?php if($name == 'author') echo 'id="selected"'; ?> href="<?php echo BootStrap::getRequest()->getURL('author', 'read'); ?>">Gestion des auteurs</a></li>
		<li><a <?php if($name == 'redaction') echo 'id="selected"'; ?> href="<?php echo BootStrap::getRequest()->getURL('redaction', 'read'); ?>">Gestion des parts</a></li>
		<li><a <?php if($name == 'right') echo 'id="selected"'; ?> href="<?php echo BootStrap::getRequest()->getURL('right', 'read'); ?>">Droits des auteurs</a></li>
	</ul>
</nav>
