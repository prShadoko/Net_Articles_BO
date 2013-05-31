<?php
class Request
{
	private $_controller;
	private $_action;
	private $_id;
	
	public function __construct() {
		$this->_controller = 'Index';
		$this->_action = 'default';
		$this->_id = null;
		
		if(isset($_REQUEST['c'])) {
			$this->_controller = $_REQUEST['c'];
		}
		
		if(isset($_REQUEST['a'])) {
			$this->_action = $_REQUEST['a'];
		}
		
		if(isset($_REQUEST['id'])) {
			$this->_id = $_REQUEST['id'];
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
	
	public function getId()
	{
		return $this->_id;
	}
	
	public function setId($id)
	{
		$this->_id = $id;
	}
	
	public function getURL($action = null, $id = null, $controller = null) {
		
		if(is_null($controller)){
			$controller = $this->getController();
		}
		
		if(is_null($action)){
			$action = $this->getAction();
		}
		
		if( is_null($id) ) {
			$id = $this->getId();
		}
		if( isset($id) ) {
			$id = '&id='.$id;
		}
		
		$url = 'index.php?c='.$controller.'&a='.$action.$id;
		
		return $url;
	}
}
?>
