<?php
require_once "Constantes.php";
require_once "metier/Livre.php";
require_once "MediathequeDB.php";

class LivreDB extends MediathequeDB {
	private $db; // Instance de PDO
	public $lastId;
	//TODO implementer les fonctions
	public function __construct($db){
		$this->db=$db;
	}

	/**
	 * 
	 * fonction d'Insertion de l'objet Livre en base de donnee
	 * @param Livre $l
	 */
	public function ajout(Livre $l){
		$q = $this->db->prepare('INSERT INTO livre(titre,edition,information,AUTEUR) values(:titre,:edition,:information,:AUTEUR)');
		$q->bindValue(':titre', $l->getTitre());
		$q->bindValue(':edition', $l->getEdition());
		$q->bindValue(':information', $l->getInformation());
		$q->bindValue(':AUTEUR', $l->getAuteur());
		$q->execute();
		$this->last_id=$this->db->lastInsertId();
		$q->closeCursor();
		$q = NULL;
	}	

	/**
	 * 
	 * fonction d'update de l'objet Livre en base de donnee
	 * @param Livre $l
	 */
	public function update(Livre $l){
		try {
			$q = $this->db->prepare('UPDATE livre set titre=:titre,edition=:edition,information=:information,AUTEUR=:AUTEUR where id=:id');
			$q->bindValue(':id', $l->getId());
			$q->bindValue(':titre', $l->getTitre());
			$q->bindValue(':edition', $l->getEdition());
			$q->bindValue(':information', $l->getInformation());
			$q->bindValue(':AUTEUR', $l->getAuteur());
			$q->execute();	
			$q->closeCursor();
			$q = NULL;
		}
		catch(Exception $e){
			throw new Exception(Constantes::EXCEPTION_DB_LIVRE_UP); 	
		}
	}

    /**
     * 
     * fonction de Suppression de l'objet Livre
     * @param Livre $l
     */
	public function suppression($id){
		$q = $this->db->prepare('DELETE FROM livre WHERE id=:id');
		$q->bindValue(':id', $id);
		$res = $q->execute();
		$q->closeCursor();
		$q = NULL;
		return $res;
	}

	/**
	 * 
	 * Fonction qui retourne toutes les livres
	 * @throws Exception
	 */
	public function selectAll(){
		$query = 'SELECT * FROM livre';
		$q = $this->db->prepare($query);
		$q->execute();
		$arrAll = $q->fetchAll(PDO::FETCH_ASSOC);
		
		//si pas dadresse , on leve une exception
		if(empty($arrAll)){
			throw new Exception(Constantes::EXCEPTION_DB_LIVRE);
		}
		$result=$arrAll;	

		//Clore la requ�te pr�par�e
		$q->closeCursor();
		$q = NULL;

		//retour du resultat
		return $result;
	}
	public function selectLivre($id){
		try{
			$query = 'SELECT * FROM `livre`  WHERE id= :id ';
			$q = $this->db->prepare($query);		
			$q->bindValue(':id',$id);
			$q->execute();
			$arrAll = $q->fetch(PDO::FETCH_ASSOC);

			//si pas d'e personne'adresse , on leve une exception
			if(empty($arrAll)){
				throw new Exception(Constantes::EXCEPTION_DB_LIVRE); 
			}
			$result=$arrAll;		
			$q->closeCursor();
			$q = NULL;

			//conversion du resultat de la requete en objet adresse
			$res= $this->convertPdoAdr($result);

			//retour du resultat
			return $res;
		}catch (Exception $e){
			throw new Exception(Constantes::EXCEPTION_DB_LIV_SELECT . $e); 
		}
		}

    /**
	 * 
	 * Fonction qui convertie un PDO Livre en objet Livre
	 * @param $pdoLivr
	 * @throws Exception
	 */
	public function convertPdoLiv($pdoLivr){
		if(empty($pdoLivr)){
			throw new Exception(Constantes::EXCEPTION_DB_CONVERT_LIVR);
		}
		try{
			//conversion du pdo en objet
			$obj=(object)$pdoLivr;
			$titre= (string)$obj->titre;
			$edition= (string)$obj->edition;
			$information= (string) $obj->information;
			$AUTEUR= (string) $obj->AUTEUR;
			//conversion de l'objet en objet livre
			$livre=new Adresse($titre,$edition,$information,$AUTEUR);
			//affectation de l'id livre
			$livre->setId($obj->id);
			return $adr;	 
		}catch(Exception $e){
			throw new Exception(Constantes::EXCEPTION_DB_CONVERT_LIVR.$e);
		}
	}
}