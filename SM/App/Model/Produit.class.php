<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use App\Exceptions\ExisteDataException;

/**
 * Description of Produit
 * @property type $name Description
 * @author siddick
 */
class Produit extends Model {

    protected static $table = "produit";

    public function getMarque() {
        return $this->_marque;
    }

    public function getModel() {
        return $this->_model;
    }

    public function getQualite() {
        return $this->_qualite;
    }

    public function getType() {
        return $this->_type;
    }

    public function getPrix() {
        return $this->_prix;
    }

    public function getQuantite() {
        return $this->_quantite;
    }

    public function setMarque($_marque) {
        $this->_marque = $_marque;
    }

    public function setModel($_model) {
        $this->_model = $_model;
    }

    public function setQualite($_qualite) {
        $this->_qualite = $_qualite;
    }

    public function setType($_type) {
        $this->_type = $_type;
    }

    public function setPrix($_prix) {
        $this->_prix = $_prix;
    }

    public function setQuantite($_type) {
        $this->_quantite = $_quantite;
    }

    public function setMin($_prix) {
        $this->_min = $_min;
    }

    /**
     * 
     * @param type $produit
     * @return type
     */
    public static function getID($produit) {
        return array_key_exists('type', $produit) ? [
            'type' => $produit['type'],
            'qualite' => $produit['qualite'],
            'model' => $produit['model']
                ] : [
            'typeProduit' => $produit['typeProduit'],
            'qualiteProduit' => $produit['qualiteProduit'],
            'modelProduit' => $produit['modelProduit']
        ];
    }

    /**
     * 
     * @return type
     */
    public function getKey() {
        return $this->getType() . "_" . $this->getModel() . '_' . $this->getQualite();
    }

    /**
     * 
     * @return type
     */
    public function getKeys() {
        return $this->getType() . "_" . $this->getModel();
    }

    /**
     * 
     * @param type $title
     */
    function affiche($title) {
        $classe = ($this->_quantite <= $this->getMin($title)) ? "bg-danger" : "bg-success";
        $condition = ucfirst($title) === 'Boutique';
        echo "<tr class='$classe'>";
        echo "<td> " . $this->_type . " </td>";
        echo "<td> " . $this->_marque . " </td>";
        echo "<td> " . $this->_model . " </td>";
        if ($condition)
            echo "<td> " . $this->_prix . " </td>";
        echo "<td> " . $this->_quantite . " </td>";
        if ($condition)
            echo "<td> " . $this->_prix * $this->_quantite . " </td>";
        echo "<td> " . $this->_qualite . " </td>";
        echo "</tr>";
    }

    /**
     * 
     * @return type Produit
     */
    public function allProduitBoutique() {
        return self::getDB()->query("SELECT 
            type as _type, qualite as _qualite, model as _model, 
            marque as _marque, prix_d_achat as _prix, quantite as _quantite
            FROM produit INNER JOIN boutique 
            ON model = modelProduit AND qualite = qualiteProduit AND type = typeProduit"
                        , null, get_called_class());
    }

    /**
     * 
     * @return type Produit
     */
    public function allProduitMagasin() {
        return self::getDB()->query("SELECT 
            type as _type, qualite as _qualite, model as _model, 
            marque as _marque, prix_d_achat as _prix,  quantite as _quantite
            FROM produit INNER JOIN magasin 
            ON model = modelProduit AND qualite = qualiteProduit AND type = typeProduit",
                        null, get_called_class());
    }

    /**
     * 
     * @param type $name
     * @return type
     */
    private static function getMin($name) {
        return self::getDB()->query('SELECT quantite from min 
            WHERE name = ?', [$name], 'INTEGER', true)[0];
    }

    /**
     * 
     * @param type Produit $produit
     * @param type Produit $table
     * @return boolean
     */
    public function save($produit, $table = null) {
        $p = [
            'type' => $produit['type'],
            'qualite' => $produit['qualite'],
            'model' => $produit['model'],
        ];
        if ($this->find($p))
            throw new ExisteDataException ();
        $p['marque'] = $produit['marque'];
        $p['prix_d_achat'] = $produit['prix'];
        if (parent::insert($p)) {
            $p = [
                'typeProduit' => $produit['type'],
                'qualiteProduit' => $produit['qualite'],
                'modelProduit' => $produit['model'],
                'quantite' => $produit['quantite']
            ];
            parent::insert($p, 'magasin');
            $p['quantite'] = 0;
            return parent::insert($p, 'boutique');
        }
        return false;
    }

    /**
     * 
     * @param type Produit $produit
     * @param type boolean $plus
     * @param type String $table
     * @return boolean
     */
    public function ajoutOrRetrait($produits, $plus = true, $table = 'boutique') {
        $erro = false;
        $quantite = $produits['quantite'];
        $produit = [
            'typeProduit' => $produits['type'],
            'qualiteProduit' => $produits['qualite'],
            'modelProduit' => $produits['model'],
            'quantite' => $quantite
        ];

        $_produit = $this->find($this->getID($produit), $table);
        if (!$_produit)
            throw new ExisteDataException ();
        if ($plus) {
            if ($table == 'boutique') {
                $_produit1 = $this->find($this->getID($produit), 'magasin');
                $produit['quantite'] = $_produit1->quantite - $quantite;
                if ($produit['quantite'] >= 0) {
                    $this->update($produit, 'magasin');
                    $erro = true;
                }
                $produit['quantite'] = $_produit->quantite + $quantite;
            } else {
                $erro = true;
                $produit['quantite'] = $_produit->quantite + $quantite;
            }
        } else {
            if (($_produit->quantite - $quantite ) >= 0) {
                $produit['quantite'] = $_produit->quantite - $quantite;
                $erro = true;
            }
        }
        if ($erro) {
            $this->update($produit, $table);
        }
        return $erro;
    }

}
