<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of Autoloader
 *
 * @author admin
 */
class Autoloader {
    /**
     * 
     */
    static function register() {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }
    /**
     * 
     * @param type $class
     */
    static function autoload($class) {
        if(strpos($class, __NAMESPACE__ . '\\') === 0){
            
            $class = str_replace(__NAMESPACE__ . '\\', '' , $class);
            $class = str_replace('\\', '/', $class);
            require 'App/' .$class . '.class.php';  
        }
       
    }
}
