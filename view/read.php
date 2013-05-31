<?php ?>

<table>
	<?php
	$controller = BootStrap::getController();
	$header = $controller->getHeader();
	$rows = $controller->getRows();
	
	echo '<tr>';
	foreach($header as $value) {
		echo '<th>'.$value.'</th>';
	}
	
	echo '</tr>';
	
	foreach($rows as $row) {
		echo '<tr>';
		foreach ($row as $value) {
			echo '<td>' . $value . '</td>';
		}
		echo '<td><a href="'.  BootStrap::getRequest()->getURL('update',$row[0]).'">update</a></td>';
		echo '<td><a href="'.  BootStrap::getRequest()->getURL('delete',$row[0]).'">delete</a></td>';
		echo '</tr>';
	}
	
	?>
</table>