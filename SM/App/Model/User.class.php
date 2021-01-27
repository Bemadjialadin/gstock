<?php


namespace App\Model;

/**
 * User
 * represente les utilisateur
 */
class User extends Model {
 
    /**
     * 
     * @return int
     */
    public function getUserId() {
        return $this->id;
    }

    /**
     * 
     * @return String
     */
    public function getLogin() {
        return $this->_login;
    }
    /**
     * 
     * @param type $login
     */
    public static function setLogin($login,$password) {
        $user = self::getDB()->query("select * from user
         where id=?",[$_SESSION['connect']],
         get_called_class(),true);

        if($user){
            if (password_verify($password, $user->getPassWord())) {

               return self::getDB()->query('UPDATE  user 
                SET login = ? WHERE id = ?', [$login,$user->getUserId()]);
            }
        }
       return false;
    }
    /**
     * 
     * @return String
     */
    function getPassWord() {
        return $this->passWord;
    }
    /**
     * 
     * @param type $passWord
     */
    public static function setPassWord($lastpassword,$passWord) {
         $user = self::getDB()->query("select * from user
         where id=?",[$_SESSION['connect']],
         get_called_class(),true);
         if($user){
            if (password_verify($lastpassword, $user->getPassWord())) {
               return self::getDB()->query('UPDATE  user SET password = ? WHERE id = ?', 
                [password_hash($passWord, PASSWORD_DEFAULT),$user->getId()]);
            }
        }
        return false;
    }

}

?>