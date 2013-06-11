<?php 
$requete = BootStrap::getRequest();
$controller = BootStrap::getController();

$urlParam = Array();
if(!is_null($controller->getDataId())) {
	$urlParam['id'] = $controller->getDataId();
}
?>
<form action="<?php echo $requete->getURL(null, null, $urlParam); ?>" method="POST">
	
	<?php 
	require_once $controller->getForm().'.php';
	?>
	
	<input type="reset" value="Vider" />
	<input type="submit" name="submit" value="Envoyer" />
</form>

