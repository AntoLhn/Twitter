<?php

namespace mf\router;

use mf\auth\Authentification;
use mf\auth\exception\AuthentificationException;

class Router extends AbstractRouter {

    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        if(array_key_exists($this->http_req->path_info, self::$routes)){
            $url = $this->http_req->path_info;
        }else{
            $url = self::$aliases['default'];
        }
        $auth = new Authentification();
        if(!$auth->checkAccessRight(self::$routes[$url][2])) {
            $url = self::$aliases['default'];
        }
        $c_name = self::$routes[$url][0];
        $m_name = self::$routes[$url][1];
        $c = new $c_name();
        $c->$m_name();
    }

    public function urlFor($alias, $param_list = [])
    {
        //Récupère "Tweet/main.php"
        $url = $this->http_req->script_name;
        //Récupère l'url depuis l'alias
        $url .= self::$aliases[$alias];
        //Récupère chaîne de caractère des paramètres
        if(!empty($param_list)){
            $url .= "?";
            foreach ($param_list as $key => $value){
                $url .= $key."=".$value;
                if(count($param_list)>1){
                    $url .= "&";
                }
            }
        }
        return $url;
    }

    public function setDefaultRoute($url)
    {
        self::$aliases['default']=$url;
    }

    public function addRoute($name, $url, $ctrl, $mth, $access)
    {
        self::$routes[$url]=[$ctrl, $mth, $access];
        self::$aliases[$name]=$url;
    }

    public function executeRoute($alias){
        if(isset(self::$aliases[$alias])){
            $url = self::$aliases[$alias];
        }else{
            $url = self::$aliases['default'];
        }
        $auth = new Authentification();
        if(!$auth->checkAccessRight(self::$routes[$url][2])) {
            $url = self::$aliases['default'];
        }
        $c_name = self::$routes[$url][0];
        $m_name = self::$routes[$url][1];
        $c = new $c_name();
        $c->$m_name();
    }
}