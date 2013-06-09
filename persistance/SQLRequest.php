<?php

class SQLRequest
{
	private $_request;
	private $_parameters;

	/**
	 * Initialize attributes.
	 */
	function __construct()
	{
		$this->_parameters = array();
	}

	/**
	 * Get the SQL request string.
	 * @return String The SQL request string.
	 */
	public function getRequest()
	{
		return $this->_request;
	}

	/**
	 * Set the SQL request string.
	 * @param String $request The SQL request string.
	 */
	public function setRequest($request)
	{
		$this->_request = $request;
	}

	/**
	 * Get parameters of the SQL request.
	 * @return Array An array containing parameters.
	 */
	public function getParameters()
	{
		return $this->_parameters;
	}

	/**
	 * Add a parameter to the request.
	 * @param String $param The name of the parameter to add.
	 * @param String $value The value of the parameter to add.
	 */
	public function addParameter($param, $value)
	{
		$this->_parameters[$param] = $value;
	}
}

?>
