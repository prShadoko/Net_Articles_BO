<?php

require_once 'Controller.php';
require_once 'FormValidator.php';

abstract class CRUDController extends Controller {

	private $_rows;
	private $_page;
	private $_pageCount;
	private $_isValid;
	private $_userMessages;

	public function run($action) {

		switch ($action) {
			case 'create':
				$this->create();
				break;

			case 'update':
				/* $request = BootStrap::getRequest();
				  $parameters = $request->getParameters();
				  if(!isset($parameters['id'])) {
				  throw new InvalidArgumentException('L\'id n\'est pas définie');
				  } */
				$this->update(/* $parameters['id'] */);
				break;

			case 'delete':
				$this->delete();
				break;

			case 'read':
				/*$this->setView($action);
				$this->_pageCount = $this->definePageCount();
				$this->initPagination();
				$this->_rows = $this->defineRows();*/
				$this->read();
				break;
			
			default:
				$this->read();
				break;
		}
	}

	public function getHeader() {
		return array_keys($this->_rows[0]);
	}

	protected function read() {
		
		$this->setView('read');
		$this->_pageCount = $this->definePageCount();
		$this->initPagination();
		$this->_rows = $this->defineRows();
	}

	protected function create() {
		$params = BootStrap::getRequest()->getParameters();

		//$this->init();
		$this->initModel();

		if (isset($params['submit'])) { // the form has been submited.
			$this->formSubmission($params);
			/*$this->formValidation();

			if ($this->_isValid) {
				$this->_article->updateDB();
				header('location: ' . BootStrap::getRequest()->getURL(null, 'read')); //TODO: gérer la creation dans la classe mère, faire une fct pour gerer le model, une autre pour mettre a jour la BDD, une autre pour le message client et pour créer les validateurs
			} else {
				$this->_userMessages = $validator->getErrors();
			}*/
		}
	}

	protected function update() {

		$request = BootStrap::getRequest();
		$params = $request->getParameters();
		if (!isset($params['id'])) {
			throw new InvalidArgumentException('L\'id n\'est pas définie');
		}
		$id = $params['id'];
		//$this->setView($this->g);
		//$this->_article = new Article();
		//$this->_domainList = Domain::getDomainList();
		$this->initModel();

		if (isset($params['submit'])) { // the form has been submited.
			/*//$this->formValidation();
			//$this->_article->affectValue($params);
			$this->updateModelByRequest($params);

			$validator = $this->createValidator();
			$this->_isValid = $validator->validate($params);

			if ($this->_isValid) {
				//$this->_article->updateDB();
				$this->updateDB();
				//$this->_userMessages[] = 'L\'article a correctement été enregistré.';
				$this->_userMessages[] = $this->getUserConfirmationMessage();
			} else {
				$this->_userMessages = $validator->getErrors();
			}*/
			$this->formSubmission($params);
		} else {
			$this->updateModelById($id);
			//$this->_article->read($id);
		}
	}
	
	protected function delete() {
		$this->setView('delete');
		$request = BootStrap::getRequest();
		$params = $request->getParameters();
		
		if (!isset($params['ids'])) {
			throw new InvalidArgumentException('Aucun élément n\'a été selectionné.');
		}
		$this->_rows = $this->defineDeletedRows($params['ids']);
		
		if(isset($params['yes'])){
			$this->deleteRows($params['ids']);
		}
		else if(isset($params['return'])){
			header('location: '.$request->getURL(null, 'read'));
		}

	}

	private function formSubmission($params) {
		$this->updateModelByRequest($params);

		$validator = $this->createValidator();
		$this->_isValid = $validator->validate($params);

		if ($this->_isValid) {
			//$this->_article->updateDB();
			$this->updateDB();
			//$this->_userMessages[] = 'L\'article a correctement été enregistré.';
			$this->_userMessages[] = $this->getUserConfirmationMessage();
		} else {
			$this->_userMessages = $validator->getErrors();
		}
	}

	protected abstract function defineRows();

	protected abstract function definePageCount();

	/* protected abstract function create();

	  protected abstract function update($id); */

	protected abstract function updateDB();

	protected abstract function updateModelById($id);

	protected abstract function updateModelByRequest($params);

	protected abstract function initModel();

	protected abstract function getUserConfirmationMessage();

	protected abstract function createValidator();
	
	protected abstract function defineDeletedRows($ids);
	
	protected abstract function deleteRows($ids);

	public function isConfirmForm() {
		$params = BootStrap::getRequest()->getParameters();
		return ! isset($params['yes']);
	}
			
	public function initPagination() {

		$this->_page = BootStrap::getRequest()->getPage();

		if ($this->_page > $this->_pageCount) {
			$this->_page = $this->_pageCount;
		}
	}

	public function isValidForm() {
		return $this->_isValid;
	}

	public function getUserMessages() {
		return $this->_userMessages;
	}

	protected function setRows($rows) {
		$this->_rows = $rows;
	}

	public function getRows() {
		return $this->_rows;
	}

	public function getPageCount() {
		return $this->_pageCount;
	}

	public function setPageCount($pageCount) {
		$this->_pageCount = $pageCount;
	}

	public function getPage() {
		return $this->_page;
	}

	public function setPage($page) {
		$this->_page = $page;
	}

}

?>
