<?php
/**
 * Description of Domaine
 *
 * @author 
 */

class Domaine {
    
    private $id_domaine;
    private $libdomaine;

    public function lireDomaine($id_domaine) {
	
        $req = "select * from domaine where id_domaine = $id_domaine";
        
	$rs = Db_Utils::lecture($req)->fetchAll();
        
	$this->affecterValeur($rs);
    }
    
    private function affecterValeur($rs) {
        $this->setId_domaine($rs[0]['id_domaine']);
	$this->setLibdomaine($rs[0]['libdomaine']);
    }
    
    public function getIdDomaine() {
	return $this->id_domaine;
    }

    public function setId_domaine($id_domaine) {
	$this->id_domaine = $id_domaine;
    }

    public function getLibdomaine() {
	return $this->libdomaine;
    }

    public function setLibdomaine($libdomaine) {
	$this->libdomaine = $libdomaine;
    }


}
?>
