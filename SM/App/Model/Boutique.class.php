<?php

namespace App\Model;

/**
 * represente un boutique
 */
class Boutique extends Stock {

    function __construct() {
        $this->setListProduit((new Produit())->allProduitBoutique());
    }
    
    
    public function affiche() {
        $this->body('boutique', "Import", "Vente");
    }

}

?>