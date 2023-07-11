<?php

require_once "models/Model.php";
class APIManager extends Model{//Système d héritage avec extends
    public function getDBAnimaux($idFamille, $idcontinent){//L'utilisation du modificateur public permet de rendre la 
            $whereClause = "";//méthode accessible et utilisable de manière externe à la classe, ce qui est souvent
        
        //méthode accessible et utilisable de manière externe à la classe, ce qui est souvent 
        //nécessaire pour interagir avec les objets de cette classe dans d'autres parties du code.
    //   -------------------------
        //Création en code de toutes les tables qui ont été crées ds la BDD avec toutes les jointures
        $req = "SELECT * FROM animal a inner join famille f on f.famille_id = a.famille_id 
                                       inner join animal_continent ac on ac.animal_id = a.animal_id 
                                       inner join continent c on c.continent_id = ac.continent_id"; .
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
        $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);//On récupère toutes les dates et on va les mettre ds la variable lignesAnimal
        $stmt->closeCursor();//cette ligne de code est utilisée pour fermer le curseur de la requête après avoir récupéré les résultats. Cela permet de libérer les ressources utilisées par la requête sur le serveur de base de données.
        return $animaux;
    }


public function getDBAnimal($idAnimal){
    $req = "SELECT * FROM animal a
             inner join famille f ON f.famille_id = a.famille_id 
             inner join animal_continent ac ON ac.animal_id = a.animal_id 
             inner join continent c ON c.continent_id = ac.continent_id
             WHERE a.animal_id = :idAnimal ";// Système de filtrage avec WHERE, on récupèrera uniquepment la valeur choisi ds la table animal: on récupèrera uniquement ce que l on a besoin ds la table et non tout.
    
    $stmt = $this -> getBdd()->prepare($req);
    $stmt->bindValue(":idAnimal",$idAnimal,PDO::PARAM_INT);//BindValue() est une méthode pour lier un paramètre nommé ":idAnimal" à la valeur de la variable "$idAnimal". Cette méthode est utilisée dans le contexte des requêtes préparées pour associer une valeur à un paramètre nommé dans la requête SQL.
    // PDO::PARAM_INT est utilisée pour indiquer que le paramètre nommé ":idAnimal" doit être traité comme un entier lors de l'exécution de la requête. Cela peut être utile si vous souhaitez vous assurer que la valeur passée à ce paramètre est interprétée comme un entier, même si elle est initialement une chaîne de caractères ou un autre type de données.
    $stmt->execute();//execute() est une méthode appelée sur l'objet de requête préparée ($stmt). Cette méthode exécute la requête préparée avec les paramètres éventuellement liés à des valeurs spécifiques.
        $lignesAnimal = $stmt->fetchAll(PDO::FETCH_ASSOC);//On récupère toutes les dates et on va les mettre ds la variable lignesAnimal
        $stmt->closeCursor();//cette ligne de code est utilisée pour fermer le curseur de la requête après avoir récupéré les résultats. Cela permet de libérer les ressources utilisées par la requête sur le serveur de base de données.
        return $lignesAnimal;
}

public function getDBFamilles(){//On récupére les données de la table famille
    $req = "SELECT * 
    from famille  
    ";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->execute();
    $familles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $familles;
}

public function getDBContinents(){//On récupére les données de la table continent
    $req = "SELECT * 
    from continent
    ";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->execute();
    $continents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $continents;
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
//   classe dans ce contexte.*
// -------------------------------------------------------------------------------------------------------------------
// L'utilisation d'un manager dans l'architecture Modèle-Vue-Contrôleur (MVC) est une pratique courante pour gérer la logique métier 
// et la manipulation des données au sein d'une application. Voici quelques raisons pour lesquelles il est utile d'utiliser un manager
//  dans le contexte du MVC :

// 1. Séparation des responsabilités : Le principe fondamental du MVC est de séparer les différentes responsabilités de l'application. Le manager joue un rôle clé en prenant en charge la logique métier et la gestion des données, ce qui permet de séparer clairement ces responsabilités du contrôleur et de la vue. Cela rend le code plus modulaire, maintenable et évolutif.

// 2. Logique métier centralisée : Le manager agit comme une couche intermédiaire entre le contrôleur et le modèle. Il encapsule la
//  logique métier spécifique à l'application, ce qui facilite sa réutilisation et sa maintenance. Plutôt que de répéter la même 
//  logique métier dans plusieurs contrôleurs, celle-ci peut être centralisée dans un manager qui peut être appelé à partir de
//   différents contrôleurs.

// 3. Manipulation des données : Le manager peut gérer les opérations de lecture, d'écriture et de manipulation des données
//  nécessaires à l'application. Il peut encapsuler des requêtes complexes à la base de données ou à d'autres sources de données, 
//  et fournir des méthodes simples et cohérentes pour les contrôleurs pour interagir avec les données.

// 4. Gestion des transactions : Dans certains cas, le manager peut également prendre en charge la gestion des transactions.
//  Lorsqu'une opération nécessite des modifications cohérentes sur plusieurs modèles ou sources de données, le manager peut
//   garantir que ces modifications sont effectuées de manière atomique (soit toutes les modifications réussissent, soit aucune ne 
//   réussit) en utilisant des mécanismes de transaction.

// 5. Tests unitaires : L'utilisation d'un manager facilite également les tests unitaires. Étant donné que la logique métier est 
// centralisée dans le manager, il est plus facile de tester cette logique indépendamment des autres composants de l'application.
//  Cela permet d'effectuer des tests unitaires plus ciblés et plus efficaces.

// En résumé, l'utilisation d'un manager dans le MVC permet de séparer la logique métier et la manipulation des données du contrôleur 
// et de la vue, favorisant ainsi la modularité, la réutilisation et la maintenabilité du code. Il facilite également les tests 
// unitaires et offre une couche intermédiaire pour encapsuler la logique spécifique à l'application.