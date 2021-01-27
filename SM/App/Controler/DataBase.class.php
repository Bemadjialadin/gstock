<?php

namespace App\Controler;

use PDO;
/**
 * connexion à la  base de données 
 */
class Database {

    /**
     * represente le chemin de la base de données
     * @var String
     */
    private static $url = "Secour/gStock.db";
    private $pdo;

    public function __construct($url_db_file = "Secour/gStock.db") {
        self::$url = $url_db_file;

    }

    /**
     * la connexion
     * @return \SQLite3
     */
    public function getPDO() {
        if($this->pdo === null) {
            $db = new PDO ('sqlite:' . self::$url);
            $db->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $db;
        }
        return $this->pdo;
    }
    
    /**
     * construction d'une requete
     * @param String $statement
     * @param String $class_name
     * @return Objet
     */
    public function query($statement,$attributes=null,$class_name=null,$one=null) {
        if ($attributes===null) 
            $req  = $this->getPDO ()->query ($statement);
        else{
            $req = $this->getPDO()->prepare($statement);
            $req->execute($attributes);
        }
        if(strpos($statement, 'UPDATE')===0||
            strpos($statement, 'INSERT')===0||
            strpos($statement, 'DELETE')===0){
            return $req;
        }

        $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        if($one){
            $data = $req->fetch();
        } else {
            $data = $req->fetchAll();
        }
        return $data;
    }
    
    /**
     * preparer une requete
     * @param String $statement
     * @param String $attributes
     * @param String $class_name
     * @param String $one
     * @return Objet
     */
    public function prepare($statement, $attributes, $class_name, $one=false){
        
       
        
    }
    
}
