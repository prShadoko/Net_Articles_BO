<?php
require_once 'CRUDController.php';

class ArticleController extends CRUDController {
	
	protected function defineHeader() {
		$header = Array('A', 'Grou', 'Grou', 'Je', 'suis', 'méchant', '!!');
		$this->setHeader($header);
	}

	protected function defineRows() {
		
		$rows = Array();
		
		for($i = 0; $i < 7; ++$i) {
			$row = Array();
			for($j = 0; $j < 7; ++$j) {
				$row[] = $i*$j+$i+1;
			}
			$rows[] = $row;
		}
		
		$this->setRows($rows);
	}	
}

?>
