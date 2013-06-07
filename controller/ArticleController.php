<?php
require_once 'CRUDController.php';
require_once 'model/Article.php';
require_once 'model/Domain.php';

class ArticleController extends CRUDController {

	private $_article;
	private $_domainList;
	private $_errors;
	
	public static $length = 6;
	
	protected function defineRows() {
		
		$page = $this->getPage();
		
		
		$start = ($page-1) * self::$length;
		
		$rows = Article::readableArticleList($start, self::$length);
		
		return $rows;
	}
	
	protected function definePageCount() {
		
		$pageCount = ceil( Article::getArticleCount() / self::$length );
		/*if($page > $pageCount) {
			$page = $pageCount;
		}*/
		
		return $pageCount;
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
		
		$params = BootStrap::getRequest()->getParameters();

		$this->initFormValues();

		$validator = $this->createValidator();

		if (isset($params['submit']) ) { // the form has been submited.
			$this->_article->affectValue($params);
			if($validator->validate($params)) {
				//$this->_article->affectValue($params);
				$this->_article->updateDB();
			}
			else {
				$this->_errors = $validator->getErrors();
			}
		}
		else {
			$this->_article->read($id);
		}
		
	}	
	
	public function createValidator() {
		$validator = new FormValidator();
		
		$validator->addValidator('price', 'number', 'Le prix doit être un nombre.');
		$validator->addValidator('publicationDate', 'date', 'La date de parution doit être une date valide de la forme YYYY-mm-dd.');
		
		return $validator;
	}
	
	/*public function addError($error) {
		if(!is_null($error)) {
			$this
		}
	}*/
	
	public function isValidForm() {
		return ! isset($this->_errors);
	}
	
	public function getArticle() {
		return $this->_article;
	}
	
	public function getDomainList() {
		return $this->_domainList;
	}
	
	public function getErrors() {
		return $this->_errors;
	}
	
	
	/*public function setError($error) {
		$this->_error = $error;
	}*/
}

?>
