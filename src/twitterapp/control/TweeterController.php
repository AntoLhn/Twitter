<?php

namespace twitterapp\control;
use mf\auth\Authentification;
use mf\auth\exception\AuthentificationException;
use twitterapp\model\Follow;
use \twitterapp\model\User;
use \twitterapp\model\Tweet;
use \twitterapp\view\TweeterView;
use \mf\router\Router;
use \mf\control\AbstractController;

/* Classe TweeterController :
 *  
 * Réalise les algorithmes des fonctionnalités suivantes: 
 *
 *  - afficher la liste des Tweets 
 *  - afficher un Tweet
 *  - afficher les tweet d'un utilisateur 
 *  - afficher la le formulaire pour poster un Tweet
 *  - afficher la liste des utilisateurs suivis 
 *  - évaluer un Tweet
 *  - suivre un utilisateur
 *   
 */

class TweeterController extends AbstractController {


    /* Constructeur :
     * 
     * Appelle le constructeur parent
     *
     * c.f. la classe \mf\control\AbstractController
     * 
     */
    
    public function __construct(){
        parent::__construct();
    }


    /* Méthode viewHome : 
     * 
     * Réalise la fonctionnalité : afficher la liste de Tweet
     * 
     */
    
    public function viewHome(){

        /* Algorithme :
         *  
         *  1 Récupérer tout les tweet en utilisant le modèle Tweet
         *  2 Parcourir le résultat 
         *      afficher le text du tweet, l'auteur et la date de création
         *  3 Retourner un block HTML qui met en forme la liste
         * 
         */
        $tweets = Tweet::select()->orderBy('created_at', 'desc')->get();
        $vue = new TweeterView($tweets);
        $vue->render('home');
    }


    /* Méthode viewTweet : 
     *  
     * Réalise la fonctionnalité afficher un Tweet
     *
     */
    
    public function viewTweet(){

        /* Algorithme : 
         *  
         *  1 L'identifiant du Tweet en question est passé en paramètre (id) 
         *      d'une requête GET 
         *  2 Récupérer le Tweet depuis le modèle Tweet
         *  3 Afficher toutes les informations du tweet 
         *      (text, auteur, date, score)
         *  4 Retourner un block HTML qui met en forme le Tweet
         * 
         *  Erreurs possibles : (*** à implanter ultérieurement ***)
         *    - pas de paramètre dans la requête
         *    - le paramètre passé ne correspond pas a un identifiant existant
         *    - le paramètre passé n'est pas un entier 
         * 
         */
        if(isset($this->request->get['id'])) {
            $id = $this->request->get['id'];
            $tweet = Tweet::where('id', '=', $id)->first();
            $vue = new TweeterView($tweet);
            $vue->render('tweet');
        }else{
            (new \mf\router\Router)->executeRoute('default');
        }
    }


    /* Méthode viewUserTweets :
     *
     * Réalise la fonctionnalité afficher les tweet d'un utilisateur
     *
     */

    public function viewUserTweets(){

        /*
         *
         *  1 L'identifiant de l'utilisateur en question est passé en 
         *      paramètre (id) d'une requête GET 
         *  2 Récupérer l'utilisateur et ses Tweets depuis le modèle 
         *      Tweet et User
         *  3 Afficher les informations de l'utilisateur 
         *      (non, login, nombre de suiveurs) 
         *  4 Afficher ses Tweets (text, auteur, date)
         *  5 Retourner un block HTML qui met en forme la liste
         *
         *  Erreurs possibles : (*** à implanter ultérieurement ***)
         *    - pas de paramètre dans la requête
         *    - le paramètre passé ne correspond pas a un identifiant existant
         *    - le paramètre passé n'est pas un entier 
         * 
         */
        if(isset($this->request->get['id'])){
            $id = $this->request->get['id'];
            $author = User::where('id','=', $id)->first();
            $tweetsAuthor = $author->tweets()->get();
            $vue = new TweeterView($tweetsAuthor);
            $vue->render('userTweets');
        }else{
            (new \mf\router\Router)->executeRoute('default');
        }
    }

    public function newPostTweet(){
        $newTweet = Tweet::orderBy('id', 'desc')->first();
        $vue = new TweeterView($newTweet);
        $vue->render('post');
    }

    public function viewFollowers(){
        $auth = new Authentification();
        $id = User::select('id')->where('username','=',$auth->user_login)->first();
        $followers = Follow::select('followee')->where('follower', '=', $id['id'])->get();
        $vue = new TweeterView($followers);
        $vue->render('followers');
    }

    public function viewProfil(){
        $auth = new Authentification();
        $id = User::select('id')->where('username','=',$auth->user_login)->first();
        $followers = Follow::select('follower')->where('followee', '=', $id['id'])->get();
        $vue = new TweeterView($followers);
        $vue->render('profil');
    }

    public function sendNewTweet(){
        $auth = new Authentification();
        $id = User::select('id')->where('username','=',$auth->user_login)->first();
        if(!empty($this->request->post['text'])){
            $newTweet = new Tweet();
            $newTweet->text = $this->request->post['text'];
            $newTweet->author = $id['id'];
            $newTweet->save();
        }else{
            throw new AuthentificationException("Publication impossible : une erreure est survenue lors de l'envoi du tweet");
        }
        (new \mf\router\Router)->executeRoute('default');

    }
}
