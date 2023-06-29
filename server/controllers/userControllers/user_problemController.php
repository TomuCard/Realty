<?php
//Inclusion du fichier pour afficher les erreurs 
require_once './debug.php';
//Inclusion du fichier pour la connexion a la BDD
require_once './database/client.php';

//Création d'un controller (objet) de la table user_problem de la BDD
class user_problem {

    function addUserProblem(){

        // 1. Initialiser l'objet Database
        $db = new Database();

        // 2. Obtenir la connexion à la base de données
        $connexion = $db->getConnection();

        // 3. Récupérer les champs du formulaire
        $user_id = $_POST['user_id'];
        $apartment_id = $_POST['apartment_id'];
        $problem_description = $_POST['problem_description'];

        // 4. Préparer la requête pour insérer le problème d'utilisateur dans la base de données
        $request = $connexion->prepare("
            INSERT INTO user_problem (
                user_problem_user_id,
                user_problem_apartment_id,
                user_problem_description
            ) VALUES (
                :user_id,
                :apartment_id,
                :problem_description
            )
        ");

        // 5. Exécuter la requête
        $request->execute([
            ":user_id" => $user_id,
            ":apartment_id" => $apartment_id,
            ":problem_description" => $problem_description
        ]);

        // ----------------------------------------------------------------------------------------------------

        $message_id = $connexion->lastInsertId();

        $logistic = $connexion->prepare("
            SELECT apartment_employee_logistique_user_id
            FROM apartment_employee
            WHERE apartment_employee_apartment_id = :apartment_id
        ");
    
        $logistic->execute([':apartment_id' => $apartment_id]);

        $idLogisticWant = $logistic->fetch(PDO::FETCH_ASSOC);
    
        $logistic_id = $idLogisticWant['apartment_employee_logistique_user_id'];
        $apartmentId = $apartment_id;
        $message = "vous avez une demande d'un locataire";
        $link = 'http://localhost:3000/pages/company/employee/employeemessage.php?id=' . $apartmentId;
        $messageId = $message_id;
    
        $notification = $connexion->prepare("
            INSERT INTO notification_message (
                notification_message_user_logistic_id,
                notification_message_apartment_id,
                notification_message_message,
                notification_message_link,
                notification_message_user_problem_id
            ) VALUES (
                :logistic_id,
                :apartmentId,
                :message,
                :link,
                :messageId
            )
        ");
    
        $notification->execute([
            ':logistic_id' => $logistic_id,
            ':apartmentId' => $apartmentId,
            ':message' => $message,
            ':link' => $link,
            ':messageId' => $messageId
        ]);


        // 7. Fermer la connexion à la base de données
        $connexion = null;

    
            header('Location: http://localhost:3000/pages/userspace/message.php');
            exit;
    }

    function responseUserProblem(){

        // 1. Initialiser l'objet Database
        $db = new Database();

        // 2. Obtenir la connexion à la base de données
        $connexion = $db->getConnection();

        // 3. Récupérer les champs du formulaire
        $user_id = $_POST['user_id'];
        $apartment_id = $_POST['apartment_id'];
        $problem_description = $_POST['problem_description'];

        // 4. Préparer la requête pour insérer le problème d'utilisateur dans la base de données
        $request = $connexion->prepare("
            INSERT INTO user_problem (
                user_problem_user_id,
                user_problem_apartment_id,
                user_problem_description
            ) VALUES (
                :user_id,
                :apartment_id,
                :problem_description
            )
        ");

        // 5. Exécuter la requête
        $request->execute([
            ":user_id" => $user_id,
            ":apartment_id" => $apartment_id,
            ":problem_description" => $problem_description
        ]);

        // 7. Fermer la connexion à la base de données
        $connexion = null;

        header('Location: http://localhost:3000/pages/company/employee/employeemessage.php?id=' . $apartment_id);
        exit;
    }

    
    function getOneUserProblem($problemId, $loggedInUserId){
        // 1. Utilisation de l'objet Database
        $db = new Database();
    
        // 2. Appel de la fonction getconnection de Database
        $connexion = $db->getconnection();
    
        // 3. Préparation de la requête pour récupérer un problème utilisateur spécifié
        $request = $connexion->prepare("SELECT * FROM user_problem WHERE problem_id = :problemId");
    
        // 4. Exécution de la requête en utilisant le problème ID spécifié
        $request->execute([":problemId" => $problemId]);
    
        // 5. Récupération des données du problème
        $userProblem = $request->fetch(PDO::FETCH_ASSOC);
    
        // 6. Vérification de l'existence du problème
        if ($userProblem) {
            // Vérification si l'utilisateur connecté est autorisé à accéder au problème
            if ($userProblem['user_id'] == $loggedInUserId) {
                // Problème trouvé et utilisateur autorisé, renvoyer les données au format JSON
                header('Content-Type: application/json');
                echo json_encode($userProblem);
            } else {
                // Problème introuvable ou accès non autorisé, renvoyer un message d'erreur
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Accès non autorisé au problème.']);
            }
        } else {
            // Problème introuvable, renvoyer un message d'erreur
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Le problème spécifié n\'existe pas.']);
        }
    }
    

    function getAllUserProblem($apartment_id, $user_id){
        // 1. Utilisation de l'objet Database
        $db = new Database();
    
        // 2. Appel de la fonction getconnection de Database
        $connexion = $db->getconnection();
    
        // 3. Préparation de la requête pour récupérer tous les problèmes utilisateur
        $request = $connexion->prepare("
            SELECT 
            user.user_id,
            user.user_firstname, 
            user.user_lastname,
            user.user_statut, 
            user_problem.user_problem_description, 
            user_problem.user_problem_created_at
            FROM user_problem
            JOIN user
            ON user_problem.user_problem_user_id = user.user_id
            WHERE user_problem.user_problem_apartment_id = :apartment_id
            AND user_problem_user_id = :user_id
            OR user_statut = 'Logistique' AND user_problem.user_problem_apartment_id = :apartment_id
            ORDER BY user_problem.user_problem_created_at DESC
        ");
    
        // 4. Exécution de la requête
        $request->execute([
            ':apartment_id' => $apartment_id,
            ':user_id' => $user_id
        
        ]);
    
        // 5. Récupération des données des problèmes utilisateur
        $userProblems = $request->fetchAll(PDO::FETCH_ASSOC);
    
        // Renvoyer les problèmes autorisés au format JSON
        header('Content-Type: application/json');
        echo json_encode($userProblems);
        
    }

    function getAllUserProblemLogistic($apartment_id, $user_id){
        // 1. Utilisation de l'objet Database
        $db = new Database();
    
        // 2. Appel de la fonction getconnection de Database
        $connexion = $db->getconnection();
    
        // 3. Préparation de la requête pour récupérer tous les problèmes utilisateur
        $request = $connexion->prepare("
            SELECT 
            user.user_id,
            user.user_firstname, 
            user.user_lastname,
            user.user_statut, 
            user_problem.user_problem_description, 
            user_problem.user_problem_created_at
            FROM user_problem
            JOIN user
            ON user_problem.user_problem_user_id = user.user_id
            WHERE user_problem.user_problem_apartment_id = :apartment_id
            AND user_problem_user_id = :user_id
            OR user_statut = 'Client' AND user_problem.user_problem_apartment_id = :apartment_id
            ORDER BY user_problem.user_problem_created_at DESC
        ");
    
        // 4. Exécution de la requête
        $request->execute([
            ':apartment_id' => $apartment_id,
            ':user_id' => $user_id
        
        ]);
    
        // 5. Récupération des données des problèmes utilisateur
        $userProblems = $request->fetchAll(PDO::FETCH_ASSOC);
    
        // Renvoyer les problèmes autorisés au format JSON
        header('Content-Type: application/json');
        echo json_encode($userProblems);
        
    }
    
    
    function updateUserProblemStatut(){
        // Vérification si la méthode de la requête est bien POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['error' => 'Méthode non autorisée.']);
            return;
        }
    
        // Récupération des données du formulaire
        $problemId = $_POST['problemId'];
        $newStatus = $_POST['newStatus'];
    
        // Validation des données (ajoutez vos propres validations ici)
    
        // 1. Utilisation de l'objet Database
        $db = new Database();
    
        // 2. Appel de la fonction getconnection de Database
        $connexion = $db->getconnection();
    
        // 3. Préparation de la requête pour mettre à jour le statut du problème utilisateur
        $request = $connexion->prepare("UPDATE user_problem SET problem_statut = :newStatus WHERE problem_id = :problemId");
    
        // 4. Exécution de la requête avec les paramètres
        $request->execute([
            ":newStatus" => $newStatus,
            ":problemId" => $problemId
        ]);
    
        // 5. Vérification si la mise à jour a été effectuée
        if ($request->rowCount() > 0) {
            // Mise à jour réussie, renvoyer une réponse JSON avec un message de succès
            header('Content-Type: application/json');
            echo json_encode(['success' => 'Statut du problème utilisateur mis à jour avec succès.']);
        } else {
            // Aucune ligne affectée, le problème n'existe peut-être pas ou le statut est déjà le même
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Impossible de mettre à jour le statut du problème utilisateur. Vérifiez les informations fournies.']);
        }
    }
    
}