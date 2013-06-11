<?php

class FormValidator {

	private $_validators;
	private $_errors;
	private $_isValid;
	private $_confirmMessage;

	public function __construct() {
		$this->_validators = Array();
		$this->_isValid = false;
	}

	public function addValidator($name, $validator, $message, $param = null) {
		$this->_validators[$name][] = Array('type' => $validator, 'message' => $message, 'param' => $param);
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
						case 'minimum length':
							if($this->isLower($values[$name], $validator['param'])) {
								$this->_isValid = false;
								$this->addError($validator['message']);
							}
							break;
						case 'different':
							if(!$this->isDifferent($values[$name], $values[$validator['param']])) {
								
								$this->_isValid = false;
								$this->addError($validator['message']);
							}
							break;
						case 'sum':
							if($this->isDifferent($values[$name], $validator['param'])) {
								
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
		
		if(is_array($var)){
			$isNumber = true;
			foreach($var as $v) {
				$isNumber &= is_numeric($v);
			}
			return $isNumber;
		}
		else {
			return is_numeric($var);
		}
	}
	
	public function isDate($var) {
		
		$pattern = '/^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$/';
		return preg_match($pattern, $var);
	}
	
	public function isLower($var, $value) {
		
		return strlen($var) < $value;
	}
	
	public function isDifferent($var, $value) {
		if(is_array($var)){
			$total = 0;
			foreach($var as $v) {
				$total += $v;
			}
			return $total != $value;
		}
		else {
			return $var != $value;
		}
	}
	
	/*public function equals($var, $value) {
		return $var == $value;
	}*/
	
	public function addError($error) {
		$this->_errors[] = $error;
	}
	
	public function getErrors() {
		return $this->_errors;
	}
	
	public function isValid() {
		return $this->_isValid;
	}
	
	public function setConfirmMessage($msg) {
		$this->_confirmMessage = $msg;
	}
	
	public function getConfirmMessage() {
		return $this->_confirmMessage;
	}
}

?>
