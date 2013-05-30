<?php
require_once 'controller/Controller.php';

class ErrorController extends Controller {
	
	private $_message;
	private $_error;
	
	public function run($action) {
		switch($action) {
			case 404:
				$this->setMessage('Error 404 - Page not found');
				$this->setError(Sessions::getError());
				Sessions::unsetError();
				break;
		}
	}
	
	public function setMessage($message) {
		$this->_message = $message;
	}
	
	public function getMessage() {
		return $this->_message;
	}
	
	public function setError($error) {
		$this->_error = $error;
	}
	
	public function getError() {
		if(isset($this->_error)) {
			return $this->_error->__toString();
		}
		
		return "";
	}
}

?>
