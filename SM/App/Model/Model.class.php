<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;
use App\Controler\DataBase;

/**
 * Description of Model
 *
 * @author admin
 */
class Model {
    /**
     *c'est la connection à la base de donnée
     * @var type DataBase
     */
    private static $db;
    /*
     * fourni la connection à la base de donnée
     * @return type DataBase
     */
    public static function getDB()
    {
        if (self::$db === null) {
             self::$db = new DataBase();
         } 
         return self::$db;
    }
    /*
     * renvoie tous les entrées de la table d'une model donnée
     * return type Model
     */
    public  function all(){
        return self::getDB()->query("SELECT * FROM ". STATIC::$table."",null,get_called_class());
    }
    
    /**
     * prend un model sous fomre de Array et renvoie les clés primaires de la table corespondante  
     * @param type Model $value
     * @return type Array
     */
    public static function getID($model)
    {
        return array_key_exists('name', $model)? 
                ['name'=>$modle['name']] : ['id'=>$model['id']];
    }

    /**
     * fourni une entrée de la table correspondant à un model sous contrainte de son id passé sous forme de Array
     * @param type $id
     * @param type $table
     * @return type
     */
    public  function find($id,$table=null){
       
        return self::getDB()->query("SELECT * FROM ".($table==null? STATIC::$table : $table)
                ." WHERE ".implode('AND', STATIC::valOrEgality($id)),$id,
                 get_called_class(),true);
        
    }
    
    /**
     * prend un model sous forme de Array et insere ses donnée dans la table corespondante au model
     * @param type Array $values
     * @param type String $table
     * @return type boolean
     */
    public function insert($values,$table=null)
    {
    
       return self::getDB()->query('INSERT INTO '.
                ($table==null? STATIC::$table : $table).
                '('.implode(',', self::getFields($values)).') 
                values('.implode(',', STATIC::valOrEgality($values,false)).')',$values);
    }
    /**
     * prend un model sous forme de Array et contruit le String de la requête preparée
     * exemple ['a'=>1,'b'=>2] , retourne [a = ?,b = ?] ou [a,b] 
     * $is_egalite permet de precosé s'il s'agit d'une égalité ou de la liste des champs d'un table
     * @param type $values
     * @param type booleant $is_egality
     * @return type Array
     */
    public static function valOrEgality($values,$is_egality=true){
        $fields =[];
        foreach ($values as $key => $value) {
            $fields[] = $is_egality?  ' '.$key." = :".$key.' ' : ' :'.$key.' ' ;
        }
        return$fields;
    }

    /**
     * 
     * @param type $values
     * @return type
     */
    public static function getFields($values)
    {
        $fields =[];
        foreach ($values as $key => $value) {
            $fields[] = $key;
        }
        return $fields;
    }

    public function update($produit,$table=null)
    {
        
       return self::getDB()->query('UPDATE '.($table==null? STATIC::$table : $table).' set '.
               implode(' , ', STATIC::valOrEgality($produit)).
              ' WHERE '. implode(' AND ', STATIC::valOrEgality(STATIC::getID($produit))),$produit);

    }
    
}
