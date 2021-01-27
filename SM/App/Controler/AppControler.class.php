<?php

namespace App\Controler;
use App\Exceptions\ValidateException;
/**
 * 
 */
class AppControler extends Controler {

    protected $template;

    function __construct() {
        $this->viewsPath = 'Views/';
    }
    public function validate($value,$type='Array') {
        $except = true;
        foreach ($value as $key => $value) {
            if(strlen($value)==0){
                $except = false;
               $_SESSION['error'][$key] = "le champ $key ne doit etre vide";
            }
        }
        if(!$except)
            throw  new ValidateException ();
    }
}
