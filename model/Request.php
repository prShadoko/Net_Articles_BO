<?php
class Request
{
	private $_controller;
	private $_action;
	
	public function __construct() {
		$this->_controller = 'Index';
		$this->_action = 'default';
		
		if(isset($_REQUEST['c'])) {
			$this->_controller = $_REQUEST['c'];
		}
		
		if(isset($_REQUEST['a'])) {
			$this->_action = $_REQUEST['a'];
		}
	}
	
	public function getController()
	{
		return $this->_controller;
	}
	
	public function setController($controller)
	{
			$this->_controller = $controller;
	}
	
	public function getAction()
	{
		return $this->_action;
	}
	
	public function setAction($action)
	{
		$this->_action = $action;
	}
	
	public function getURL() {
		return 'index.php?c='.$this->getController().'&a='.$this->getAction();
	}
}
?>
