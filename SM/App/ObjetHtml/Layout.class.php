<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\ObjetHtml;

/**
 * Description of Layout
 *
 * @author admin
 */
class Layout{
   
    private $tagform ;
    public function __construct(){
        $this->tagform = new Form();
    }


    /**
     * renvoie l'entete de la page
     * @param String $titre_page
     */
    public function getHeader($titre_page) {
        $this->tagform->openTag('header');
        $this->tagform->openTag('div' , 'container');
        $this->tagform->openTag('div' , 'bg row' );
        $this->tagform->openTag('div', 'col-md-3 col-xs-12');
        $this->tagform->openTag('div' , 'logo');
        $this->tagform->img('img', 'static/image/logo.png' , 'img-fuid d-block w-50' , 'logo' , 'margin-top: 10Px; height: auto');
        $this->tagform->closeTag('div');
        $this->tagform->closeTag('div');
        $this->tagform->openTag('div' , 'col-md-9 col-xs-12 col text-center');
        $this->tagform->openTag('h4', 'titre');
        echo $titre_page;
        $this->tagform->closeTag('h4');
         if($titre_page!=''){
            $this->tagform->openTag('div' , 'deconnexion');
            $this->tagform->buttonMake('index.php?page=deconnexion','',"Déconnection", 'btn btn-light');
            $this->tagform->closeTag('div');
        } 
        $this->tagform->closeTag('div');
        $this->tagform->closeTag('div');
        $this->tagform->closeTag('div');
        $this->tagform->closeTag('header');
        
    }
    
    /**
     * renvoie le footer de la page
     */
    public function getFooter() {
        $this->tagform->openTag('footer', 'f', 'margin-top: 150px');
        $this->tagform->openTag('div', 'container');
        $this->tagform->openTag('div', 'row');
        $this->tagform->openTag('div', 'col text-center');
        $this->tagform->openTag('h1', 'text-white text-capitalize font-weight-light p-3');
        echo 'Stock Manager';
        $this->tagform->closeTag('h1');
        $this->tagform->openTag('p' , 'text-light py-4 m-0');
        echo 'Copyright 2020 by The Ants';

        $this->tagform->closeTag('p');
        $this->tagform->closeTag('div');
        $this->tagform->closeTag('div');
        $this->tagform->closeTag('div');
        $this->tagform->closeTag('footer');
    }
    
    /**
     * renvoie le formulaire de connexion
     */
    public function LoginForm($login)
    {
        $this->tagform->openTag('section', 'container-fluid' , 'height:auto');
        $this->tagform->openTag('article', 'row justify-content-center');
        $this->tagform->openTag('div', 'col-12 col-sm-6 col-md-6');
        $this->tagform->formOpen('post', 'index.php?page=acceuil' , 'form-container' , 'margin-top: 60px');
        $this->tagform->openTag('div' , 'form-group');
        $this->tagform->label('login', 'Login');
        $this->tagform->input('text', 'login', $login, 'login' , 'form-control');
        $this->tagform->closeTag('div');
        $this->tagform->openTag('div' , 'form-group');
        $this->tagform->label('password', 'Mot de Passe');
        $this->tagform->input('password', 'password', null, 'password' , 'form-control');
        $this->tagform->closeTag('div');
        $this->tagform->input('submit', 'connecter', 'Se connecter' , null, 'btn btn-info');
        $this->tagform->input('reset', 'reset', 'Réinitialiser', null, 'btn btn-info', 'float: right;');
        $this->tagform->closeTag('form');
        $this->tagform->closeTag('div');
        $this->tagform->closeTag('article');
        $this->tagform->closeTag('section');
    }
    /**
     * 
     * @param type $value
     * @param type $class
     * @param type $url
     */
    public function getButton($value, $class,$url='#')
    {
        $this->tagform->openTag('section', 'container-fluid' , 'height:auto');
        $this->tagform->openTag('article', 'row justify-content-center' , 'margin-top: 60px');
        $this->tagform->openTag('div', 'col-12 col-sm-6 col-md-6');
        $this->tagform->buttonMake($url, 'button', $value , $class);
        $this->tagform->closeTag('div');
        $this->tagform->closeTag('article');
        $this->tagform->closeTag('section');
    }

}

    
