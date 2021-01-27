<?php

namespace App\Controler;

use App\Model\App;
use App\Model\User;
use App\Model\Produit;
use App\Model\Facture;
use App\Model\Filter;
use App\Exceptions\ValidateException;
use App\Exceptions\ExisteDataException;

/**
 * 
 */
class CompteControler extends AppControler {

    function __construct() {
        parent::__construct();
        $this->template = 'compte/template';
    }

    public function compte() {
        new App();
        $this->render('compte.gerer_compte');
    }

    public function gererCompte() {
        new App();
        $this->render('compte.gerer_compte');
    }

    public function setPassWord() {
        new App();

        if (isset($_POST['lasspassword']) && isset($_POST['newpassword']) && isset($_POST['confirmpassword'])) {
            if ($_POST['newpassword'] === $_POST['confirmpassword']) {
                if (!User::setPassWord($_POST['lasspassword'],
                                $_POST['newpassword'])) {
                    $message['danger'] = 'echec de modification de mot de passe
					 car votre mot de passe est incorrect';
                } else {
                    $message['success'] = 'Mot de passe modifier avec Succes';
                }
            } else
                $message['danger'] = 'Les deux mot de passe doivent correspondre';
        }
        if (isset($message))
            $this->render('compte.gerer_compte', compact('message'));
        else
            $this->render('compte.gerer_compte');
    }

    public function setLogin() {
        new App();


        if (isset($_POST['login']) && isset($_POST['password'])) {

            if (!User::setLogin($_POST['login'], $_POST['password'])) {
                $message['danger'] = 'Echec de modification de votre login
				car votre mot de passe est incorrect';
            } else {
                $message['success'] = 'login modifier avec succes';
            }
        }
        if (isset($message))
            $this->render('compte.gerer_compte', compact('message'));
        else
            $this->render('compte.gerer_compte');
    }

    public function traitementVente() {
        new App();
        $listProduit = [];
        $ProduitNonVendu = [];
        if (!empty($_POST)) {
            $remise = is_int($_POST['remise']) ? $_POST['remise'] : 0;
            unset($_POST['remise']);
            $listeAchat = array_merge($_POST);
            foreach ($listeAchat as $key => $value) {
                $keys = explode('_', $key);
                $val = self::is_int($value) ? $value : 0;
                if ($val > 0) {
                    $p = [
                        'typeProduit' => $keys[0],
                        'modelProduit' => $keys[1],
                        'qualiteProduit' => $keys[2],
                        'quantite' => $val
                    ];
                    if ((new Produit())->ajoutOrRetrait($p, false, 'boutique')) {
                        $listProduit[] = $p;
                    } else {
                        $ProduitNonVendu[] = $p;
                    }
                }
            }
            if ($listProduit != []) {
                (new Facture())->
                        save($listProduit, $remise);
            }
        }
        $this->render('compte.traitement_vent',
                compact('listProduit', 'ProduitNonVendu'));
    }

    public function depotProduit() {
        new App();
        $page = 'form_generator';
        $nombre = 0;
        $statut = false;
        if (!empty($_POST)) {
            $page = 'form_genered';
            $nombre = isset($_POST['quantiteProduit']) &&
                    self::is_int($_POST['quantiteProduit']) ? $_POST['quantiteProduit'] : 0;
            $statut = isset($_POST['statut']) ? $_POST['statut'] == 'nouveau' : false;
        }
        $this->render('compte.DepotProduit', compact('page', 'nombre', 'statut'));
    }

    public function test() {
        $this->render('compte.test');
    }

    public function traitementDepot() {
        new App();

        if (!empty($_POST) && isset($_GET['depot'])) {
            $nb_repeat = $_GET['depot'] == 'nouveau' ? 6 : 5;
            $nombre = count($_POST) / $nb_repeat;
            $page = 'form_genered';
            $statut = ($nb_repeat == 6) ? 'nouveau' : 'existant';
            $nb_error = false;
            try {
                $this->validate($_POST);
                $nb_error = 0;
                for ($i = 0; $i < count($_POST) / $nb_repeat; $i++) {
                    $produit = [];
                    $produit['type'] = $_POST['type' . $i];
                    $produit['qualite'] = $_POST['qualiteProduit' . $i];
                    $produit['model'] = $_POST['model' . $i];
                    $produit['marque'] = $_POST['marque' . $i];
                    $produit['quantite'] = $_POST['quantiteProduit' . $i];
                    if ($nb_repeat == 6) {
                        $produit['prix'] = $_POST['prix' . $i];
                        $nb_error += $this->saveProduit($produit);
                    } else {
                        $nb_error += $this->addProduit($produit, 'magasin');
                    }
                }
            } catch (ValidateException $ex) {
                
            }
            if ($nb_error === 0) {
                $_SESSION['success'] = 'Opération reussi avec succes';
                $this->template = 'template';
                $this->render('admin.magasin');
            } else {
                Filter::error($_SESSION['error']);
                $this->render('compte.DepotProduit', compact('nombre', 'page', 'statut'));
            }
        } else {
            $page = 'form_generator';
            $this->render('compte.DepotProduit', compact('page'));
        }
    }

    function retrait() {
        new App();
        $page = 'form_generator';
        $nombre = isset($_POST['quantiteProduit']) ? $_POST['quantiteProduit'] : 0;
        if (!empty($_POST)) {
            $page = 'form_genered';
        }
        $this->render('compte.Retrait', compact('page', 'nombre'));
    }

    public function traitementRetrait() {
        new App();
        if (!empty($_POST)) {
            $page = 'form_genered';
            $nombre = count($_POST) / 5;
            $nb_error = false;
            try {
                $this->validate($_POST);
                $nb_error = 0;
                for ($i = 0; $i < count($_POST) / 5; $i++) {
                    $produit = [];
                    $produit['type'] = $_POST['type' . $i];
                    $produit['qualite'] = $_POST['qualiteProduit' . $i];
                    $produit['model'] = $_POST['model' . $i];
                    $produit['marque'] = $_POST['marque' . $i];
                    $produit['quantite'] = $_POST['quantiteProduit' . $i];
                    $nb_error += $this->addProduit($produit);
                }
            } catch (ValidateException $ex) {
                
            }
            if ($nb_error === 0) {
                $_SESSION['success'] = 'Opération reussi avec succes';
                $this->template = 'template';
                $this->render('admin.boutique');
            } else {
                Filter::error($_SESSION['error']);
                $this->render('compte.Retrait', compact('nombre', 'page'));
            }
        }
    }

    private function saveProduit($produit) {
        try {
            (new Produit)->save($produit);
            return 0;
        } catch (ExisteDataException $ex) {
            $_SESSION['error'][] = "le/la " . $produit['type'] . " model " . $produit['model'] . ' exite deja';
        }
        return 1;
    }

    private function addProduit($produit, $table = 'boutique') {
        try {
            (new Produit)->ajoutOrRetrait($produit, true, $table);
            return 0;
        } catch (ExisteDataException $exc) {
            $_SESSION['error'][] = "le/la " . $produit['type'] . ' model ' . $produit['model'] . ' n\'existe pas';
        }
        return 1;
    }

}
