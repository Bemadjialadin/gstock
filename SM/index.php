<?php 
    session_start();
    require 'App/Autoloader.class.php';
    use App\Autoloader;
    use App\Controler\AuthControler;
    use App\Model\Magasin;
    use App\Controler\AdminControler;
    use App\Controler\CompteControler;
    Autoloader::register();
     if(!isset($_GET['page'])){
            $_GET['page'] = 'login';
           (new AdminControler())->login();
        }else if (isset($_GET['page'])) {

            if($_GET['page'] === "login"){
                (new AdminControler())->login();
        }
        else if($_GET['page'] === "acceuil"){
            (new AuthControler())->index();
        }
        else  if ($_GET['page']==='boutique') {
            (new AdminControler())->boutique();
        }
        else if ($_GET['page']==='magasin') {
            (new AdminControler())->magasin();
        }
        else if ($_GET['page']==='compte') {
            (new CompteControler())->compte();
        }
        else if ($_GET['page']==='modifier_password') {
            (new CompteControler())->setPassword();
        }
        else if($_GET['page']==='gerer_compte'){
            (new CompteControler())->gererCompte();
        }
        else if($_GET['page']==='compte_modifier'){
            require 'Views/compte/modifier.php';
        }
        else if($_GET['page']==='modifier_login'){
           (new CompteControler())->setLogin();
        }
        else if ($_GET['page']==='vente') {
            (new AdminControler())->vente();
        } 
        else if($_GET['page'] === "deconnexion"){
             $_GET['page'] = 'login';
           (new AdminControler())->deconnexion();
        }
        else if($_GET['page']==='traitement_vente'){
           (new CompteControler())->traitementVente();
        }
        else if($_GET['page']==='DepotProduit'){
           (new CompteControler())->depotProduit();
        }
        else if($_GET['page']==='test'){
           (new CompteControler())->test();
        }
        else if($_GET['page']==='save_produit'){
           (new CompteControler())->traitementDepot();
        }
        else if($_GET['page']==='retrait'){
           (new CompteControler())->retrait();
        }
         else if($_GET['page']==='ajout'){
           (new CompteControler())->traitementRetrait();
        }
        else{
            echo "paage introuvable";
        }
    }
    
    
