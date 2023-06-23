<?php

require_once "models/Model.php";
class APIManager extends Model{//Système d héritage avec extends
    public function getDBAnimaux(){
    //   -------------------------

        //Création en code de toutes les tables qui ont été crées ds la BDD avec toutes les jointures
        $req = "SELECT * FROM animal a inner join famille f on f.famille_id = a.famille_id 
                                       inner join animal_continent ac on ac.animal_id = a.animal_id 
                                       inner join continent c on c.continent_id = ac.continent_id";
    //   "SELECT * FROM animal" : Sélectionne toutes les colonnes de la table "animal".
    //   "inner join famille f on f.famille_id = a.famille_id" : Effectue une jointure interne 
    //   (INNER JOIN) avec la table "famille" en utilisant la clé étrangère "famille_id" présente dans
    //    la table "animal".
    //   "inner join animal_continent ac on ac.animal_id = a.animal_id" : Effectue une jointure interne
    //    (INNER JOIN) avec la table "animal_continent" en utilisant la clé étrangère "animal_id" 
    //    présente dans la table "animal".
    //   "inner join continent c on c.continent_id = ac.continent_id" : Effectue une jointure interne 
    //   (INNER JOIN) avec la table "continent" en utilisant la clé étrangère "continent_id" présente 
    //   dans la table "animal_continent".
    //   En résumé, cette requête sélectionne toutes les colonnes de la table "animal" et effectue des
    //    jointures avec les tables "famille", "animal_continent" et "continent" en utilisant les clés
    //     étrangères appropriées. Cela permet d'obtenir les informations liées aux animaux, à leur
    //      famille et aux continents auxquels ils appartiennent.
    //   -------------------------
        $stmt = $this-> getBdd()->prepare($req);//préparer une requête SQL à exécuter sur une base de données.
        // Voici une explication ligne par ligne :
        //  $stmt est une variable qui sera utilisée pour stocker la requête préparée.
        // $this fait référence à l'objet actuel, c'est-à-dire à l'objet dans lequel cette ligne de
        //  code est exécutée.
        // getBdd() est une méthode qui est appelée sur l'objet actuel pour obtenir une instance de la 
        // connexion à la base de données. Cette méthode pourrait être définie dans la classe à laquelle appartient cet objet.
        // prepare($req) est une méthode appelée sur l'objet de connexion à la base de données.
        //  Elle prend en paramètre une requête SQL sous forme de chaîne de caractères ($req) et 
        //  prépare cette requête pour exécution ultérieure. La requête peut contenir des paramètres de
        //   requête, qui peuvent être liés à des valeurs spécifiques lors de l'exécution.
        //   -------------------------

        $stmt->execute();//execute() est une méthode appelée sur l'objet de requête préparée ($stmt). Cette méthode exécute la requête préparée avec les paramètres éventuellement liés à des valeurs spécifiques.
        $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);//cette ligne de code exécute la méthode fetchAll() sur l'objet de requête préparée ($stmt) pour récupérer tous les résultats de la requête dans un tableau associatif. Le tableau résultant est ensuite assigné à la variable $animaux pour une utilisation ultérieure. Chaque élément du tableau correspond à une ligne de résultat de la requête, avec les noms de colonnes correspondants aux clés du tableau.
        $stmt->closeCursor();//cette ligne de code est utilisée pour fermer le curseur de la requête après avoir récupéré les résultats. Cela permet de libérer les ressources utilisées par la requête sur le serveur de base de données.
        return $animaux;
    }
}




// Dans l'architecture MVC (Modèle-Vue-Contrôleur), le "manager" fait généralement référence à une classe du modèle, 
// chargée de gérer la logique métier de l'application. Le manager interagit avec les différentes entités du modèle, 
// effectue des opérations de lecture/écriture dans la base de données, effectue des calculs, applique des règles 
// métier, etc.

// Voici quelques caractéristiques et responsabilités courantes d'un manager dans l'architecture MVC :

// 1. Gestion des données : Le manager est responsable de l'accès aux données et de leur manipulation. Il peut
//  interagir avec une couche d'accès aux données (par exemple, une classe DAO ou un ORM) pour récupérer ou stocker 
//  des informations dans la base de données.
// 2. Logique métier : Le manager implémente la logique métier spécifique de l'application. Cela peut inclure des 
// calculs, des validations, des règles de traitement des données, des opérations de mise à jour, etc.
// 3. Coordination des entités : Le manager coordonne l'interaction entre différentes entités du modèle. Par exemple,
//  il peut coordonner les opérations de création, de mise à jour et de suppression entre plusieurs entités liées.

// 4. Abstraction de la couche de données : Le manager masque les détails de la couche de données aux autres composants
//  du modèle. Cela permet aux autres parties de l'application (comme le contrôleur et la vue) de travailler avec des 
//  objets métier plutôt qu'avec des détails spécifiques à la base de données.

// 5. Enrichissement des données : Le manager peut effectuer des opérations supplémentaires sur les données avant de
//  les fournir à d'autres composants. Par exemple, il peut enrichir les objets avec des informations supplémentaires,
//   calculer des agrégats ou des statistiques, ou préparer des données spécifiques pour l'affichage.

// Il est important de noter que le rôle et les responsabilités spécifiques d'un manager peuvent varier en fonction de 
// la conception et des besoins de l'application. Il n'y a pas de définition stricte et universelle d'un manager dans
//  l'architecture MVC, mais les points mentionnés ci-dessus représentent généralement les tâches effectuées par cette
//   classe dans ce contexte.