

<?php

abstract class Controller {
	
	private $_menu;
	private $_view;
	
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
	
	public function getTitle() {
		return "Net Articles BO";
	}
}


?>
