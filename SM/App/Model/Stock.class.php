<?php

namespace App\Model;

/**
 * 
 */
//la classe stock est utilisée pour matérialiser une base de donnée
abstract class Stock {

    //la liste des produits
    private $list_produit;

    //utilisée pour ajouter un produit dans la liste des produits (base de donnée)
    public function ajouterProduit($produits) {

        foreach ($produits as $produit) {
            $key = $produit->getKey();
            if (array_key_exists($key, $this->list_produit))
                $this->list_produit[$key]->ajouterQuantite($produit->getQuantite());
            else
                $this->list_produit[$key] = $produit;
        }
    }

    /*
     * @retourne la liste des produits
     *
     */

    public function getListProduit() {
        return $this->list_produit;
    }

    /*
     * @retourne la liste des produits
     *
     */

    public function setListProduit($list_produit) {
        $this->list_produit = $list_produit;
    }

    /*
      /*
     * @génère le composant a gauche de la page du magasi ou de la boutique
     *
     */

    public static function leftContaine($bouton1, $bouton2) {
        $link1 = $bouton1 == 'Depot' ? "index.php?page=DepotProduit" : "index.php?page=retrait";
        $link2 = $bouton2 == 'Retrait' ? "#" : "index.php?page=vente";
        echo "<div class='col-sm-3 col-md-2 col-lg-2 left'>";
        echo "<a href='index.php?page=acceuil' class='btn btn-outline-success btn-lg btn-block'> Acceuille </a><br/><br/>";
        echo "<a href='$link1' class='btn btn-outline-info btn-lg btn-block'> $bouton1 <br/> <i class='fas fa-arrow-down'></i> <br/> <i class='fas fa-database'> </i> </a><br/><br/>";
        echo "<a  href='$link2' class='btn btn-outline-info btn-lg btn-block'> $bouton2  <br/> <i class='fas fa-arrow-up'></i> <br/> <i class='fas fa-database'> </i> </a>";
        echo "</div>";
    }

    /*
     * @génère l'entête du tableau
     *
     */

    private static function tHead($title) {
        $condition = ucfirst($title) === 'Boutique';
        echo "<thead class='bg-dark text-white'>";
        echo "<th scope='col'> Type </th>";
        echo "<th scope='col'> Marque </th>";
        echo "<th scope='col'> Model </th>";
        if ($condition)
            echo "<th scope='col'>Prix d'achat </th>";
        echo "<th scope='col'> Quantité " . ($condition ? '(carton)' : '') . "</th>";
        if ($condition)
            echo "<th scope='col'> Prix Total </th>";
         echo "<th scope='col'> Qualité </th>";
        echo"</thead>";
    }

    /*
     * @génère le body du tableau des produits
     *
     */

    private function tBody($title) {
        echo "<tbody>";
        foreach ($this->list_produit as $key => $produit) {
            $produit->affiche($title);
        }
        echo "</tbody>";
    }

    /*
     * @génère le composant droit de la page de la boutique ou du magasin
     *
     */

    private function rigthContaine($title) {
        echo "<div class='col-sm-9 col-12'>";
        if (count($this->list_produit) > 0) {
            echo "<table class='table table-bordered table-hover'>";
            Stock::tHead($title);
            $this->tBody($title);
            echo "</table>";
        } else
            echo "<h1 class='text-info'>pas de produit enregistrés</h1>";
        echo "</div>";
    }

    /*
     * @génère le body de la page d'un magasin ou de la boutique
     *
     */

    public function body($title, $bouton1, $bouton2) {
        echo "<div class='row bas ' style = 'margin:1.5em; '>";
        Stock::leftContaine($bouton1, $bouton2);
        $this->rigthContaine($title);
        echo "</div>";
    }

    public function reduitProduit($value, $key) {
        if (array_key_exists($key, $this->list_produit)) {
            $this->list_produit[$key]->dimunuerQuantite($value);
        }
    }

}

?>