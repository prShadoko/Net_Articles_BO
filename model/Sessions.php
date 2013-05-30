<?php

class Sessions {
	
	public static function start() {
		session_start();
	}
	
	public static function setError($error) {
		$_SESSION['error'] = $error;
	}
	
	public static function getError() {
		
		$error = null;
		
		if(isset( $_SESSION['error'])) {
			$error =  $_SESSION['error'];
		}
		
		return $error;
	}
	
	public static function unsetError() {
		unset($_SESSION['error']);
	}
}

?>
