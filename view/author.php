<?php 
$controller = BootStrap::getController();
$auteur = $controller->getAuteur();
?>

<label for="identity">Identité :</label>
<input type="text" name="identity" size="50" value="<?php echo $auteur->getIdentity(); ?>"/><br />

<label for="address">Adresse :</label>
<input type="text" name="address" size="50" value="<?php echo $auteur->getAddress(); ?>"/><br />

<label for="login">Login :</label>
<input type="text" name="login" size="50" value="<?php echo $auteur->getLogin(); ?>"/><br />

<label for="pwd">Mot de passe :</label>
<input type="password" name="pwd" size="50" value="<?php echo $auteur->getPwd(); ?>"/><br />
