<?php

require_once 'model/HTTPRequest.php';

class BootStrap {

	private static $_controller = null;
	private static $_request = null;

	
	public static function getRequest()
	{
		if( is_null(self::$_request) ) {
			self::$_request = new HTTPRequest();
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
			$name = $request->getController();
			$action = $request->getAction();

			self::includeController($name);
			
			$controllerClass = $name . "Controller";

			self::$_controller = new $controllerClass();
			self::$_controller->setTitle('Net Articles BO');
			self::$_controller->setName($name);
			self::$_controller->setView($name);//lcfirst($name));
			self::$_controller->run($action);
		}
		catch (Exception $ex) {
			//TODO: Error management
			/*if( $request->getController() == 'Error' ) {
				header("HTTP/1.0 404 Not Found");
				echo 'Error 404 - Page not found';
				exit;
			}*/
			
			self::includeController('Error');
			self::$_controller = new ErrorController();
			self::$_controller->setTitle('Erreur - Net Articles BO');
			self::$_controller->setView('error');
			self::$_controller->setError($ex);
			self::$_controller->run($ex->getCode());
		}
	
		self::$_controller->setMenu('menu');
	}
	
	public static function includeController($controller) {
		
		if(file_exists('controller/'. $controller .'Controller.php')) {
			require_once 'controller/'. $controller .'Controller.php';
		}
		else {
			throw new InvalidArgumentException('"'.$controller.'" n\'est pas un controleur valide.', 404, null);
		}
	}
}
?>
