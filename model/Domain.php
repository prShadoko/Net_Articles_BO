<?php

/**
 * Description of Domaine
 *
 * @author 
 */
class Domain {

	private $id;
	private $name;

	public function read($id) {

		$req = new SQLRequest();
		$req->setRequest('Select * from domaine where id_domaine = :id;');
		$req->addParameter('id', $id);

		$rs = DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);

		$this->affectValue($rs[0]);
	}

	private function affectValue($rs) {
		$this->setId($rs['id_domaine']);
		$this->setName($rs['libdomaine']);
	}

	public static function getDomainList() {
		$req = new SQLRequest();
		$req->setRequest('Select * from domaine');

		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function getIdDomain() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

}

?>
