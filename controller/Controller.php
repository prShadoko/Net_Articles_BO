

<?php

abstract class Controller {
	
	private $_name;
	private $_menu;
	private $_view;
	private $_title;
	
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
}


?>
