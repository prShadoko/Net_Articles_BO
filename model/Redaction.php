<?php
require_once 'persistence/DBUTils.php';
require_once 'CRUDTable.php';

class Redaction {
	
	public function affectValue($rs) {
		
	}

	public function read($id) {
		
	}
	public static function delete($artId, $autId) {
             $transaction = new Transaction();
		$sql = 'delete from redige where id_article = :idArticle and id_auteur=:idAuteur';
                $request = new SQLRequest();
			$request->setRequest($sql);
			$request->addParameter('idArticle', $artId);
			$request->addParameter('idAuteur', $autId);
			
			$transaction->addRequest($request);
                        DBUtils::transaction($transaction);
	}
        

	public static function getRowCount() {
		$req = new SQLRequest();
		$req->setRequest(
			'Select count(*) 
			from redige;'
			);
		
		$rs = DBUtils::read($req)->fetchAll(PDO::FETCH_NUM);
		return $rs[0][0];
	}

	public static function readableList($article) {
		$req = new SQLRequest();
		$req->setRequest(
			'Select r.id_article as "id", au.identite_auteur as "Auteur", r.part as "Part"
			from redige r
			join article ar on ar.id_article = r.id_article
			join auteur au on au.id_auteur = r.id_auteur
			where r.id_article = '.$article.' 
			order by r.id_article ASC;'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function authorList($article){
		$req = new SQLRequest();
		$req->setRequest(
			'Select id_auteur as "id"
			from redige
			where id_article = '.$article.';'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
        
        public static function articleList($auteur){
		$req = new SQLRequest();
		$req->setRequest(
			'Select id_article as "id"
			from redige
			where id_auteur = '.$auteur.';'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function significantFieldList($article, $authors) {
		$req = new SQLRequest();
		$req->setRequest(
			'Select r.id_auteur as "id", au.identite_auteur as "author", r.part as "part"
			from redige r
			join auteur au on au.id_auteur = r.id_auteur
			where r.id_article = '. $article .'
			and r.id_auteur IN ('.self::idsToString($authors).');'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function part($article, $authors) {
		$req = new SQLRequest();
		$req->setRequest(
			'Select id_auteur as author, part
			from redige r
			where r.id_article = '. $article .'
			and r.id_auteur IN ('.self::idsToString($authors).');'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}
	
       //Supprime les parts d'un auteur dans tout les articles et met à jour les autre parts en consequence
        public static function deleteAuteur($author){
            //On parcours les articles écris par l'auteur
            $articles=self::articleList($author);
           foreach($articles as $k => $art){
              //On récupère les auteur ayant écris l'article
               $authors=self::authorList($art['id']);
               $authids=null;
               foreach($authors as $key=>$id)
                    $authids[$key]=$id['id'];
               //Si d'autres auteurs on participé a l'écriture
               if(count($authids)>1){
                   //On récupère les parts de chaque auteur
                   $parts=self::part($art['id'], $authids);
                   $sum=0;
                   //On fait la somme des parts des autres auteurs
                   foreach($parts as $k => $part){
                       if($part['author']!=$author)
                        $sum+=$part['part'];
                   }
                   //Calcul du ratio d'augmentation en fonction de cette somme
                   $ratio=100/$sum;
                   $update=null;
                   //Récupération des auteurs concernés dans un tableau et calcul de leur nouvelle part
                   $authorToUp=null;
                   foreach($parts as $k => $part){
                       if($part['author']!=$author){
                        //   $update[$part['author']]=floor($part['part']*$ratio);
                           $authorToUp[$k]=$part['author'];
                           $partToUp[$k]=floor($part['part']*$ratio);;
                       }
                   }
                   //Si la somme n'est pas égale à 100 on augmente des parts de 1 jusqu'à que la somme fasse 100
                   $sum=0;
                   foreach($partToUp as $k => $up){
                       $sum+=$up;
                   }
                   if($sum<100){
                    foreach($partToUp as $k => $up){
                         $partToUp[$k]++;
                         $sum++;
                            if($sum==100){
                                    break;
                                }          
                         }
                   }
                   // Mise à jour des auteur dans la base
                   self::updateDB($art['id'], $authorToUp, $partToUp);

                  
               }
               //Suppression du tuple redige concernant l'article et l'auteur
                self::delete($art['id'], $author);
            }
            
        }
        
	public static function updateDB($article, $authors, $parts){
		$transaction = new Transaction();
		//debug($article);debug($authors);debug($parts);exit;
		$sql = 'delete from redige where id_article = :idArticle';
		$request = new SQLRequest();
		$request->setRequest($sql);
		$request->addParameter('idArticle', $article);
		$transaction->addRequest($request);
		
		foreach($authors as $k => $a){
			$sql = 'insert into redige(id_article, id_auteur, part) values(:idArticle, :idAuthor, :part)';
			
			$request = new SQLRequest();
			$request->setRequest($sql);
			$request->addParameter('idArticle', $article);
			$request->addParameter('idAuthor', $a);
			$request->addParameter('part', $parts[$k]);
			
			$transaction->addRequest($request);
		}
		
		DBUtils::transaction($transaction);
	}
	
	/*public static function partOfAuthor($ids) {
		$req = new SQLRequest();
		$req->setRequest(
			'Select r.id_auteur as "id", au.identite_auteur as "Auteur", r.part as "Part"
			from redige r
			join article ar on ar.id_article = r.id_article
			join auteur au on au.id_auteur = r.id_auteur
			where r.id_article IN ('. self::idsToString($ids) .')
			UNION
;'
			);
		
		return DBUtils::read($req)->fetchAll(PDO::FETCH_ASSOC);
	}*/

	public static function fieldlist($fields, $start = null, $length = null) {
		$fieldList = '';
		
		
		foreach ($fields as $name => $field){
			$fieldList .= $field.' as "'.$name.'", ';
		}
		
		$fieldList = substr($fieldList, 0, strlen($fieldList)-2);
		
		$req = 'Select '.$fieldList.'
			from redige r
			join article ar on ar.id_article = r.id_article
			join auteur au on au.id_auteur = r.id_auteur
			order by r.id_article ASC';
		
			if(	isset($start) && isset($length) ) {
				$req .= ' limit '.$start.', '.$length;
			}
		
		$request = new SQLRequest();
		$request->setRequest($req.';');
		
		return DBUtils::read($request)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function idsToString($ids) {
		$idList = "";
		foreach($ids as $id){
			$idList .= $id.', ';
		}
		return substr($idList, 0, strlen($idList)-2);
	}
}

?>
