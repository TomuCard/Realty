<?php
//Inclusion du fichier pour afficher les erreurs 
require_once './debug.php';
//Inclusion du fichier pour la connexion a la BDD
require_once './database/client.php';

//Création d'un controller (objet) de la table User_planning de la BDD
class User_planning {
    
    function getOnePlanningForOneUser($planning_id){
        // get
        // afficher le planning d'un utilisateur
        $user_id = $_POST['user_planning_user_id'];

        $db = new Database();

        // je me connecte à la BDD avec la fonction getConnection de l'objet Database
       $connexion = $db->getConnection();

       $sql = $connexion -> prepare("
                                     SELECT * 
                                     FROM user_planning
                                     WHERE user_planning_id = :planning_id
                                     AND user_planning_user_id = :apartment_id
                                    ");

        $sql -> execute(['user_planning_id' => $planning_id ,
                         'user_planning_user_id' => $user_id
                        ]);
        
        $planning_one_user = $sql -> fetchAll(PDO::FETCH_ASSOC);

        $connexion = null;

        // je renvoie au front les données au format json
        header('Content-Type: application/json');
        echo json_encode($planning_one_user);
    }

    function getAllPlanningForOneUser($user_id){
        // Get
        // Afficher tous les planning d'un utilisateur
        $user_id = $_POST['user_planning_id'];

        $db = new Database();

         // je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connexion = $db->getConnection();

        $sql = $connexion -> prepare("
                                       SELECT *
                                       FROM user_planning
                                       WHERE user_planning_id = :user_planning_id;
                                    ");

        $sql -> execute([' user_planning_id' => $user_id]);

        // je récupère tous les résultats dans users
        $planning_user = $sql -> fetchAll(PDO::FETCH_ASSOC);
        // je ferme la connection
        $connexion = null;

        // je renvoie au front les données au format json
        header('Content-Type: application/json');
        echo json_encode($planning_user);


    }

    function getAllPlanningForOneApartment($apartment_id){
        // get
        // Afficher tous les plannings d'un appartement
        $apartment_id = $_POST['user_planning_apartment_id'];

        $db = new Database();

         // je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connexion = $db->getConnection();

        $sql = $connexion -> prepare("
                                       SELECT *
                                       FROM user_planning
                                       WHERE user_planning_apartment_id = :user_planning_apartment_id;
                                    ");

        $sql -> execute([' user_planning_apartment_id' => $apartment_id]);

        // je récupère tous les résultats dans users
        $planning_apartment = $sql -> fetchAll(PDO::FETCH_ASSOC);
        // je ferme la connection
        $connexion = null;

        // je renvoie au front les données au format json
        header('Content-Type: application/json');
        echo json_encode($planning_apartment);


    }

    function getOnePlanningForOneApartement($planning_id){
        //get
        // afficher un planning d'un appartement
        $apartment_id = $_POST['user_planning_apartment_id'];

        $db = new Database();

        // je me connecte à la BDD avec la fonction getConnection de l'objet Database
       $connexion = $db->getConnection();

       $sql = $connexion -> prepare("
                                     SELECT * 
                                     FROM user_planning
                                     WHERE user_planning_id = :planning_id
                                     AND user_planning_apartment_id = :apartment_id
                                    ");

        $sql -> execute(['user_planning_id' => $planning_id ,
                         'user_planning_apartment_id' => $apartment_id
                        ]);
        
        $planning_one_apartment = $sql -> fetchAll(PDO::FETCH_ASSOC);

        $connexion = null;

        // je renvoie au front les données au format json
        header('Content-Type: application/json');
        echo json_encode($planning_one_apartment);
    }

    function addPlanning($user_id , $apartment_id){
        // post
        // ajouter un planning
        $user_planning_date = $_POST['user_planning_date'];
        $user_id = $_POST['user_planning_id'];
        $apartment_id = $_POST['user_planning_apartment_id'];

        $db = new Database();

         // je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connexion = $db->getConnection();

        $sql = $connexion -> prepare("
            INSERT INTO user_planning ( user_planning.user_planning_date , user_planning.user_planning_id , user_planning.user_planning_apartment_id)
            VALUES ( :user_planning_date , :user_planning_id , :user_planning_apartment_id);
        ");

        $sql -> execute(['user_planning_date' => $user_planning_date ,
                         'user_planning_id' => $user_id ,
                         'user_planning_apartment_id' => $apartment_id
                        ]);

        $connexion = null;

        $message = "le planning a bien été supprimer";
        header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
        exit;

    }

    function updateOnePlanning($planning_id){
        //post
        // modifier un planning

        $user_planning_date = $_POST['user_planning_date'];

        $db = new Database();

         // je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connexion = $db->getConnection();

        $sql = $connexion -> prepare("
                UPDATE user_planning
                SET user_planning.user_planning_date = :user_planning_date
                WHERE user_planning_id = :planning_id
        ");

        $sql -> execute(['planning_id' => $planning_id ,
                         'user_planning_date' => $user_planning_date
                         ]);

        $connexion = null;

        $message = "le planning a bien été modifier";
        header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
        exit;

    }

    function deletePlanning($planning_id){
        // post
        // suprimer un planning
        $db = new Database();

         // je me connecte à la BDD avec la fonction getConnection de l'objet Database
        $connexion = $db->getConnection();

        $sql = $connexion -> prepare("
            DELETE FROM user_planning WHERE user_planning_id = :planning_id;
        ");

        $sql -> execute(['planning_id' => $planning_id]);

        $connexion = null;

        $message = "le planning a bien été supprimer";
        header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
        exit;


    }
    
}