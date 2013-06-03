<?php

require_once 'model/Request.php';

class BootStrap {

	private static $_controller = null;
	private static $_request = null;

	
	public static function getRequest()
	{
		if( is_null(self::$_request) ) {
			self::$_request = new Request();
		}
		return self::$_request;

	}
	
	public static function getController()
	{
		if( is_null(self::$_controller) ) {
			self::initController();
		}
		
		return self::$_controller;

	}
	
	public static function initController() {
		$request = self::getRequest();
		try {
			self::includeController();
			
			$name = $request->getController();
			$action = $request->getAction();

			$controllerClass = $name . "Controller";

			self::$_controller = new $controllerClass();
			self::$_controller->setView(lcfirst($name));
			self::$_controller->setMenu("menu");
			self::$_controller->run($action);
		}
		catch (Exception $ex) {
			//TODO: Error management
			if( $request->getController() == 'Error' ) {
				header("HTTP/1.0 404 Not Found");
				echo 'Error 404 - Page not found';
				exit;
			}
			
			$request->setController('Error');
			$request->setAction('404');
			Sessions::setError($ex);
			header('location: '.$request->getURL());
			exit;
		}
	}
	
	public static function includeController() {
		$request = self::getRequest();
		
		if(file_exists('controller/'. $request->getController() .'Controller.php')) {
			require_once 'controller/'. $request->getController() .'Controller.php';
		}
		else {
			throw new InvalidArgumentException('"'.$request->getController().'" n\'est pas un controleur valide.');
		}
	}
}
?>
