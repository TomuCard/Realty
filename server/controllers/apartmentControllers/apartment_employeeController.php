<?php
//Inclusion du fichier pour afficher les erreurs 
require_once './debug.php';
//Inclusion du fichier pour la connexion a la BDD
require_once './database/client.php';

//Création d'un controller (objet) de la table apartment_employee de la BDD
class Apartment_employee {
    
    function getAllApartmentForOneEmployee($user_id, $statut){

        $db = new Database();

        $connexion = $db->getconnection();

        switch ($statut) {
            case 'Logistique':

                $sql = $connexion->prepare("
                SELECT
                user.user_firstname,
                user.user_lastname,
                JSON_ARRAYAGG(JSON_OBJECT(
                    'apartment_id', apartment.apartment_id,
                    'picture', apartment.apartment_main_picture,
                    'name', apartment.apartment_adress
                    )) AS apartments
                FROM apartment_employee
                JOIN apartment ON apartment.apartment_id = apartment_employee.apartment_employee_apartment_id
                JOIN user ON user.user_id = apartment_employee.apartment_employee_logistique_user_id
                WHERE apartment_employee.apartment_employee_logistique_user_id = :user_id
                ");
        
                $sql->execute([':user_id' => $user_id]);
        
                $apartments = $sql->fetch(PDO::FETCH_ASSOC);
        
                $connexion = null;
        
                header('Content-Type: application/json');
                echo json_encode($apartments);
                break;

            case 'Menage':

                $sql = $connexion->prepare("
                SELECT
                user.user_firstname,
                user.user_lastname,
                apartment.apartment_main_picture,
                apartment.apartment_adress,
                apartment.apartment_id
                FROM apartment_employee
                JOIN apartment ON apartment.apartment_id = apartment_employee.apartment_employee_apartment_id
                JOIN user ON user.user_id = apartment_employee.apartment_employee_menage_user_id
                WHERE apartment_employee.apartment_employee_menage_user_id = :user_id
                ");
        
                $sql->execute([':user_id' => $user_id]);
        
                $apartments = $sql->fetchAll(PDO::FETCH_ASSOC);
        
                $connexion = null;
        
                header('Content-Type: application/json');
                echo json_encode($apartments);
                break;
            
            default:
                $message="il n'y a pa de statut";
                header('Content-Type: application/json');
                echo json_encode($message);
                break;
            
        }

    }

    function addEmployeeForOneApartment(){
        
    }

    function updateEmployeeForOneApartment(){
        
    }

    function deleteEmployeeForOneApartment(){
        
    }
}