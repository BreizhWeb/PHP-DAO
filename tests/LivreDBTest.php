<?php
use PHPUnit\Framework\TestCase;
require_once "Constantes.php";
require_once "metier/Livre.php";
require_once "PDO/LivreDB.php";


class LivreDBTest extends TestCase {

    /**
     * @var LivreDB
     */
    protected $object;
    protected $pdodb;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp():void {
        //parametre de connexion à la bae de donnée
        $strConnection = Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE;
        $arrExtraParam = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $this->pdodb = new PDO($strConnection, Constantes::USER, Constantes::PASSWORD, $arrExtraParam); //Ligne 3; Instancie la connexion
        $this->pdodb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown():void {
        
    }

    /**
     * @covers LivreDB::ajout
     * @todo   Implement testAjout().
     */
    public function testAjout() {
        try{ 
            $this->object = new LivreDB($this->pdodb);
            $l = new Livre("Harry Potter à l'école des sorciers", "Gallimard", "roman", "Joanne Rowling");

            //insertion en bdd
            $this->object->ajout($l);
            $l->setId($this->pdodb->lastInsertId());
            $livre = $this->object->selectLivre($l->getId());

            //echo "pers bdd: $livre";
            $this->assertEquals($l->getTitre(), $livre->getTitre());
            $this->assertEquals($l->getEdition(), $livre->getEdition());
            $this->assertEquals($l->getInformation(), $livre->getInformation());
            $this->assertEquals($l->getAuteur(), $livre->getAuteur());
            $this->object->suppression($livre);
        } catch (Exception $e) {
            echo 'Exception recue : ', $e->getMessage(), "\n";
        }
    }

    /**
     * @covers LivreDB::update
     * @todo   Implement testUpdate().
     */
    public function testUpdate() {
        $this->object = new LivreDB($this->pdodb);
        $l = new Livre("Harry Potter à l'école des sorciers", "Gallimard", "roman update", "Joanne Rowling");
        $l->setId(58);
        $this->object->update($l);

        //TODO  à finaliser 
        //instanciation de l'objet pour mise ajour
        $l = new Livre("Harry Potter à l'école des sorciers", "Gallimard", "roman update", "Joanne Rowling");

        //update object 
        $lastId = $this->pdodb->lastInsertId();
        $l->setId($lastId);
        $this->object->update($l);
        $livre = $this->object->selectLivre($l->getId());
        $this->assertEquals($l->getId(), $livre->getId());
        $this->assertEquals($l->getTitre(), $livre->getTitre());
        $this->assertEquals($l->getEdition(), $livre->getEdition());
        $this->assertEquals($l->getInformation(), $livre->getInformation());
        $this->assertEquals($l->getAuteur(), $livre->getAuteur());
    }

    /**
     * @covers LivreDB::suppression
     * @todo   Implement testSuppression().
     */
    public function testSuppression() {
       //TODO
       try{
        $this->object = new LivreDB($this->pdodb);
        $l = new Livre("Harry Potter à l'école des sorciers", "Gallimard", "roman delete", "Joanne Rowling");
        //insertion en bdd
        $this->object->ajout($l);
        $lastId = $this->pdodb->lastInsertId();
        $livre = $this->object->selectLivre($lastId);
        $this->object->suppression($livre);
        if($livre!=null){
            $this->markTestIncomplete("La suppression de l'enregistrement livre a echoué");
        }
        }  catch (Exception $e){
            //verification exception
            $exception="RECORD Livre not present in DATABASE";
            $this->assertEquals($exception,$e->getMessage());
        }  
    }

    /**
     * @covers LivreDB::selectAll
     * @todo   Implement testSelectAll().
     */
    public function testSelectAll() {
        //TODO
        $ok=true;
        $this->object = new LivreDB($this->pdodb);
        $res=$this->object->selectAll();
        $i=0;
        foreach ($res as $key=>$value) {
            $i++; 
        }
        print_r($res);
            if($i==0){
            $this->markTestIncomplete( 'Pas de résultat' );
            $ok=false;
            }
        $this->assertTrue($ok);
     
    }

    /**
     * @covers LivreDB::selectLivre
     * @todo   Implement testSelectLivre().
     */
    public function testSelectLivre() {
        //TODO
        $this->object = new LivreDB($this->pdodb);
        $l = new Livre("Harry Potter à l'école des sorciers", "Gallimard", "roman selectlivre", "Joanne Rowling");
        $this->object->ajout($p);
        $l = $this->object->selectLivre(1);
        $livre = $this->livre->selectLivre($l->getId());
        $this->assertEquals($l->getId(), $livre->getId());
        $this->assertEquals($l->getTitre(), $livre->getTitre());
        $this->assertEquals($l->getEdition(), $livre->getEdition());
        $this->assertEquals($l->getInformation(), $livre->getInformation());
        $this->assertEquals($l->getAuteur(), $livre->getAuteur());
    }
}
