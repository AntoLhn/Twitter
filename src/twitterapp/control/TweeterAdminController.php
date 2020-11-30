<?php


namespace twitterapp\control;

use twitterapp\auth\TweeterAuthentification;
use mf\auth\exception\AuthentificationException;
use twitterapp\view\TweeterView;
use mf\control\AbstractController;
use twitterapp\model\User;

class TweeterAdminController extends AbstractController
{
    public function login(){
        $users = User::all();
        $vue = new TweeterView($users);
        return $vue->render('login');
    }

    public function checkLogin(){
        if(isset($this->request->get['username']) && isset($this->request->get['password'])){
            $username = $this->request->get['username'];
            $password = $this->request->get['password'];
            try {
                $auth = new TweeterAuthentification;
                $auth->loginUser($username, $password);
            } catch (AuthentificationException $e) {
                throw new AuthentificationException(get_called_class()." : Connexion impossible : l'utilisateur ou mot de passe incorrect");
            }
            $vue = new TweeterView($auth);
            return $vue->render('followers');
        }else{
            (new \mf\router\Router)->executeRoute('default');
        }
    }

    public function logout(){
        session_destroy();
        (new \mf\router\Router)->executeRoute('default');
    }

    public function signup(){
        $users = User::all();
        $vue = new TweeterView($users);
        return $vue->render('signup');
    }

    public function checkSignup(){
        if (isset($this->request->get['fullname']) && isset($this->request->get['username']) && isset($this->request->get['password']) && isset($this->request->get['password_verify'])) {
            if ($this->request->get['password'] == $this->request->get['password_verify']) {
                $fullname = $this->request->get['fullname'];
                $username = $this->request->get['username'];
                $password = $this->request->get['password'];
                try {
                    $auth = new TweeterAuthentification;
                    $auth->createUser($fullname, $username, $password);
                } catch (AuthentificationException $e){
                    throw new AuthentificationException(get_called_class()." : L'inscription a échouée : vérifier vos informations");
                }
                $vue = new TweeterView($auth);
                return $vue->render('followers');
            }
        }else{
            (new \mf\router\Router)->executeRoute('default');
        }
    }
}