<?php
//Inclusion du fichier pour afficher les erreurs 
require_once './debug.php';
//Inclusion du fichier pour la connexion a la BDD
require_once './database/client.php';

//Création d'un controller (objet) de la table apartment_check de la BDD
class Apartment_check {
    
    function getAllApartmentTask(){
        $db = new Database();

        $connexion = $db->getConnection();

        $request = $connexion->prepare("
        SELECT *
        FROM apartment_check
        WHERE user_id = :user_id
        );
        
        ");
        $request->execute();
        
        $connexion = $db->getconnection();
        $apartmentInfos = $request->fetchAll(PDO::FETCH_ASSOC);
        
        $connexion= null;
        header('Content-Type: application/json');
        echo json_encode($apartmentInfos);
    }

    function addOneApartmentTask($apartment_id){
        $db = new Database();

        $connexion = $db->getconnection();

        $apartment_check_id = $_POST["apartment_check_id"];   
        $apartment_check_apartment_id = $_POST["apartment_check_apartment_id"];
        $apartment_check_task = $_POST["apartment_check_task"]; 
        $apartment_check_statut = $_POST["apartment_check_statut"];

        $request = $connexion->prepare("
        INSERT INTO apartment_check (
            apartment_check_id,
            apartment_check_apartment_id,
            apartment_check_task,
            apartment_check_statut
        ) VALUE (
            :apartment_check_id,
            :apartment_check_apartment_id,
            :apartment_check_task,
            :apartment_check_statut
        )
        ");

        $request->execute([
            ':apartment_check_id' => $apartment_check_id,
            ':apartment_check_apartment_id' => $apartment_check_apartment_id,
            ':apartment_check_task' => $apartment_check_task,
            ':apartment_check_statut' => $apartment_check_statut
        ]);

        $apartmentService = $request->fetchAll(PDO::FETCH_ASSOC);

        $connexion= null;
        $message = "La tâche de l'appartment a bien été ajouter";
        // header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
        exit;
    }

    function updateOneApartmentTask(){
        $db = new Database();

        $connexion = $db->getconnection();

        $apartment_check_id = $_POST["apartment_check_id"];   
        $apartment_check_apartment_id = $_POST["apartment_check_apartment_id"];
        $apartment_check_task = $_POST["apartment_check_task"]; 
        $apartment_check_statut = $_POST["apartment_check_statut"];

        $request = "UPDATE apartment_service SET ";
        
        $connexion = null;
        $message = "La tâche de l'apartment a bien été mise à jour";
        // header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
        exit;
    }

    function deleteOneApartmentTask(){
        
    }
}