<?php
$controller = BootStrap::getController();
$header = $controller->getHeader();
$rows = $controller->getRows();
$confirm = $controller->isConfirmForm();
?>

<h2>
	<?php if($confirm) {
            if($controller->getName()=="author") {
                echo "Etes vous sur de vouloir supprimer cet auteur ? Les articles écris par cet auteur seront aussi supprimées.";
            }
            else
		echo 'Etes vous sur de vouloir supprimer ces données ?';
	}
	else {
		echo 'Les données ont été supprimées'; 
	}?>
</h2>

<form action="<?php echo BootStrap::getRequest()->getURL(); ?>" method="POST">
	<table>
		<tr>
			<?php 
			foreach($header as $value) {
				//if($value != 'id') {
					echo '<th>'.$value.'</th>';
				//}
			}
			?>
		</tr>
		<?php
			foreach($rows as $row) {
				echo '<tr>';
				//echo '<td><input type="text" name="ids[]" value="'.$row['id'].'" disabled/></td>';
				foreach ($row as $key => $value) {
				//	if($key != 'id') {
						echo '<td>' . $value . '</td>';
				//	}
				}
				echo '</tr>';
			}
		?>
	</table>
	<?php
			
		foreach($rows as $row) {
			echo '<input type="hidden" name="ids[]" value="'.$row['id'].'" />';
		}
		
		if($confirm){
			echo '<input type="submit" name="yes" value="Oui" />';
			echo '<input type="submit" name="return" value="Non" />';
		}
		else {
			echo '<input type="submit" name="return" value="Retour" />';
		}
	?>
</form>