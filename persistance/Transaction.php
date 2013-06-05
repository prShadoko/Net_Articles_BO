<?php

class Transaction {

	private $_request;

	function __construct() {
		$this->_request = array();
	}

	public function addRequest(SQLRequest $req) {
		$this->_request[] = $req;
	}

	public function getRequest() {
		return $this->_request;
	}

}

?>
