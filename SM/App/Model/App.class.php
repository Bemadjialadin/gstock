<?php
namespace App\Model;

class App {
    
    const URL = "Secour/gStock.db";
    
    private static $database;

    public function __construct(){
         if(!Authentification::logged())
             header("location:index.php?page=login");
    }
    
    /**
     * 
     * @return type Database
     */
    public static function getDatabase() {
        
        if(self::$database === null){
            self::$database = new \App\Controler\Database(self::URL);
        }
        return self::$database;
    }


}
