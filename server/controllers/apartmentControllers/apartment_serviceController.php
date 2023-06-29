<?php
//Inclusion du fichier pour afficher les erreurs 
require_once './debug.php';
//Inclusion du fichier pour la connexion a la BDD
require_once './database/client.php';

//Création d'un controller (objet) de la table apartment_service de la BDD
class Apartment_service {
    
    function getAllApartmentService($apartment_id){
        $db = new Database();

        $connexion = $db->getconnection();

        $request = $connexion->prepare("
            SELECT *
            FROM apartment_service
            WHERE apartment_id = :apartment_id
            );
        ");

        $request->execute([':apartment_id' => $apartment_id]);

        $apartmentService = $request->fetchAll(PDO::FETCH_ASSOC);

        $connexion = null;

        header('Content-Type: application/json');
        echo json_encode($apartmentService);
    }

    function addApartmentService($apartment_id){
        $db = new Database();

        $connexion = $db->getconnection();

        $apartment_service_id = $_POST["apartment_service_id"];
        $apartment_service_name = $_POST["apartment_service_name"];

        $request = $connexion->prepare("
        INSERT INTO apartment_service (
            apartment_service_id,
            apartment_service_name
        ) VALUE (
            :apartment_service_id,
            :apartment_service_name
        )
        ");

        $request->execute([
            ':apartment_service_id' => $apartment_service_id,
            ':apartment_service_name' => $apartment_service_name
        ]);

        $apartmentService = $request->fetchAll(PDO::FETCH_ASSOC);

        $connexion= null;
        $message = "Le service de l'appartment a bien été ajouter";
        // header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
        exit;
    }

    function updateOneApartmentService($service_id){
        $db = new Database();

        $connexion = $db->getconnection();

        $apartment_service_id = $_POST["apartment_service_id"];
        $apartment_service_name = $_POST["apartment_service_name"];

        $request = "UPDATE apartment_service SET ";
        
        $connexion = null;
        $message = "Le service de l'apartment a bien été mise à jour";
        // header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
        exit;
    }

    function deleteOneApartmentService($service_id){
        $db = new Database();

        $connexion = $db->getconnection();
        
        $request = $connexion->prepare("
            DELETE FROM apartment_service
            WHERE service_id = :service_id
        ");
        $connexion= null;

        $message = "Le service à bien été suprimer";
        // header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
        exit;
    }

}