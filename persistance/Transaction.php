<?php

class Transaction {

	private $requetes;

	function __construct() {
		$this->requetes = array();
	}

	public function ajouterRequete(Requete $req) {
		$this->requetes[] = $req;
	}

	public function getRequetes() {
		return $this->requetes;
	}

}

?>
