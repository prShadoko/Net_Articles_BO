<?php ?>

<form action="<?php echo BootStrap::getRequest()->getURL(null, "delete") ?>" method="POST">
	<table>
		<?php
		$controller = BootStrap::getController();
		$header = $controller->getHeader();
		$rows = $controller->getRows();

		echo '<tr>';
		echo '<th></th>';
		foreach($header as $value) {
			if($value != 'id') {
				echo '<th>'.$value.'</th>';
			}
		}
		echo '</tr>';

		foreach($rows as $row) {
			echo '<tr>';
			echo '<td><input type="checkbox" name="id[]" value="'.$row['id'].'"/></td>';
			foreach ($row as $key => $value) {
				if($key != 'id') {
					echo '<td>' . $value . '</td>';
				}
			}
			echo '<td><a href="'.  BootStrap::getRequest()->getURL(null, 'update',Array('id'=>$row['id'])).'">update</a></td>';
			echo '</tr>';
		}

		?>

	</table>
	<a href="<?php echo BootStrap::getRequest()->getURL(null, 'create'); ?>"><input type="button" value="Créer" ></a>
	<input type="submit" value="Supprimer">
	<input type="reset" value="Vider">
</form>