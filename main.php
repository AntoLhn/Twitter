<?php
///////////////////////////////////////////////
/// Auto-loader
require_once __DIR__ . '/vendor/autoload.php';
///////////////////////////////////////////////
/// Use
use \twitterapp\model\Follow;
use \twitterapp\model\Like;
use \twitterapp\model\Tweet;
use \twitterapp\model\User;
use \twitterapp\control\TweeterController;
use \mf\router\Router;
use \mf\view\AbstractView;
use \twitterapp\auth\TweeterAuthentification;
///////////////////////////////////////////////
/// Style CSS
AbstractView::addStyleSheet('html/style.css');
///////////////////////////////////////////////
/// Connexion à la bdd
require_once 'vendor/autoload.php';
$config = parse_ini_file('conf/config.ini');
/* une instance de connexion  */
$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection( $config ); /* configuration avec nos paramètres */
$db->setAsGlobal();            /* rendre la connexion visible dans tout le projet */
$db->bootEloquent();           /* établir la connexion */
///////////////////////////////////////////////
/// Quelques requêtes
/*$req = Tweet::select()->where("score",">","0")->orderby("updated_at")->get();
foreach ($req as $key) {
    echo "Identifiant : ".$key->id."</br><i>Date de modification : ".$key->updated_at."</i></br><textarea style='width: 30%; height: 50px;'>".$key->text."</textarea></br></br>";
}
$req = User::select()->get();
foreach ($req as $key) {
    echo "Identifiant : ".$key->id.", Nom : ".$key->fullname."</br>";
}*/

/// Nouveau tweet
/*$t = new Tweet();
$t->id = 75;
$t->text = "Ceci est un nouveau tweet fait le 13 octobre 2020.";
$t->author = 8;
$t->score = 1;
$t->save();*/

/// Nouvel utilisateur
/*$u = new User();
$u->fullname = "Antonin Liehn";
$u->username = "Anto.lhn";
$u->password = "";
$u->followers = 0;
$u->level = 100;
$u->save();*/

/// Jointure
/*echo "</br>";
$idTweet = 67;
$tweet = Tweet::where('id','=', $idTweet)->first();
$authorTweet = $tweet->author()->first();
echo "Auteur du tweet ".$idTweet." : ".$authorTweet['fullname'];
echo "</br></br>";

$idAuthor = 9;
$author = User::where('id','=', $idAuthor)->first();
$tweetAuthor = $author->tweets()->get();
foreach ($tweetAuthor as $key) {
    echo "Auteur du tweet : ".$author->fullname."</br><textarea style='width: 30%; height: 50px;'>".$key->text."</textarea></br></br>";
}*/

/// Affiche tous les tweets
/*$ctrl = new TweeterController();
echo $ctrl->viewHome();*/

/// Routes
$router = new Router();

$router->addRoute('home', '/home/', '\twitterapp\control\TweeterController', 'viewHome', TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('tweet', '/user/', '\twitterapp\control\TweeterController', 'viewTweet', TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('userTweets', '/tweet/', '\twitterapp\control\TweeterController', 'viewUserTweets', TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('post', '/post/', '\twitterapp\control\TweeterController', 'newPostTweet', TweeterAuthentification::ACCESS_LEVEL_USER);
$router->addRoute('send', '/send/', '\twitterapp\control\TweeterController', 'sendNewTweet', TweeterAuthentification::ACCESS_LEVEL_USER);
// Authentification
$router->addRoute('login', '/followers/', '\twitterapp\control\TweeterAdminController', 'login', TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('checkLogin', '/checkLogin/', '\twitterapp\control\TweeterAdminController', 'checkLogin', TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('logout', '/logout/', '\twitterapp\control\TweeterAdminController', 'logout', TweeterAuthentification::ACCESS_LEVEL_USER);
$router->addRoute('signup', '/signup/', '\twitterapp\control\TweeterAdminController', 'signup', TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('checkSignup', '/checkSignup/', '\twitterapp\control\TweeterAdminController', 'checkSignup', TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->setDefaultRoute('/home/');

echo "<a href=".$router->urlFor('post').">Post</a>";
$router->run();