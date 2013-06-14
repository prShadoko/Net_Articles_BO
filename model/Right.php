<?php
require_once 'persistence/DBUtils.php';
require_once 'persistence/Transaction.php';
require_once 'persistence/SQLRequest.php';

class Right {
	
	public static function update() {
		
		$req = 'insert into droits (id_auteur, annee, trimestre, etat_droits, montants_droits)
		select au.id_auteur, year(ac.date_achat) as annee, quarter(ac.date_achat) as trimestre, "C" as etat_droits, sum(ar.prix * r.part / 100) as montants_droits
		from auteur au
		join redige r on r.id_auteur = au.id_auteur
		join article ar on ar.id_article = r.id_article
		join achete ac on ac.id_article = ar.id_article
		group by au.id_auteur, annee, trimestre;';
		
		$delete = new SQLRequest();
		$delete->setRequest('delete from droits;');
		
		$insert = new SQLRequest();
		$insert->setRequest($req);
		
		$transtaction = new Transaction();
		$transtaction->addRequest($delete);
		$transtaction->addRequest($insert);
		
		DBUtils::transaction($transtaction);
	}
	
	public static function readableList($start, $length) {
		$req = 'select au.identite_auteur as "Auteur", annee as "Annee", trimestre as "Trimestre", etat_droits as "Etats", montants_droits as "Montant"
		from droits d
		join auteur au on au.id_auteur = d.id_auteur
		Order by Auteur, Annee, Trimestre
		limit '.$start.', '.$length.';';
		
		$request = new SQLRequest();
		$request->setRequest($req);
		
		return DBUtils::read($request)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function getRowCount() {
		$req = 'select count(*)
		from droits;';
		
		$request = new SQLRequest();
		$request->setRequest($req);
		
		return DBUtils::read($request)->fetchAll(PDO::FETCH_NUM)[0][0];
	}
}

?>
