<?php
require_once "models/front/API.manager.php"; //On fait appel à modéle pour pouvoir récupérer les données via le controller ci dessous
require_once "models/Model.php";
class APIController {
    private $apiManager;

    public function __construct(){
        $this->apiManager = new APIManager();//Dédié uniquement aux requêtes lié à l'API rest php
    }
//     //La fonction __construct() est une méthode spéciale appelée constructeur de classe. Elle est exécutée 
//     automatiquement lorsqu'un nouvel objet de cette classe est créé. Dans cet exemple, le constructeur initialise 
//     une propriété de l'objet en créant une nouvelle instance de la classe APIManager et en l'assignant à la
//      propriété $apiManager de l'objet actuel.
// En d'autres termes, chaque fois qu'un objet est créé à partir de cette classe, le constructeur garantit que la
//  propriété $apiManager de cet objet est initialisée avec une nouvelle instance de la classe APIManager. Cela permet 
//  à l'objet d'accéder et d'utiliser les fonctionnalités fournies par la classe APIManager en utilisant la propriété
//   $apiManager.
// Cela peut être utile lorsque vous avez besoin d'interagir avec une API externe ou de gérer des opérations
//  spécifiques liées à l'API dans votre classe. En initialisant la propriété $apiManager dans le constructeur, vous
//   pouvez vous assurer que cette ressource est disponible dès la création de chaque objet de la classe.

    public function getAnimaux(){
        $animaux = $this->apiManager->getDBAnimaux();//on crée une nouvelle variable animaux pour récupérer toutes les datas de la BDD des animaux que le manager s'occupera de récupérer
        $tabResultat = $this->formatDataLignesAnimaux($animaux);

    // echo "<pre>";//pour formater et afficher les données de sortie de manière lisible.
    // print_r($animaux);//http://localhost/serveurzoo/front/animaux  = affichage de la liste des animaux sous forme de tableau
    // echo "</pre>";
    Model::sendJSON($tabResultat);
}

public function getAnimal($idAnimal){
    $lignesAnimal = $this->apiManager->getDBAnimal($idAnimal);
    $tabResultat = $this->formatDataLignesAnimaux($lignesAnimal);
    // echo "<pre>";
    // print_r($tabResultat);
    // echo "</pre>";
    Model::sendJSON($tabResultat);
}

private function formatDataLignesAnimaux($lignes){
    $tab = [];
    
    foreach($lignes as $ligne){
        if(!array_key_exists($ligne['animal_id'],$tab)){
            $tab[$ligne['animal_id']] = [
                "id" => $ligne['animal_id'],
                "nom" => $ligne['animal_nom'],
                "description" => $ligne['animal_description'],
                "image" => $ligne['animal_image'],
                "famille" => [
                    "idFamille" => $ligne['famille_id'],
                    "libelleFamille" => $ligne['famille_libelle'],
                    "descriptionFamille" => $ligne['famille_description']
                ]
            ];
        }
       
        $tab[$ligne['animal_id']]['continents'][] = [
            "idContinent" => $ligne['continent_id'],
            "libelleContinent" => $ligne['continent_libelle']
        ];
    }

    return $tab;
}
la fonction "formatDataLignesAnimaux" ci dessus prend un tableau de lignes de données et renvoie un nouveau tableau contenant les 
données formatées selon une structure spécifique. Cette méthode est utilisée pour organiser les données sur les animaux,
 leurs familles et les continents auxquels ils appartiennent dans un format approprié pour une utilisation ultérieure.

    public function getContinents(){
        $continents = $this->apiManager->getDBContinents();
        Model::sendJSON($continents);
        // echo "<pre>";
        // print_r($continents);
        // echo "</pre>";
    }

    public function getFamilles(){
        $familles = $this->apiManager->getDBFamilles();
        Model::sendJSON($familles);//On appel la fonction sendJson de la classe Model et on appel familles qui est le résultat de la requête et le transformera en format JSon
        
        //POUR TESTER LES DONNEES AVANT DE LES METTRE EN JSON
        // echo "<pre>";
        // print_r($familles);
        // echo "</pre>";
    }

}


// Pour instancier une classe en code informatique, vous devez suivre les étapes suivantes :

//     1. Déclarez la classe : Vous devez avoir une classe définie avec toutes les propriétés et les méthodes nécessaires.
//      Par exemple, supposons que vous ayez une classe appelée `MaClasse` :
//     
//     class MaClasse {
//         // Propriétés et méthodes de la classe
//     }
//     
//     2. Créez une instance de la classe : Utilisez le mot-clé `new` suivi du nom de la classe et des parenthèses
//      pour créer une nouvelle instance de la classe. Assignez cette instance à une variable pour pouvoir y accéder
//       et l'utiliser ultérieurement. Par exemple :
    
//     
//     $monObjet = new MaClasse();
//     
    
//     Maintenant, `$monObjet` est une instance de la classe `MaClasse`.
    
//     3. Utilisez l'instance de la classe : Vous pouvez accéder aux propriétés et aux méthodes de l'objet en utilisant
//      l'opérateur de flèche (`->`). Par exemple, supposons que la classe `MaClasse` ait une méthode appelée
//       `maMethode()` :
//     
//     $monObjet = new MaClasse();
//     $monObjet->maMethode();
//     
//     Cela invoque la méthode `maMethode()` sur l'objet `$monObjet`.
//     Il est important de noter que vous devez vous assurer que la classe est incluse ou importée dans votre code 
//     avant d'instancier la classe. Cela peut être fait en utilisant des instructions `require` ou `include` pour
//      inclure le fichier contenant la définition de la classe, ou en utilisant des mécanismes d'importation 
//      appropriés selon la structure de votre projet ou le langage de programmation que vous utilisez.
//     De plus, assurez-vous que vous avez correctement défini la classe avec toutes les propriétés et les méthodes
//      nécessaires pour qu'elle puisse être instanciée sans erreur.
//      --------------------------------------------------------------------------------------------------------