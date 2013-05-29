<?php

/**
 * Définit une requête SQL et ses paramètres
 *
 * @author tom
 */
class Requete
{
	private $requete;
	private $parametres;

	function __construct()
	{
		$this->parametres = array();
	}

	public function getRequete()
	{
		return $this->requete;
	}

	public function setRequete($requete)
	{
		$this->requete = $requete;
	}

	public function getParametres()
	{
		return $this->parametres;
	}

	public function ajouterParametre($param, $valeur)
	{
		$this->parametres[$param] = $valeur;
	}
}

class Transaction
{
	private $requetes;

	function __construct()
	{
		$this->requetes = array();
	}

	public function ajouterRequete(Requete $req)
	{
		$this->requetes[] = $req;
	}

	public function getRequetes()
	{
		return $this->requetes;
	}
}

?>
