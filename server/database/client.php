<?php
// Pour afficher les erreurs dans le navigateur
require_once './debug.php';

// Création de l'objet
class Database {
    
    //Fonction pour la connection à la BDD
    function getConnection () {
        
        // variables de connection a la bdd
        $host = "localhost";
        $dbname = "realty";
        $username = "realty";
        $password = "realty";
        $port = 3306; // Port par défaut de mySQL

        // Initialisation de la variable connection initialisé à null
        $connection = null;
        //Tentative de connection 
        try {
            // Objet natif à PhP pour se connecter à la BDD 
            $connection = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname . ";charset=utf8", $username, $password);
            // Ajouter des attributs à l'objet PDO ( méthode native à PDO)
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $exception){
            echo "Erreur de connexion:" . $exception->getMessage();
        }

        //Si connection réussi affectation à la variable connection 
        return $connection;
    }
}