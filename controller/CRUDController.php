<?php

require_once 'Controller.php';

abstract class CRUDController extends Controller {
	
	private $_rows;
	
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
			
			case 'read':
				$this->defineRows();
				break;
			
			default:
				$this->setView('read');
				$this->defineRows();
				break;
		}
	}
	
	public function getHeader() {
		return array_keys($this->_rows[0]);
	}
	
	protected abstract function defineRows();
	
	protected abstract function create();
	
	protected abstract function update($id);
	
	protected function setRows($rows) {
		$this->_rows = $rows;
	}
	
	public function getRows() {
		return $this->_rows;
	}
}

?>
