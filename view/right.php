<form action="<?php echo BootStrap::getRequest()->getURL(null, "update") ?>" method="POST">
	<table>
		<?php
		$controller = BootStrap::getController();
		$rows = $controller->getRows();
		$header = array_keys($rows[0]);

		echo '<tr>';
		foreach($header as $value) {
			if($value != 'id') {
				echo '<th>'.$value.'</th>';
			}
		}
		echo '</tr>';

		foreach($rows as $row) {
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
	<input type="submit" value="Calcul des droits">
</form>

<p>
	<?php 
	$request = BootStrap::getRequest();
	$length = 5 - 1;
	$page = $controller->getPage();  
	$pageCount = $controller->getPageCount();
	
	$start = $page - floor($length/2);
	if($start > $pageCount - $length){
		$start = $pageCount - $length;
	}
	if($start < 1) {
		$start = 1;
	}
	
	$end = $start + $length;
	if($end > $pageCount) {
		$end = $pageCount;
	}
	
	echo '<a href="'.$request->getURL(null,null,Array('page' => 1)).'"> <<</a> ';
	if($page > 1) {
		echo '<a href="'.$request->getURL(null,null,Array('page' => $page - 1)).'"> <</a> ';
	}
	else {
		echo ' < ';
	}
			
	for($p = $start; $p <= $end; ++$p) {
		if($p == $page) {
			echo $p.' ';
		}
		else {
			echo ' <a href="'.$request->getURL(null,null,Array('page' => $p)).'">'.$p.'</a> ';
		}
	}
	
	if($page < $pageCount) {
		echo '<a href="'.$request->getURL(null,null,Array('page' => $page + 1)).'"> ></a> ';
	}
	else {
		echo ' > ';
	}
	echo '<a href="'.$request->getURL(null,null,Array('page' => $pageCount)).'"> >> </a> ';
	?>
</p>