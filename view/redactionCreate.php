<?php
$controller = BootStrap::getController();

$rows = $controller->getRows();
$header = Array();
if(!empty($rows)){
	$header = array_keys($rows[0]);
}
$authorList = $controller->getAuthorList();
?>

<h2><?php echo $controller->getArticle()->getTitle(); ?></h2>
<h3>Liste des auteurs :</h3>

<form action="<?php echo BootStrap::getRequest()->getURL(null, 'update', Array('id'=>$controller->getArticle()->getId())); ?>" method="POST">
	<table>
		<tr>
		<?php
		$i = 0;
		foreach($rows as $row) {
			$checked = '';
			//debug($row['id']);debug($authorList);exit;
			if(in_array(Array('id' => $row['id']), $authorList)) {
				$checked = 'CHECKED';
			}

			echo '<td><input type="checkbox" name="authors[]" value="'.$row['id'].'" '.$checked.'/><label for="autors">'.$row['identity'].'</label></td>';

			if(($i+1)%4 == 0){
				echo '</tr><tr>';
			} 
			++$i;
		}
		?>
		</tr>
	</table>
	<div id="control">
		<input type="submit" name="update" value="Continuer" />
	</div>
</form>