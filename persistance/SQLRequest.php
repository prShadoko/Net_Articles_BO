<?php

/**
 * Définit une requête SQL et ses paramètres
 *
 * @author tom
 */
class SQLRequest
{
	private $_request;
	private $_parameters;

	function __construct()
	{
		$this->_parameters = array();
	}

	public function getRequest()
	{
		return $this->_request;
	}

	public function setRequest($request)
	{
		$this->_request = $request;
	}

	public function getParameters()
	{
		return $this->_parameters;
	}

	public function addParameter($param, $value)
	{
		$this->_parameters[$param] = $value;
	}
}

?>
