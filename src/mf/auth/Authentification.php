<?php

namespace mf\auth;
session_start();

use mf\auth\exception\AuthentificationException;

class Authentification extends AbstractAuthentification{

    public function __construct(){
        if(isset($_SESSION['user_login'])){
            $this->user_login = $_SESSION['user_login'];
            $this->user_login = $_SESSION['access_level'];
            $this->logged_in = true;
        }else {
            $this->user_login = null;
            $this->access_level = self::ACCESS_LEVEL_NONE;
            $this->logged_in = false;
        }
    }

    protected function updateSession($username, $level)
    {
        // TODO: Implement updateSession() method.
        $this->user_login  = $username;
        $this->access_level = $level;
        $_SESSION['user_login'] = $username;
        $_SESSION['access_level'] = $level;
        $this->logged_in = true;
    }

    public function logout()
    {
        // TODO: Implement logout() method.
        session_destroy();
        $this->logged_in = false;
    }

    public function checkAccessRight($requested)
    {
        // TODO: Implement checkAccessRight() method.
        if($requested > $this->access_level){
            return false;
        }else{
            return true;
        }
    }

    public function login($username, $db_pass, $given_pass, $level)
    {
        // TODO: Implement login() method.
        if ($this->verifyPassword($given_pass, $db_pass) == true) {
            $this->updateSession($username, $level);
        } else {
            throw new AuthentificationException(get_called_class()." : Connexion impossible : mot de passe incorrect");
        }
    }

    protected function hashPassword($password)
    {
        // TODO: Implement hashPassword() method.
        password_hash($password, PASSWORD_DEFAULT);
    }

    protected function verifyPassword($password, $hash)
    {
        // TODO: Implement verifyPassword() method.

        if (password_verify($password, $hash)) {
            return true;
        } else {
            return false;
        }
    }
}