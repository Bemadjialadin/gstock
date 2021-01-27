<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;
use \date;
/**
 * Description of Facture
 *
 * @author siddick
 */
class Facture extends Model{
   
    protected static $table = 'facture';
    
    public function get_numero() {
        return $this->_numero;
    }
    /**
     * 
     * @param type $value
     * @return type
     */
    public static function getID($value)
    {
       return array_key_exists('name', $value)? 
                ['name'=>$value['name']] : ['numeru'=>$value['numro']];
    }
    /**
     * génere automatique le numero de la facture
     * @param type $_numero
     * @return $this
     */
    public function set_numero($_numero) {
        $this->_numero = $_numero;
        return $this;
    }

    /**
     * permet d'enregistrer un achat et crée une foi la facture elle renvoi false si la facture n'est pas créée true à l'inverse
     * @param type $achats
     * @param type $remise
     * @return boolean
     */
    public function save($achats,$remise)

    {
      
      $numero = $this->find(parent::getID(['name'=>'lastnf']),'min')->quantite+1;
      $facture  = [
          'numero' => $numero,
          'date'   => date('y:m:d'),
          'remise' => $remise
      ];
      if(parent::insert($facture)){
        $this->update(['name'=>'lastnf','quantite'=>$numero],'min');
        foreach ($achats as $value) {
            $value['numeroFacture'] = $numero;
            $this->insert($value,'achat');
        }
        return true;
      }
      return false;
    }

    
    
}
