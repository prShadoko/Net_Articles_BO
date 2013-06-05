<?php 
$requete = BootStrap::getRequest();
$controller = BootStrap::getController();
$article = $controller->getArticle();
$domainList = $controller->getDomainList();
?>
<form action="<?php echo $requete->getURL(null, null, Array('id' => $article->getId())); ?>" method="POST">
	<label>Domaine :</label>
	<select name="idDomain">
		<?php 
		foreach($domainList as $domain) {
			$selected = '';
			if($domain['id_domaine'] == $article->getIdDomain()) {
				$selected = 'SELECTED';
			}
			echo '<option value="'.$domain['id_domaine'].'" '.$selected.'>'.$domain['lib_domaine'].'</option>';
		}
		?>
	</select><br />
	
	<label>Titre :</label>
	<input type="text" name="title" size="50" value="<?php echo $article->getTitle(); ?>"/><br />
	
	<label>Resumé :</label>
	<textarea name="summary" rows="10" size="30" cols="100">
<?php echo $article->getSummary(); ?>
	</textarea> <br />
	
	<label>Prix :</label>
	<input type="number" name="price" size="30" value="<?php echo $article->getPrice(); ?>"/><br />
	
	<label>Date de parution :</label>
	<input type="datetime-local" name="publicationDate" size="30" value="<?php echo $article->getPublicationDate(); ?>"/><br />
	
	<label>Fichier :</label>
	<input type="text" name="file" size="30" value="<?php echo $article->getFile(); ?>"/><br />
	
	<input type="reset" value="Vider" />
	<input type="submit" name="submit" value="Envoyer" />
</form>