<?php
require_once 'Controller.php';

abstract class CRUDController extends Controller {
	
	public function run($action) {

		$this->setView($action);
		
		switch ($action) {
			case 'create':
				$this->create();
				break;

			case 'update':
				$this->update();
				break;

			case 'delete':
				$this->delete();
				break;

			case 'read':
				$this->read();
				break;
			
			default:
				$action = 'read';
				$this->setView($action);
				$this->read();
				break;
		}
	}
	
	protected abstract function create();
	protected abstract function read();
	protected abstract function update();
	protected abstract function delete();
}

?>
