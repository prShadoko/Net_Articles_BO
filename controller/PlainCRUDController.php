<?php
require_once 'CRUDController.php';
require_once 'FormValidator.php';

abstract class PlainCRUDController extends CRUDController {

	private $_rows;
	private $_page;
	private $_pageCount;
	private $_isValid;
	//private $_userMessages;
	private $_form;
	
	public static $length = 6;

	

	protected function read() {
		
		$this->_pageCount = $this->definePageCount();
		$this->initPagination();

		$this->_rows = $this->defineRows(($this->getPage() - 1) * self::$length, self::$length);
	}

	protected function create() {
		$this->setView('form');
		$this->setForm($this->getName());
		
		$params = BootStrap::getRequest()->getParameters();

		$this->initModel();

		if (isset($params['submit'])) { // the form has been submited.
			$this->formSubmission($params);
		}
	}

	protected function update() {
		$this->setView('form');
		$this->setForm($this->getName());

		$request = BootStrap::getRequest();
		$params = $request->getParameters();
		if (!isset($params['id'])) {
			throw new InvalidArgumentException('L\'id n\'est pas définie');
		}
		$id = $params['id'];
		$this->initModel();

		if (isset($params['submit'])) { 
			$this->formSubmission($params);
		} else {
			$this->updateModelById($id);
		}
	}
	
	protected function delete() {
		
		$request = BootStrap::getRequest();
		$params = $request->getParameters();
		
		if(isset($params['create'])) {
			header('location: '. $request->getURL(null, 'create'));
			exit;
		}
		
		if(!isset($params['ids'])) {
			header('location: '. $request->getURL(null, 'read'));
			exit;
		}
		//$this->setView('delete');
		
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

	protected abstract function defineRows($start, $length);

	protected abstract function definePageCount();

	protected abstract function updateDB();

	protected abstract function updateModelById($id);

	protected abstract function updateModelByRequest($params);

	protected abstract function initModel();

	protected abstract function createValidator();
	
	protected abstract function defineDeletedRows($ids);
	
	protected abstract function deleteRows($ids);
	
	protected abstract function getDataId();

	private function formSubmission($params) {
		$this->updateModelByRequest($params);

		$validator = $this->createValidator();
		$this->_isValid = $validator->validate($params);

		if ($this->_isValid) {
			//$this->_article->updateDB();
			$this->updateDB();
			//$this->_userMessages[] = 'L\'article a correctement été enregistré.';
			$this->addUserMessages($validator->getConfirmMessage());
			$this->isAnErrorMessage(false);
		} else {
			$this->setUserMessages( $validator->getErrors() );
			$this->isAnErrorMessage(true);
		}
	}

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

	/*public function getUserMessages() {
		return $this->_userMessages;
	}*/

	public function getHeader() {
		return array_keys($this->_rows[0]);
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

	public function getForm() {
		return $this->_form;
	}
	
	public function setForm($form) {
		$this->_form = $form;
	}
}

?>
