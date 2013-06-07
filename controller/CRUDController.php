<?php

require_once 'Controller.php';
require_once 'FormValidator.php';

abstract class CRUDController extends Controller {
	
	private $_rows;
	private $_page;
	private $_pageCount;
	
	public function run($action) {
		
		$this->setView($action);
		switch ($action) {
			case 'create':
				$this->create();
				break;
			
			case 'update':
				$request = BootStrap::getRequest();
				$parameters = $request->getParameters();
				if(!isset($parameters['id'])) {
					throw new InvalidArgumentException('L\'id n\'est pas définie');
				}
				$this->update($parameters['id']);
				break;
			
			case 'delete':
				debug(BootStrap::getRequest()->getParameters());exit;
				break;
			
			default:
				$this->setView('read');
				
			case 'read':
				$this->_pageCount = $this->definePageCount();
				$this->initPagination();
				$this->_rows = $this->defineRows();
				break;
		}
	}
	
	public function getHeader() {
		return array_keys($this->_rows[0]);
	}
	
	protected abstract function defineRows();
	protected abstract function definePageCount();
	
	protected abstract function create();
	
	protected abstract function update($id);
	
	public function initPagination() {
		
		$this->_page = BootStrap::getRequest()->getPage();
		
		if($this->_page > $this->_pageCount) {
			$this->_page = $this->_pageCount;
		}
	}
	
	protected function setRows($rows) {
		$this->_rows = $rows;
	}
	
	public function getRows() {
		return $this->_rows;
	}
	
	public function getPageCount(){
		return $this->_pageCount;
	}
	
	public function setPageCount($pageCount){
		$this->_pageCount = $pageCount;
	}
	
	public function getPage(){
		return $this->_page;
	}
	
	public function setPage($page){
		$this->_page = $page;
	}
}

?>
