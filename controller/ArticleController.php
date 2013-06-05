<?php
require_once 'CRUDController.php';
require_once 'model/Article.php';
require_once 'model/Domain.php';

class ArticleController extends CRUDController {

	private $_article;
	private $_domainList;
	
	protected function defineRows() {
		
		$rows = Article::readableArticleList();
		
		$this->setRows($rows);
	}

	protected function initFormValues() {
		$this->setView("article");
		
		$this->_article = new Article();
		
		$this->_domainList = Domain::getDomainList();
	}
	
	protected function create(){
		$this->initFormValues();
	}
	
	protected function update($id) {
		try {
			$params = BootStrap::getRequest()->getParameters();

			$this->initFormValues();

			if (isset($params['submit'])) { // the form has been submited.
				$this->_article->affectValue($params);
				$this->_article->updateDB();
			}
			else {
				$this->_article->read($id);
			}
		} catch (PDOException $ex) {
			debug($ex->getMessage());
			//TODO: mieux géré les pb de BD
		}
	}	
	
	
	
	public function getArticle() {
		return $this->_article;
	}
	
	public function getDomainList() {
		return $this->_domainList;
	}
}

?>
