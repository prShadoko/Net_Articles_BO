<?php
require_once 'CRUDController.php';
require_once 'model/Auteur.php';

class AuteurController extends CRUDController {
	
	private $_auteur;
	
	protected function createValidator() {
		
		$validator = new FormValidator();
		$validator->setConfirmMessage('L\'auteur a correctement été enregistrer.');
		$validator->addValidator('pwd','minimum length', 'Le mot de passe doit avoir au moins 4 caractères.', 4); // Magic number !
		$validator->addValidator('pwd','different', 'Le mot de passe doit être différent du login.', 'login');
		
		return $validator;
	}

	protected function defineDeletedRows($ids) {
		return $rows = Auteur::significantFieldList($ids);
	}

	protected function definePageCount() {
		$pageCount = ceil(Auteur::getArticleCount() / self::$length);

		return $pageCount;
	}

	protected function defineRows($start, $length) {

		$rows = Auteur::readableList($start, $length);

		return $rows;
	}

	protected function deleteRows($ids) {
		Auteur::delete($ids);
	}

	protected function getUserConfirmationMessage() {
		return 'L\'auteur a correctement été enregistré.';
	}

	protected function initModel() {
		$this->_auteur = new Auteur();
	}

	protected function updateDB() {
		$this->_auteur->updateDB();
	}

	protected function updateModelById($id) {
		$this->_auteur->read($id);
	}

	protected function updateModelByRequest($params) {
		$this->_auteur->affectValue($params);
	}
	
	public function getDataId() {
		return $this->_auteur->getId();
	}
	
	public function getAuteur() {
		return $this->_auteur;
	}
}

?>
