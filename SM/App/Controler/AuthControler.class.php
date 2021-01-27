<?php 

namespace App\Controler;
use App\Model\Authentification;
/**
 * 
 */
class AuthControler extends AppControler
{
	
	function __construct()
	{
		parent::__construct();
		$this->template = 'template';
	}

	public function index()
	{
		if(isset($_POST['login'])&&isset($_POST['password']))
            self::login($_POST);
        if(!Authentification::logged())
            header("location:index.php?page=login");
        $this->render('admin.acceuil');
	}
	
	private static function login($_post){
		if (!Authentification::login($_post['login'],$_post['password'])) {
			header("location:index.php?page=login");
		}
		
	}
}