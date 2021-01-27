<?php

namespace App\Controler;
use App\Model\App;
use App\Model\Produit;
use PDO;
/**
 * 
 */
class AdminControler extends AppControler
{
	
	function __construct()
	{
		parent::__construct();
		$this->template='template';
	}


	public function boutique()
	{
		new App();
       
		$this->render('admin.boutique');
		
	}

	public function magasin()
	{
		new App();
		
		$this->render('admin.magasin');
		
	}

	public function vente()
	{
		new App();
		$this->render('admin.vente');
		
	}
	public function login()
	{
		$this->render('login');
	}

	public function deconnexion()
	{
		new App();
		session_destroy();
		$this->render('login');
	}
}