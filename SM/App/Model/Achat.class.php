<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

/**
 * Description of Achat
 *
 * @author siddick
 */
class Achat {
    
    /**
     *@property int $_id identifiant d'achat
    */
    
    private $_id;
    
      /**
     *@property int $_nombre le nombre acheté
    */
    
    private $_nombre;
    
      /**
     *@property Produit $_produit produit acheté
    */
    
    private $_produit;
    
      /**
     *@property Facture $_facture
    */
    
    private $_facture;
    
      /**
     *@property date $_date le stock courant du magasin
    */
    
    private $_date;
    
    
    
    public function get_id() {
        return $this->_id;
    }

    public function get_nombre() {
        return $this->_nombre;
    }

    public function get_produit() {
        return $this->_produit;
    }

    public function get_facture() {
        return $this->_facture;
    }

    public function set_id($_id) {
        $this->_id = $_id;
        return $this;
    }

    public function set_nombre($_nombre) {
        $this->_nombre = $_nombre;
        return $this;
    }

    public function set_produit($_produit) {
        $this->_produit = $_produit;
        return $this;
    }

    public function set_facture($_facture) {
        $this->_facture = $_facture;
        return $this;
    }


}
