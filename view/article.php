<?php 
$controller = BootStrap::getController();
$auteur = $controller->getArticle();
$domainList = $controller->getDomainList();
?>
<label>Domaine :</label>
<select name="idDomain">
	<?php 
	foreach($domainList as $domain) {
		$selected = '';
		if($domain['id_domaine'] == $auteur->getIdDomain()) {
			$selected = 'SELECTED';
		}
		echo '<option value="'.$domain['id_domaine'].'" '.$selected.'>'.$domain['lib_domaine'].'</option>';
	}
	?>
</select><br />

<label>Titre :</label>
<input type="text" name="title" size="50" value="<?php echo $auteur->getTitle(); ?>"/><br />

<label>Resumé :</label>
<textarea name="summary" rows="10" size="30" cols="100">
<?php echo $auteur->getSummary(); ?>
</textarea> <br />

<label>Prix :</label>
<input type="number" name="price" size="30" value="<?php echo $auteur->getPrice(); ?>"/><br />

<label>Date de parution :</label>
<input type="datetime-local" name="publicationDate" size="30" value="<?php echo $auteur->getPublicationDate(); ?>"/><br />

<label>Fichier :</label>
<input type="text" name="file" size="30" value="<?php echo $auteur->getFile(); ?>"/><br />
