<?php
require_once 'CRUDController.php';
require_once 'model/Article.php';

class ArticleController extends CRUDController {

	protected function defineRows() {
		
		$rows = Article::readableArticleList();
		
		$this->setRows($rows);
	}	
}

?>
