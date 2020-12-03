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
        $vue->render('login');
    }

    public function checkLogin(){
        if(isset($this->request->post['username']) && isset($this->request->post['password'])){
            $username = $this->request->post['username'];
            $password = $this->request->post['password'];
            try {
                $auth = new TweeterAuthentification;
                $auth->loginUser($username, $password);
            } catch (AuthentificationException $e) {
                (new \mf\router\Router)->executeRoute('login');
            }
            $vue = new TweeterView($auth);
            $vue->render('profil');
        }else{
            (new \mf\router\Router)->executeRoute('default');
        }
    }

    public function logout(){
        (new TweeterAuthentification)->logout();
        (new \mf\router\Router)->executeRoute('default');
    }

    public function signup(){
        $users = User::all();
        $vue = new TweeterView($users);
        $vue->render('signup');
    }

    public function checkSignup(){

        if (isset($this->request->post['fullname']) && isset($this->request->post['username']) && isset($this->request->post['password']) && isset($this->request->post['password_verify'])) {
            if ($this->request->post['password'] == $this->request->post['password_verify']) {
                $fullname = $this->request->post['fullname'];
                $username = $this->request->post['username'];
                $password = $this->request->post['password'];
                $auth = new TweeterAuthentification;
                try {
                    $auth->createUser($fullname, $username, $password);
                } catch (AuthentificationException $e){
                    echo $e->getMessage();
                    (new \mf\router\Router)->executeRoute('signup');
                }
                $vue = new TweeterView($auth);
                $vue->render('followrs');
            }
            else{
                (new \mf\router\Router)->executeRoute('signup');
            }
        }else{
            (new \mf\router\Router)->executeRoute('signup');
        }
    }
}