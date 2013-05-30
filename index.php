<?php
require_once 'tools/debug.php';
require_once 'model/Sessions.php';
require_once 'controller/BootStrap.php';

Sessions::start();

BootStrap::initController();
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		<title><?php echo BootStrap::getController()->getTitle(); ?></title>
	</head>
	<body>

		<?php //require_once 'view/' . BootSrap::getController()->getMenu() . '.php'; ?>
		
		<?php require_once 'view/' . BootStrap::getController()->getView() . '.php'; ?>
		
	</body>
</html>