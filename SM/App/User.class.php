<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;
use App\Model\Model;

/**
 * Description of User
 *
 * @author ANF5-PC
 */
class User extends Model{
           
     protected static $table = "user";

    public function getLogin(){
        return $this->login;
}

    //put your code here

}
