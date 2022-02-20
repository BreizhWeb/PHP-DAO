<?php
class validLivreController  {

    public function __construct(){    
        session_start();
        error_reporting(0);
        require_once "controller/Controller.php";
        require_once "metier/Livre.php";
        require_once "PDO/LivreDB.php";
        require_once "PDO/connectionPDO.php";
        require_once "Constantes.php";
    
        //recuperation des valeurs du compte venant du formulaire MonCompte
        //personne
        $titre = $_POST['nom'] ?? null;
        $edition = $_POST['edition'] ?? null;
        $information = $_POST['info'] ?? null;
        $auteur = $_POST['auteur'] ?? null;

        //action pour update ou insert, delete, select selectall
        $operation = $_GET['operation']?? null;

        //TODO
        if($operation=="insert"){
            //Création de l'objet personne 
            //TODO
            $livre = new Livre($titre, $edition, $information, $auteur);
            try{
                //connexion a la bdd
                $accesBDD=new LivreDB($pdo);
                //TODO insertion de la pers en bdd
                $accesBDD->ajout($livre);
                echo "Le livre a été ajouter à la BDD";
            }
            //levée d'exception si probleme insertion en base de données
            catch(Exception $e) {
                //appel de la constantes définit dans Contantes.php pour afficher un message compréhensible 
                //pour l'utilisateur
                throw new Exception(Constantes::EXCEPTION_INSERT_DB_LIVRE);
            }     
        } else {
            //erreur on renvoit à la page d'accueil
            header('Location: accueil.php?id='.$_SESSION["token"]);
        }
    }
}
