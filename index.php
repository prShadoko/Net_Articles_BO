<?php
require_once 'tools/debug.php';
require_once 'model/Sessions.php';
require_once 'controller/BootStrap.php';

Sessions::start();

$controller = BootStrap::getController();
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		<title><?php echo $controller->getTitle(); ?></title>
	</head>
	<body>
		<h1><?php echo $controller->getTitle(); ?></h1>
		
		<?php //require_once 'view/' . BootSrap::getController()->getMenu() . '.php'; ?>
		
		<article>
		<?php require_once 'view/' .$controller->getView() . '.php'; ?>
		</article>
	</body>
</html>