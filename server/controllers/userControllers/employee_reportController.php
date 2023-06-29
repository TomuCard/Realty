<?php
//Inclusion du fichier pour afficher les erreurs 
require_once './debug.php';
//Inclusion du fichier pour la connexion a la BDD
require_once './database/client.php';

//Création d'un controller (objet) de la table employee_report de la BDD
class Employee_report {
    
    function getAllMessageReport($apartment_id){

        // 0. est ce une méthode get ou post ---------> GET

        // 1. se connecter la la bdd
         // j'appelle l'objet base de donnée
         $db = new Database();

         // je me connecte à la BDD avec la fonction getConnection de l'objet Database
         $connexion = $db->getConnection();

        // 2. afficher tous les message de la table employee-report en 
        $sql = $connexion->prepare(" 
            SELECT employee_report.employee_report_message , employee_report.employee_report_created_at , user.user_firstname , user.user_lastname                           
            FROM employee_report                        
            JOIN user
            ON user.user_id = employee_report_user_id
            WHERE employee_report_apartment_id = :apartment_id 
        ");
        // joignant le nom, le prénom et la date du message qui se trouve dans la table 
        // user

        $sql->execute([
            'apartment_id' => $apartment_id
        ]
        );

        $message = $sql->fetchAll(PDO::FETCH_ASSOC);

        $connexion = null;

        header('Content-Type: application/json');
        echo json_encode($message);

        // 3. retouner le résultat sous forme de json au front

    }

    function addMessageReport(){
        // post 
        $db = new Database();
        
        $connexion = $db->getconnection();
        
        $message = $_POST["message"];
        $apartment_id = $_POST["apartment_id"];
        $user_id = $_POST["user_id"];
        $logistics_user_id = $_POST["logistics_user_id"];

        // inserer un message dans la table employee report
        $request = $connexion->prepare("
            INSERT INTO employee_report(
                employee_report_message,
                employee_report_apartment_id,
                employee_report_user_id,
                employee_report_logistics_user_id
            )
            VALUES (
                ':message',
                ':apartment_id',
                ':user_id',
                ':logistics_user_id'
            )
        ");

        $request->execute(
            [
                ":message" => $message,
                ":apartment_id" => $apartment_id,
                ":user_id" => $user_id,
                ":logistics_user_id" => $logistics_user_id
            ]
        );
        // renvoyer une réponse si ok et prévoire une réponse si l'insertion échoue
        $message = "le message à bien été envoyé";
        header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
        exit;
    }

    function updateMessageReport(){
        // post 
        $db = new Database();
        
        $connexion = $db->getconnection();

        $user_id = $_POST["user_id"];
        $message = $_POST["message"];
        $message_id = $_POST["message_id"];

        $sql = "
            SELECT employee_report.employee_report_user_id
            FROM employee_report
            WHERE employee_report_user_id = :user_id
        ";

        $statement = $connexion->prepare($sql);

        $statement->execute([
                ':user_id' => $user_id
        ]);

        $user = $statement -> fetchAll(PDO::FETCH_ASSOC);

        if($user) {
            
            $sql = $connexion->prepare("
                    UPDATE employee_report
                    SET employee_report_message = :message
                    WHERE employee_report_id = :message_id
            ");

            $sql -> execute([
                ':message' => $message,
                ':message_id' => $message_id
            ]);

            $connexion = null;

            $message = "le message à bien été modifié";
            header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
            exit;

        } else {
            $message = "vous ne pouvez pas modifier le message";
            header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
            exit;
        }
        
        // 1. vérifier que l'id de l'emetteur du méssage est le meme que celui de
        // l'utilisateur connecter

        // 2. Si oui modifier le message

        // 3. revoyer une une réponse si le message a été envoyer ou non
        
    }

    function deleteMessageReport($message_id){ // CONTROLLER NON FINI !
        // GET
        $db = new Database();
        
        $connexion = $db->getconnection();
        
        // si émétteur ou receveur supprimer le message
        $sql = "
            SELECT employee_report.employee_report_user_id
            FROM employee_report
            WHERE employee_report_user_id = :user_id
        ";

        $statement = $connexion->prepare($sql);

        $statement->execute([
                ':user_id' => $user_id
        ]);

        $user = $statement -> fetchAll(PDO::FETCH_ASSOC);
        // renvoyer une reponse si ok ou non
        $message = "le message à bien été suprimer";
        header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
        exit;
    }
}