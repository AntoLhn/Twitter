<?php

namespace twitterapp\view;

use mf\auth\Authentification;
use \twitterapp\model\Tweet;
use \twitterapp\model\User;
use \mf\router\Router;
use \mf\utils\HttpRequest;

class TweeterView extends \mf\view\AbstractView {
  
    /* Constructeur 
    *
    * Appelle le constructeur de la classe parent
    */
    public function __construct( $data ){
        parent::__construct($data);
    }

    /* Méthode renderHeader
     *
     *  Retourne le fragment HTML de l'entête (unique pour toutes les vues)
     */ 
    private function renderHeader(){
        $url = new Router();
        $root = $url->http_req->root;
        $return = " <h1>MiniTweeTR</h1>
                    <nav id='navbar'>
                        <a class='tweet-control' href='".$url->urlFor('home')."'><img alt='home' src='".$root."/html/img/home.png'></a>";
        if (isset($_SESSION['user_login'])){
            $return .= "<a class='tweet-control' href='".$url->urlFor('profil')."'><img alt='followees' src='".$root."/html/img/followees.png'></a>                                  
                       <a class='tweet-control' href='".$url->urlFor('followers')."'><img alt='followers' src='".$root."/html/img/followers.png'></a>                                  
                       <a class='tweet-control' href='".$url->urlFor('logout')."'><img alt='logout' src='".$root."/html/img/logout.png'></a>                                  
                    </nav>";
        }else{
            $return .= "<a class='tweet-control' href='".$url->urlFor('login')."'><img alt='login' src='".$root."/html/img/login.png'></a>                                  
                       <a class='tweet-control' href='".$url->urlFor('signup')."'><img alt='signup' src='".$root."/html/img/signup.png'></a>                                  
                    </nav>";
        }
        return $return;
    }
    
    /* Méthode renderFooter
     *
     * Retourne le fragment HTML du bas de la page (unique pour toutes les vues)
     */
    private function renderFooter(){
        return 'Une app créée en Licence Pro &copy;2020';
    }

    /* Méthode renderHome
     *
     * Vue de la fonctionalité afficher tous les Tweets. 
     *  
     */

    private function renderHome(){

        /*
         * Retourne le fragment HTML qui affiche tous les Tweets. 
         *  
         * L'attribut $this->data contient un tableau d'objets tweet.
         *
         */
        $title = "Latest Tweets";
        return $this->foreachTweets($this->data, $title);
        
        
    }
  
    /* Méthode renderUeserTweets
     *
     * Vue de la fonctionalité afficher tout les Tweets d'un utilisateur donné. 
     * 
     */

    private function renderUserTweets(){

        /* 
         * Retourne le fragment HTML pour afficher
         * tous les Tweets d'un utilisateur donné. 
         *  
         * L'attribut $this->data contient un objet User.
         *
         */
        foreach ($this->data as $tweet) {
            $user = $tweet->author()->first();
            $title = "All Tweets of ".$user->fullname;
        }
        return $this->foreachTweets($this->data, $title);
        
    }
  
    /* Méthode renderViewTweet 
     * 
     * Rréalise la vue de la fonctionnalité affichage d'un tweet
     *
     */

    private function foreachTweets($tweets, $title){
        $selector = "<h2>".$title."</h2>";
        $url = new Router();
        foreach ($tweets as $tweet) {
            $user = $tweet->author()->first();
            $selector .= "<div class='tweet'>
                            <a href='".$url->urlFor('tweet',['id'=> $tweet->id])."'>
                                <div class='tweet-text'>".$tweet->text."</div>
                            </a>
                            <div class='tweet-footer'>
                                <span class='tweet-timestamp'>".$tweet->created_at."</span>
                                <span class='tweet-timestamp'> | Like(s) ".$tweet->score."</span>
                                <span class='tweet-author'>
                                    <a href='".$url->urlFor('userTweets',['id'=> $user->id])."'>".$user->fullname."</a>
                                </span>
                            </div>
                          </div></br>";
        }
        return $selector;
    }

    private function renderViewTweet(){

        /* 
         * Retourne le fragment HTML qui réalise l'affichage d'un tweet 
         * en particulié 
         * 
         * L'attribut $this->data contient un objet Tweet
         *
         */
        $url = new Router();
        $user = $this->data->author()->first();
        return "<h2>The tweets of ".$user->fullname."</h2>
                <div class='tweet'>
                    <a href='".$url->urlFor('tweet',['id'=> $this->data->id])."'>
                        <div class='tweet-text'>".$this->data->text."</div>
                    </a>
                    <div class='tweet-footer'>
                        <span class='tweet-timestamp'>".$this->data->created_at."</span>
                        <span class='tweet-author'>
                            <a href='".$url->urlFor('userTweets',['id'=> $user->id])."'>".$user->fullname."</a>
                        </span>
                    </div>
                </div></br>";
    }

    /* Méthode renderPostTweet
     *
     * Realise la vue de régider un Tweet
     *
     */

    protected function renderPostTweet(){
        
        /* Méthode renderPostTweet
         *
         * Retourne la framgment HTML qui dessine un formulaire pour la rédaction 
         * d'un tweet, l'action (bouton de validation) du formulaire est la route "/send/"
         *
         */
        $url = new Router();
        return" <div id='tweet-form'>
                    <form method='post' action='".$url->urlFor('send')."'>
                        <textarea style='width:100%; height:7rem;' name='text'></textarea>
                        <input id='send_button' type='submit' name='send' value='send'>
                    </form>                    
                </div>";
    }

    protected function renderLogin(){
        $url = new Router();
        return' <h2>Login</h2>
                <form class="forms" action="'.$url->urlFor('checkLogin').'" method="post">
                    <input class="forms-text" type="text" name="username" placeholder="username" data-kwimpalastatus="alive" data-kwimpalaid="1606561641230-1" style="background-color: rgb(255, 255, 204); color: rgb(49, 49, 49);">
                    <input class="forms-text" type="password" name="password" placeholder="password" data-kwimpalastatus="alive" data-kwimpalaid="1606561641230-0" style="background-color: rgb(255, 255, 204); color: rgb(49, 49, 49);">
                    <button class="forms-button" name="login_button" type="submit">Login</button>
                </form>';
    }

    protected function renderFollowers(){
        $url = new Router();
        $return = "";
        foreach ($this->data as $follower){
            $user = User::select()->where('id','=',$follower->followee)->first();
            $return .= "<a href='".$url->urlFor('userTweets',['id'=> $user->id])."'><li>".$user->username."</li></a>";
        }
        return" <h2>Currently following</h2>
                <i>".count($this->data)." followers</i>
                <ul>
                    ".$return."
                </ul>
        ";
    }

    protected function renderSignup(){
        $url = new Router();
        return'  <h2>Signup</h2>
                 <form class="forms" action="'.$url->urlFor('checkSignup').'" method="post">
                    <input class="forms-text" type="text" name="fullname" placeholder="full Name" data-kwimpalastatus="alive" data-kwimpalaid="1606565928128-2">
                    <input class="forms-text" type="text" name="username" placeholder="username" data-kwimpalastatus="alive" data-kwimpalaid="1606565928128-3">
                    <input class="forms-text" type="password" name="password" placeholder="password" data-kwimpalastatus="alive" data-kwimpalaid="1606565928128-0">
                    <input class="forms-text" type="password" name="password_verify" placeholder="retype password" data-kwimpalastatus="alive" data-kwimpalaid="1606565928128-1">
                
                    <button class="forms-button" name="login_button" type="submit">Create</button>
                </form>';
    }

    public function renderProfil(){
        $url = new Router();
        $root = $url->http_req->root;
        $followers = "";
        foreach ($this->data as $follower){
            $user = User::select()->where('id','=',$follower->follower)->first();
            $followers .= "<a href='".$url->urlFor('userTweets',['id'=> $user->id])."'><li>".$user->username."</li></a>";
        }
        $auth = new Authentification();
        $id = User::select('id')->where('username','=',$auth->user_login)->first();
        $tweetUser = Tweet::select()->where('author','=',$id['id'])->get();
        $title = "My posts ";
        return" <div style='border: 1px solid; width: 100px; height: 100px; margin: 10px auto; border-radius: 50%; padding: 5%; background-color: #09c;'>
                    <img alt='followers' src='".$root."/html/img/followees.png' width='80px' height='80px'>
                    <h2>".$_SESSION['user_login']."</h2>
                </div>
                <h3>They follow me</h3>
                <ul>
                    ".$followers."
                </ul>
                ".$this->foreachTweets($tweetUser, $title);
    }

    public function renderNav()
    {
        $auth = new Authentification();
        if($auth->logged_in === TRUE){
            $url = new Router();
            return '<div id="nav-menu">
                        <div class="button theme-backcolor2">
                        <a href="'.$url->urlFor('post').'">New</a>
                        </div>
                    </div>';
        }
    }

    /* Méthode renderBody
     *
     * Retourne la framgment HTML de la balise <body> elle est appelée
     * par la méthode héritée render.
     *
     */
    
    protected function renderBody($selector){

        /*
         * voire la classe AbstractView
         * 
         */
        $header = $this->renderHeader();
        $footer = $this->renderFooter();
        $nav = $this->renderNav();

        switch ($selector) {
            case 'home':
                $section = $this->renderHome($selector);
                break;
            case 'tweet':
                $section = $this->renderViewTweet($selector);
                break;
            case 'userTweets':
                $section = $this->renderUserTweets($selector);
                break;
            case 'post':
                $section = $this->renderPostTweet($selector);
                break;
            case 'login':
                $section = $this->renderLogin($selector);
                break;
            case 'followers':
                $section = $this->renderFollowers($selector);
                break;
            case 'profil':
                $section = $this->renderProfil($selector);
                break;
            case 'signup':
                $section = $this->renderSignup($selector);
                break;
            default: $section = $this->renderHome($selector);

        }
        $html = <<<EOT
        <header class="theme-backcolor1">${header}</header>
        <section>
            <article class="theme-backcolor2">
                ${section}
            </article>
            <nav id="menu" class="theme-backcolor1"> 
                ${nav}     
            </nav>
        </section>
        <footer class="theme-backcolor1">${footer}</footer>
EOT;

        return $html;
    }
}
