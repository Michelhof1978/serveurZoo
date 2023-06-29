<?php
//Connection sécurisée à la BDD grâce à PDO
abstract class Model {//En héritant de la classe abstraite "Model", les classes enfants peuvent étendre ou modifier le comportement
                      //de base défini dans la classe parente, en ajoutant des méthodes spécifiques à leurs besoins ou en redéfinissant des méthodes 
                     //existantes.L'utilisation d'une classe abstraite permet de centraliser la logique commune liée à la manipulation des données 
                    //dans une seule classe, ce qui facilite la maintenance, la réutilisation du code et favorise une meilleure structure de
                   //l'application.
    
     private static $pdo;// Static un mot-clé qui indique que la variable "$pdo" est une variable statique. Cela signifie qu'elle est associée à la classe elle-même plutôt qu'à une instance spécifique de la classe. Une variable statique est partagée entre toutes les instances de la classe et peut être accédée sans avoir besoin d'instancier la classe.

    private static function setBdd(){//setBdd va gérer la connexion et en va charger cette connexion ds $pdo
        self::$pdo = new PDO("mysql:host=localhost;dbname=dbanimaux;charset=utf8","root","");//root =accés à la BDD et vide "" pour le MDP car je ne l ai pas sécurisé
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);//indique que l'attribut de mode d'affichage des erreurs de l'objet PDO $pdo est défini sur PDO::ERRMODE_WARNING, ce qui signifie que les avertissements seront émis lorsqu'il y a des erreurs.
    }

    protected function getBdd(){//Si connexion réussi si dessus, on ne fera pas cette connexion
        if(self::$pdo === null){
            self::setBdd();
}
        return self::$pdo;
    }

    public static function sendJSON($info){//Transformer les datas en format JSON pour API
        header("Access-Control-Allow-Origin: *");//Permettra à n'importe qui de l extérieur à accéder aux données JSON, * veut dire que tout le monde peut y accéder, si c'est uniquement pour un site, on remplacera * par l adresse du site
        header("content-Type: application/json");
                         La ligne de code "header("content-Type: application/json");" en français signifie que l'en-tête de la 
                         réponse HTTP va indiquer que le contenu de la réponse est de type JSON. Voici une explication de chaque 
                         terme :
                             - "header" : C'est une fonction en PHP utilisée pour envoyer des en-têtes HTTP. Les en-têtes HTTP 
                             fournissent des informations supplémentaires sur la réponse que le serveur envoie au client. 
                             Dans ce cas, la fonction "header" est utilisée pour définir l'en-tête "Content-Type".
                             - "content-Type" : C'est un en-tête HTTP qui spécifie le type de contenu de la réponse. Il indique
                              comment le contenu de la réponse doit être interprété par le client. Dans ce cas, "content-Type" est utilisé pour spécifier que le contenu de la réponse est de type JSON.
            
            - "application/json" : C'est la valeur spécifiée pour l'en-tête "Content-Type" qui indique que le contenu de la réponse est au format JSON. JSON (JavaScript Object Notation) est un format de données largement utilisé pour échanger des données structurées entre un serveur et un client.
            
            En résumé, la ligne de code "header("content-Type: application/json");" est utilisée pour spécifier que le contenu de la réponse HTTP est de type JSON. Cela permet au client qui reçoit cette réponse de savoir comment interpréter les données contenues dans la réponse.
        echo json_encode($info);
    }
}


// PDO (PHP Data Objects) est une extension PHP qui fournit une interface pour accéder aux bases de données.
//  Elle permet d'interagir avec différentes bases de données, telles que MySQL, PostgreSQL, SQLite, etc., en
//   utilisant une interface unifiée.
// Voici une explication des principaux concepts et fonctionnalités de PDO en PHP :
// 1. Connexion à la base de données : PDO facilite la connexion à une base de données en fournissant une classe `PDO`
//  qui représente la connexion. Pour se connecter à une base de données, vous devez fournir les informations de 
//  connexion, telles que le nom de l'hôte, le nom d'utilisateur, le mot de passe, le nom de la base de données, etc.
//   Par exemple :
// ```php
// $dsn = "mysql:host=localhost;dbname=ma_base_de_donnees";
// $user = "mon_utilisateur";
// $password = "mon_mot_de_passe";
// $pdo = new PDO($dsn, $user, $password);
// ```
// 2. Exécution de requêtes : Une fois connecté, vous pouvez exécuter des requêtes SQL à l'aide de l'objet `PDO`. 
// Vous pouvez exécuter des requêtes de lecture (SELECT), d'insertion, de mise à jour ou de suppression
//  (INSERT, UPDATE, DELETE) en utilisant les méthodes appropriées de l'objet `PDO`. Par exemple :
// ```php
// $query = "SELECT * FROM users";
// $statement = $pdo->query($query);

// while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
//     // Traiter chaque ligne du résultat
// }
// ```
// 3. Préparation des requêtes : PDO prend en charge la préparation des requêtes pour améliorer la sécurité et 
// l'efficacité. Vous pouvez créer des requêtes préparées en utilisant la méthode `prepare()` de l'objet `PDO` et
//  exécuter la requête en liant les paramètres avec la méthode `bindParam()` ou `bindValue()`. Par exemple :

// ```php
// $query = "SELECT * FROM users WHERE id = :id";
// $statement = $pdo->prepare($query);
// $statement->bindParam(':id', $userId, PDO::PARAM_INT);
// $statement->execute();

// $result = $statement->fetchAll(PDO::FETCH_ASSOC);
// ```
// 4. Gestion des erreurs : PDO gère les erreurs liées à la base de données en utilisant les exceptions. Si une 
// erreur se produit lors de l'exécution d'une requête, une exception `PDOException` est levée. Vous pouvez utiliser 
// un bloc `try-catch` pour capturer et gérer ces exceptions. Par exemple :
// ```php
// try {
//     $pdo = new PDO($dsn, $user, $password);
//     // ... exécution de requêtes ...
// } catch (PDOException $e) {
//     echo "Erreur : " . $e->getMessage();
// }
// ```
// Ces points couvrent les bases de l'utilisation de PDO en PHP. PDO offre également d'autres fonctionnalités avancées
//  telles que la gestion des transactions, les requêtes préparées avec résultats multiples, les pilotes de base de 
//  données personnalisés, etc. Consultez la documentation officielle de PHP pour plus d'informations sur l'utilisation
//   de PDO.