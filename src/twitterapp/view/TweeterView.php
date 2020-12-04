<?php

namespace twitterapp\view;

use mf\auth\Authentification;
use \twitterapp\model\Tweet;
use \twitterapp\model\User;
use \mf\router\Router;
use \mf\view\AbstractView;

class TweeterView extends AbstractView {

    public function __construct( $data ){
        parent::__construct($data);
    }

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

    private function renderHome(){
        $titre = "<h2>Latest Tweets</h2>";
        $selector =
        $selector = $this->foreachTweets($this->data);
        return $titre."".$selector;
    }

    private function renderUserTweets(){
        $titre = "No tweet to display";
        foreach ($this->data as $tweet) {
                $user = $tweet->author()->first();
                $titre = "<h2>All Tweets of " . $user->fullname . "</h2>";
        }

        $selector = $this->foreachTweets($this->data);
        return $titre."".$selector;

    }

    private function renderViewTweet(){
        $url = new Router();
        $user = $this->data->author()->first();
        return "<h2>The tweets of ".$user->fullname."</h2>
                <div class='tweet'>
                    <a href='".$url->urlFor('tweet',['id'=> $this->data->id])."'>
                        <div class='tweet-text'>".$this->data->text."</div>
                    </a>
                    <div class='tweet-footer'>
                        <span class='tweet-timestamp'>".$this->data->created_at."</span>
                        <span class='tweet-timestamp'> | Like(s) ".$this->data->score."</span>
                        <span class='tweet-author'>
                            <a href='".$url->urlFor('userTweets',['id'=> $user->id])."'>".$user->fullname."</a>
                        </span>
                    </div>
                </div></br>";
    }

    protected function renderPostTweet(){
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
                    <input class="forms-text" type="text" name="username" placeholder="username" data-kwimpalastatus="alive" data-kwimpalaid="1606561641230-1" style="background-color: rgb(255, 255, 204); color: rgb(49, 49, 49);" required>
                    <input class="forms-text" type="password" name="password" placeholder="password" data-kwimpalastatus="alive" data-kwimpalaid="1606561641230-0" style="background-color: rgb(255, 255, 204); color: rgb(49, 49, 49);" required>
                    <button class="forms-button" name="login_button" type="submit">Login</button>
                </form>';
    }

    protected function renderSignup(){
        $url = new Router();
        return'  <h2>Signup</h2>
                 <form class="forms" action="'.$url->urlFor('checkSignup').'" method="post">
                    <input class="forms-text" type="text" name="fullname" placeholder="full Name" data-kwimpalastatus="alive" data-kwimpalaid="1606565928128-2" required>
                    <input class="forms-text" type="text" name="username" placeholder="username" data-kwimpalastatus="alive" data-kwimpalaid="1606565928128-3" required>
                    <input class="forms-text" type="password" name="password" placeholder="password" data-kwimpalastatus="alive" data-kwimpalaid="1606565928128-0" required>
                    <input class="forms-text" type="password" name="password_verify" placeholder="retype password" data-kwimpalastatus="alive" data-kwimpalaid="1606565928128-1" required>
                
                    <button class="forms-button" name="login_button" type="submit">Create</button>
                </form>';
    }

    protected function renderFollowers(){
        $url = new Router();
        $return = "";
        foreach ($this->data as $follower){
            $user = User::select()->where('id','=',$follower->followee)->first();
            $return .= "<li><a href='".$url->urlFor('userTweets',['id'=> $user->id])."'>".$user->fullname."</a></li>";
        }
        return" <h2>Currently following</h2>
                <i>".count($this->data)." followers</i>
                <ul style='text-align: left; padding-left: 43%;'>
                    ".$return."
                </ul>
        ";
    }

    public function renderProfil(){
        $url = new Router();
        $root = $url->http_req->root;
        $followers = "";
        foreach ($this->data as $follower){
            $users = User::select()->where('id','=',$follower->follower)->first();
            $followers .= "<li><a href='".$url->urlFor('userTweets',['id'=> $users->id])."'>".$users->fullname."</a></li>";
        }
        $auth = new Authentification();
        $id = User::select('id')->where('username','=',$auth->user_login)->first();
        $tweetUser = Tweet::select()->where('author','=',$id['id'])->get();
        $mypost = $this->foreachTweets($tweetUser);
        if(empty($mypost)){
            $mypost ="<i>No tweet for the moment</i></br>
                      <a href='".$url->urlFor('post')."'>Publish a new post</a>";
        }
        $user = User::select()->where('username','=',$_SESSION['user_login'])->first();
        return" <div style='border: 1px solid; width: 100px; height: 100px; margin: 10px auto; border-radius: 50%; padding: 5%; background-color: #09c;'>
                    <img alt='followers' src='".$root."/html/img/followees.png' width='80px' height='80px'>
                    <h2>".$user->fullname."</h2>
                </div>
                <h3>They follow me</h3>
                <ul style='text-align: left; padding-left: 43%;'>
                    ".$followers."
                </ul>
                <h2>My posts </h2>
                ".$mypost;
    }

    private function foreachTweets($tweets){
        $url = new Router();
        $selector = "";
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

    public function renderNav()
    {
        $auth = new Authentification();
        if($auth->logged_in === TRUE){
            $url = new Router();
            return '<div id="nav-menu">
                        <div class="button theme-backcolor2">
                        <a href="'.$url->urlFor('post').'">Publish a new post</a>
                        </div>
                    </div>';
        }
    }

    private function renderFooter(){
        return 'Une app créée en Licence Pro &copy;2020';
    }

    
    protected function renderBody($selector){
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
