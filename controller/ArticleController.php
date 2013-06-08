<?php

require_once 'CRUDController.php';
require_once 'model/Article.php';
require_once 'model/Domain.php';

class ArticleController extends CRUDController {

	private $_article;
	private $_domainList;
	//private $_userMessages;
	//private $_isValid;

	public static $length = 6;

	protected function defineRows() {

		$page = $this->getPage();

		$start = ($page - 1) * self::$length;

		$rows = Article::readableList($start, self::$length);

		return $rows;
	}

	protected function definePageCount() {

		$pageCount = ceil(Article::getArticleCount() / self::$length);
		/* if($page > $pageCount) {
		  $page = $pageCount;
		  } */

		return $pageCount;
	}

	/* protected function init() {
	  $this->setView("article");

	  $this->_article = new Article();

	  $this->_domainList = Domain::getDomainList();
	  } */

	/* protected function create(){
	  $params = BootStrap::getRequest()->getParameters();

	  $this->init();

	  if (isset($params['submit']) ) { // the form has been submited.

	  $this->formValidation();

	  if($this->_isValid) {
	  $this->_article->updateDB();
	  header('location: '.BootStrap::getRequest()->getURL(null, 'read')); //TODO: gérer la creation dans la classe mère, faire une fct pour gerer le model, une autre pour mettre a jour la BDD, une autre pour le message client et pour créer les validateurs
	  }
	  else {
	  $this->_userMessages = $validator->getErrors();
	  }
	  }
	  }

	  protected function update($id) {

	  $params = BootStrap::getRequest()->getParameters();

	  $this->init();

	  if (isset($params['submit']) ) { // the form has been submited.

	  $this->formValidation();

	  if($this->_isValid) {
	  $this->_article->updateDB();
	  $this->_userMessages[] = 'L\'article a correctement été enregistré.';
	  }
	  else {
	  $this->_userMessages = $validator->getErrors();
	  }
	  }
	  else {
	  $this->_article->read($id);
	  }

	  } */

	public function formValidation() {
		$validator = $this->createValidator();
		$this->_article->affectValue($params);
		$this->_isValid = $validator->validate($params);
	}

	public function createValidator() {
		$validator = new FormValidator();

		$validator->addValidator('price', 'number', 'Le prix doit être un nombre.');
		$validator->addValidator('publicationDate', 'date', 'La date de parution doit être une date valide de la forme YYYY-mm-dd.');

		return $validator;
	}

	/* public function addError($error) {
	  if(!is_null($error)) {
	  $this
	  }
	  } */

	/* public function isValidForm() {
	  return $this->_isValid;
	  } */

	public function getArticle() {
		return $this->_article;
	}

	public function getDomainList() {
		return $this->_domainList;
	}

	protected function getUserConfirmationMessage() {
		return 'L\'article a correctement été enregistré.';
	}

	protected function initModel() {
		
		$this->_article = new Article();

		$this->_domainList = Domain::getDomainList();
	}

	protected function updateDB() {
		$this->_article->updateDB();
	}

	protected function updateModelById($id) {
		$this->_article->read($id);
	}
	
	protected function updateModelByRequest($params) {
		$this->_article->affectValue($params);
	}

	protected function defineDeletedRows($ids) {
		return $rows = Article::titleAndDateList($ids);
	}

	protected function deleteRows($ids) {
		Article::delete($ids);
	}

	/* public function getUserMessages() {
	  return $this->_userMessages;
	  } */


	/* public function setError($error) {
	  $this->_error = $error;
	  } */
}

?>
