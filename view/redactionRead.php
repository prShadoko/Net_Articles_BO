<?php
$controller = BootStrap::getController();
$rows = $controller->getRows();

$header = Array();
$btnUpdate = "Mise à jour";
if(!empty($rows)){
	$header = array_keys($rows[0]);
}
else {
	$btnUpdate = "Créer";
}
?>

<form action="<?php echo BootStrap::getRequest()->getURL(null,null) ?>" method="POST" id="control">
	<select name="id">
		<?php
		foreach ($controller->getArticleList() as $article) {
			$selected = '';
			if($article['id'] == $controller->getArticle()){
				$selected = 'SELECTED';
			}
			echo '<option value='.$article['id'].' '.$selected.'>'.$article['title'].'</option>';
		}
		?>
	</select>
	<input type="submit" name="refresh" value="Rafraichir"/>
	<input type="submit" name="update" value="<?php echo $btnUpdate; ?>"/>
</form>
<table>
	<tr>
	<?php
	//if(isset($rows)){
		foreach($header as $value) {
			if($value != 'id') {
				echo '<th>'.$value.'</th>';
			}
		}
	//}
	?>
	</tr>
	<?php
	foreach($controller->getRows() as $row) {
		echo '<tr>';
		foreach ($row as $key => $value) {
			if($key != 'id') {
				echo '<td>' . $value . '</td>';
			}
		}
		echo '</tr>';
	}
	?>
</table>