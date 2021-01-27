<?php 
namespace App\Model;
/**
 * 
 */
class Authentification 
{
	
	function __construct()
	{
		# code...
	}


    /**
     * verifie si un utilisateur peut se connecter
     * authenfie l'utilisateur
     * @param String $login
     * @param String $passWord
    */
	public  static function login($login, $passWord) {
       
        $user = App::getDatabase()->query("SELECT * FROM user WHERE login = ? ",[$login],"App\Model\User",true);
        if($user){ 
            if (password_verify($passWord,$user->getPassWord())) {
                $_SESSION['connect'] = $user->getUserId();
                return true;
            }
        }
        return false;
    }
    
    /**
     * test si un utilisateur est connecté
     * @return type boolean
     */
    public static function logged()
    {
            return isset($_SESSION['connect']);
    }

}