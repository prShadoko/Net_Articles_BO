<?php

require_once 'Controller.php';

abstract class CRUDController extends Controller {
	
	private $_header;
	private $_rows;
	
	public function run($action) {
		$this->setView($action);
		switch ($action) {
			case 'create':
				
				break;
			
			case 'update':
				
				break;
			
			case 'delete':
				debug(BootStrap::getRequest()->getParameters());exit;
				break;
			
			case 'read':
				$this->defineHeader();
				$this->defineRows();
				break;
			
			default:
				$this->setView('read');
				$this->defineHeader();
				$this->defineRows();
				break;
		}
	}
	
	protected abstract function defineHeader();
	
	protected function setHeader($header) {
		$this->_header = $header;
	}
	
	public function getHeader() {
		return $this->_header;
	}
	
	protected abstract function defineRows();
	
	protected function setRows($rows) {
		$this->_rows = $rows;
	}
	
	public function getRows() {
		return $this->_rows;
	}
}

?>
