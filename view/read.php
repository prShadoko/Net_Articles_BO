<?php 
//debug($controller);?>

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
			echo '<td><input type="checkbox" name="ids[]" value="'.$row['id'].'"/></td>';
			foreach ($row as $key => $value) {
				if($key != 'id') {
					//*
					if(strlen($value) > 200) {
						$value = substr($value, 0, 196) . "...";
					}
					//*/
					echo '<td>' . $value . '</td>';
				}
			}
			echo '<td><a href="'.  BootStrap::getRequest()->getURL(null, 'update',Array('id'=>$row['id'])).'">update</a></td>';
			echo '</tr>';
		}

		?>

	</table>
	<div id="control">
		<input type="submit" name="create" value="Créer" >
		<input type="submit" name="delete" value="Supprimer">
		<input type="reset" value="Vider">
	</div>
</form>

<p id="pagination">
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