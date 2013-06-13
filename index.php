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
		<link rel="stylesheet" href="view/Styles.css">
		<title><?php echo $controller->getTitle(); ?></title>
	</head>
	<body>
		<h1><?php echo $controller->getTitle(); ?></h1>
		
		<?php require_once 'view/' . $controller->getMenu() . '.php'; ?>
		
		<article>
		<?php require_once 'view/' .$controller->getView() . '.php'; ?>
		</article>
		
		<?php
		$messages = BootStrap::getController()->getUserMessages();
		$typeMessage = 'message';
		if($controller->isAnErrorMessage()) {
			$typeMessage = 'erreur';
		}
		
		if(!is_null($messages)) {
			echo '<p><ul id="'.$typeMessage.'">';
			foreach ($messages as $m) {
				echo '<li>'.$m.'</li>';
			}
			echo '</ul></p>';
		}
		?>
	</body>
</html>