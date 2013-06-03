<?php

/**
 * Description of Article
 *
 * @author 
 */
class Article {

	private $id_article;
	private $resume;
	private $id_domaine;
	private $titre;
	private $Prix;
	private $date_publication;
	private $fichier;

	public function dernierArticle() {

		$req = "Select * from article where date_article = (
	    select max(date_article) from article
	    );";

		$rs = Db_Utils::lecture($req)->fetchAll();

		$this->affecterValeur($rs[0]);
	}

	public function lireArticle($id_article) {

		$req = "Select * from article where id_article = $id_article;";

		$rs = Db_Utils::lecture($req)->fetchAll();

		$this->affecterValeur($rs[0]);
	}

	private function affecterValeur($rs) {
		$this->setId_article($rs['id_article']);
		$this->setResume($rs['resume']);
		$this->setId_domaine($rs['id_domaine']);
		$this->setTitre($rs['titre']);
		$this->setPrix($rs['prix']);
		$this->setDate_publication($rs['date_article']);
		$this->setFichier($rs['fichier']);
	}

	public static function ListeArticlesPanier($panier) {
		
		$liste = implode(",", array_keys($panier));
        
		$req = "Select * from article where id_article IN ( $liste );";
		
		/*$liste = Array();
		
		foreach($panier as $key => $value) {
			$article = new Article();
			$article->lireArticle($key);
			$liste[] = $article;
		}*/
		
		return Db_Utils::lecture($req)->fetchAll();
	}
	
	public function getId_article() {
		return $this->id_article;
	}

	public function setId_article($id_article) {
		$this->id_article = $id_article;
	}

	public function getResume() {
		return $this->resume;
	}

	public function setResume($resume) {
		$this->resume = $resume;
	}

	public function getId_domaine() {
		return $this->id_domaine;
	}

	public function setId_domaine($id_domaine) {
		$this->id_domaine = $id_domaine;
	}

	public function getTitre() {
		return $this->titre;
	}

	public function setTitre($titre) {
		$this->titre = $titre;
	}

	public function getPrix() {
		return $this->Prix;
	}

	public function setPrix($Prix) {
		$this->Prix = $Prix;
	}

	public function getDate_publication() {
		return $this->date_publication;
	}

	public function setDate_publication($date_publication) {
		$this->date_publication = $date_publication;
	}

	public function getFichier() {
		return $this->fichier;
	}

	public function setFichier($fichier) {
		$this->fichier = $fichier;
	}
}

?>
