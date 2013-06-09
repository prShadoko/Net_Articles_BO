<?php

class Transaction {

	private $_requests;
	
	/**
	 * Construct a transaction.
	 */
	function __construct() {
		$this->_requests = array();
	}
	
	/**
	 * Add a sql request to the transaction.
	 * @param SQLRequest $req The request to add.
	 */
	public function addRequest(SQLRequest $req) {
		$this->_requests[] = $req;
	}

	/**
	 * Get SQL requests.
	 * @return Array An array of SQLRequest.
	 */
	public function getRequests() {
		return $this->_requests;
	}

}

?>
