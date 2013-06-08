<?php

class FormValidator {

	private $_validators;
	private $_errors;
	private $_isValid;

	public function __construct() {
		$this->_validators = Array();
		$this->_isValid = false;
	}

	public function addValidator($name, $validator, $message) {
		$this->_validators[$name][] = Array('type' => $validator, 'message' => $message);
	}

	public function validate($values) {

		$this->_isValid = true;

		foreach ($this->_validators as $name => $validators) {
			foreach ($validators as $validator) {
				
				if(!isset($values[$name])){
					$this->_isValid = false;
					$this->addError('"'.$name.'" n\'est pas définie.');
				}
				else {
					switch($validator['type']){
						case 'number':
							if(!$this->isNumber($values[$name])) {
								$this->_isValid = false;
								$this->addError($validator['message']);
							}
							break;
						case 'date':
							if(!$this->isDate($values[$name])) {
								$this->_isValid = false;
								$this->addError($validator['message']);
							}
							break;
					}
				}
			}
		}
		
		return $this->_isValid;
	}

	public function isNumber($var) {
		
		return is_numeric($var);
	}
	
	public function isDate($var) {
		
		$pattern = '/^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$/';
		return preg_match($pattern, $var);
	}
	
	public function addError($error) {
		$this->_errors[] = $error;
	}
	
	public function getErrors() {
		return $this->_errors;
	}
	
	public function isValid() {
		return $this->_isValid;
	}
}

?>
