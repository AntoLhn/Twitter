<?php

namespace twitterapp\view;

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
            $return .= "<a class='tweet-control' href='".$url->urlFor('login')."'><img alt='followers' src='".$root."/html/img/followees.png'></a>                                  
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
                        <textarea style='width:100%; height:7rem;'></textarea>
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
        $followers = count($this->data);
        return" <h2>Tweets from</h2>
                <p>".$followers." followers</p>
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
            case 'folowwers':
                $section = $this->renderFollowers($selector);
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
        </section>
        <footer class="theme-backcolor1">${footer}</footer>
EOT;

        return $html;
    }
}
