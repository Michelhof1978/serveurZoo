<?php 

define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS']) ? "https" : "http").
"://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));// cette ligne de code permet de générer une URL basée sur le protocole (HTTP ou HTTPS), le nom de domaine et le chemin du script en cours d'exécution, en supprimant le nom de fichier "index.php" de l'URL finale.

require_once "controllers/front/API.controller.php";
$apiController = new APIController();//On récupére la class APIController ds le fichier ci-dessus

//Création du système de routage
try{
    if(empty($_GET['page'])){//Si  aucune informations n'est donné ds l'URL
        throw new Exception("La page n'existe pas");
    } else {
        $url = explode("/",filter_var($_GET['page'],FILTER_SANITIZE_URL));//Sécurisation de l URL avec FILTER
        if(empty($url[0]) || empty($url[1])) throw new Exception ("La page n'existe pas");//Les infos tapées ds l'URL s afficherront sur la page sous forme de tableau à chaque fois que l'on notera des infos sur l URL après le /accueil/contact ....
        switch($url[0]){
            case "front" : ;//http://localhost:8000/serveuranimaux/front/test
                switch($url[1]){//On va vérifier la valeur du 2 ème champs (position 1 ds tableau) après le / ds l url
                   //front[0], animaux[0], animal, continents, familles[1]
                  
                   case "animaux": $apiController -> getAnimaux();//création route nommé animaux, on récupére les infos ds API.controller.php grâce à la fonction getAnimaux
                        
                   break;

                    case "animal":
                        if(empty($url[2])) throw new Exception ("L'identifiant de l'animal est manquant");
                        $apiController -> getAnimal($url[2]);// $idAnimal sera mis en 2 ème position de l'url, on récupère l id de l animal en 2 ème position de l'utl après le /
                    break;

                    case "continents":$apiController -> getContinents();
                    break;

                    case "familles":$apiController -> getFamilles();
                    break;

                    default : throw new Exception ("La page n'existe pas");//Si pas écrit ds l url front ou back mais un autre mot, la page n existe pas
                }
            break;
            case "back" : echo "page back end demandée";// http://localhost:8000/serveuranimaux/back/test
            break;
            default : throw new Exception ("La page n'existe pas");//Si pas noté front ou back ds Url alors La page n existe pas
        }
    }
} catch (Exception $e){
    $msg = $e->getMessage();
    echo $msg;
}

// Exemple de gestion d'une requête GET dans un script PHP. Il vérifie la valeur du paramètre `$_GET['page']` et effectue différentes actions en fonction de cette valeur. Permettez-moi de vous expliquer étape par étape :
// 1. Le code commence par vérifier si `$_GET['page']` est vide à l'aide de la fonction `empty()`. Si c'est le cas, une exception est lancée avec le message "La page n'existe pas".
// 2. Si `$_GET['page']` n'est pas vide, le code continue son exécution. Il utilise la fonction `filter_var()` avec le filtre `FILTER_SANITIZE_URL` pour nettoyer la valeur de `$_GET['page']` et la découper en segments à l'aide de la fonction `explode("/")`. Les segments sont stockés dans un tableau `$url`.
// 3. Ensuite, le code vérifie si les segments `$url[0]` et `$url[1]` sont vides. Si l'un d'eux est vide, cela signifie que la page demandée n'existe pas et une exception est lancée avec le message "La page n'existe pas".
// 4. Si les segments `$url[0]` et `$url[1]` ne sont pas vides, le code utilise une structure de commutation (`switch`) pour déterminer quelle action prendre en fonction des valeurs de ces segments.
// 5. Si `$url[0]` est "front", le code examine la valeur de `$url[1]` pour effectuer une action spécifique. Dans votre exemple, il y a plusieurs cas (`case`) pour différentes valeurs de `$url[1]`. Par exemple, si `$url[1]` est "animaux", le code affiche "données JSON des animaux demandées". Si `$url[1]` est "animal", le code affiche "données JSON de l'animal ".$url[2]." demandées", où `$url[2]` représente le troisième segment de l'URL.
// 6. Si `$url[0]` est "back", le code affiche "page back end demandée".
// 7. Si aucune des valeurs attendues n'est trouvée dans la structure de commutation, une exception est lancée avec le message "La page n'existe pas".
// 8. En cas d'exception, le code capture l'objet d'exception `$e` et récupère le message d'erreur à l'aide de la méthode `getMessage()`. Ce message est ensuite stocké dans la variable `$msg`.
// 9. Enfin, le message d'erreur est affiché avec `echo $msg`.
// Cela donne une structure de gestion d'une requête GET et de différentes actions à prendre en fonction de la valeur du paramètre "page" dans l'URL.