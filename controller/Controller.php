

<?php

abstract class Controller {
	
	private $_name;
	private $_menu;
	private $_view;
	private $_title;
	private $_subTitle;
	private $_userMessages;
	private $_isAnErrorMessage;
	
	public abstract function run($action);
	
	public function setMenu($menu) {
		$this->_menu = $menu;
	}
	
	public function getMenu() {
		return $this->_menu;
	}
	
	public function setView($view) {
		$this->_view = $view;
	}
	
	public function getView() {
		return $this->_view;
	}
	
	public function setName($name) {
		$this->_name = $name;
	}
	
	public function getName() {
		return $this->_name;
	}
	
	public function setTitle($title) {
		$this->_title = $title;
	}
	
	public function getTitle() {
		return $this->_title;
	}
	
	public function setSubTitle($subTitle) {
		$this->_subTitle = $subTitle;
	}
	
	public function getSubTitle() {
		return $this->_subTitle;
	}

	public function addUserMessages($messages) {
		$this->_userMessages[] = $messages;
	}

	public function setUserMessages($messages) {
		$this->_userMessages = $messages;
	}
	
	public function getUserMessages() {
		return $this->_userMessages;
	}
	
	public function isAnErrorMessage($bool = null){
		if($bool === null) {
			return $this->_isAnErrorMessage;
		}
		else {
			$this->_isAnErrorMessage = $bool;
		}
	}
}


?>
