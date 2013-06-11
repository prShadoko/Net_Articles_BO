<?php
$controller = BootStrap::getController();
$rows = $controller->getRows();
$authorList = $controller->getAuthorList();
$ids = Array();

?>
<form action="<?php echo BootStrap::getRequest()->getURL(null, 'update', Array('id'=>$controller->getArticle())); ?>" method="POST" >
	<table>
	<?php 
		foreach($rows as $row) {
			$ids[] = $row['id'];
			echo '<tr>';
			echo '<td>';
			echo '<label>';
			echo '<input type="hidden" name="authors[]" value="'.$row['id'].'" />';
			echo $row['author'];
			echo '</label></td><td>';
			echo '<input type="text" name="parts[]" value="'.$row['part'].'" />';
			echo '</td>';
			echo '</tr>';
		}
		foreach($authorList as $row) {
			if(!in_array($row['id'], $ids)) {
				echo '<tr>';
				echo '<td>';
				echo '<label>';
				echo '<input type="hidden" name="authors[]" value="'.$row['id'].'" />';
				echo $row['identity'];
				echo '</label></td><td>';
				echo '<input type="text" name="parts[]" value="" />';
				echo '</td>';
				echo '</tr>';
			}
		}
	?>
	</table>
	<input type="submit" name="validate" value="Valider" />
	<input type="submit" name="create" value="Retour" />
</form>