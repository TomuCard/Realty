<?php
//Inclusion du fichier pour afficher les erreurs 
require_once './debug.php';
//Inclusion du fichier pour la connexion a la BDD
require_once './database/client.php';

//Création d'un controller (objet) de la table User de la BDD
class User {
    
    function createAccount(){

        // 1. j'initialise l'objet Database
        $db = new Database();

        // 2. j'utilise la fonction getconnection de l'objet Database
        $connexion = $db->getconnection();

        // 3. Si la méthod est en post, je récupère les champs du formulaire
        // ex. <input type='text' name='firstname />
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];
        $birthday = $_POST['birthday'];


        // 4. Je hash le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 5. je prépare ma requète
        $request = $connexion->prepare("
        INSERT INTO user (
            user_firstname,
            user_lastname,
            user_mail,
            user_password,
            user_birth
        ) VALUES (
            :firstname,
            :lastname,
            :mail,
            :password,
            :birthday
        )");

        // 6. J'exécute le requète    
        $request->execute(
            [
                ":firstname" => $firstname,
                ":lastname" => $lastname,
                ":mail" => $mail,
                ":password" => $hashed_password,
                ":birthday" => $birthday
            ]
        );
        // 7. Fermeture de la connexion
        $connexion = null;

        // 8. J'envoie une réponse
        $message = "le compte a bien été créé";
        header('Location: http://localhost:3000/pages/userspace/login.php?validate=' . urlencode($message));
        exit;

    }

    function loginAccount(){

        $db = new Database();

        $connexion = $db->getconnection();

        $mail = $_POST['mail'];
        $password = $_POST['password'];

        // si les champs son renseigner
        if($mail && $password) {
            // Requêtes SQL
            $request = $connexion->prepare("
                SELECT *
                FROM user 
                WHERE user_mail = :mail
            ");
            $request->execute([":mail" => $mail]);

            // je stock le résultat de la requete dans une variable
            $userInfos = $request->fetch(PDO::FETCH_ASSOC);

            // je vérifie le mot de passe
            if ($userInfos && password_verify($password, $userInfos['user_password'])) {
                // si le mot de passe est bon, je vérifi si le compte est active
                if ($userInfos['user_active'] == 1){
                    // j'ouvre une session
                    session_start();
                    // je stock dans la session l'id
                    $_SESSION['id'] = $userInfos['user_id'];
                    $_SESSION['statut'] = $userInfos['user_statut'];
                    
                    $message = 'vous ête connecter';
                    header('Location: http://localhost:3000/pages/userspace/profile.php?validate=' . urlencode($message));
                    exit;

                }else {
                    // si le compte est désactiver 
                    header('Location: http://localhost:3000/pages/userspace/login.php?id=' . urlencode($userInfos['id']));
                    exit;
                }
                
            } else {
                // si le mail ou le mot de passe est incorect
                header("HTTP/1.1 402");
                $message = "le nom d'utilisateur ou le mot de passe est incorrect";
                header('Location: http://localhost:3000/pages/userspace/login.php?error=' . urlencode($message));
                exit;
            }
        } else {
            // si il y a un champ qui n'est pas rempli
            $message = "Tout les champs sont requis";
            header('Location: http://localhost:3000/pages/userspace/login.php?message=' . urlencode($message));
            exit;
        }
        
        // Fermeture de la connexion
        $connexion = null;
    }

    function getAllUserWhereStatutIsMenage(){
        // 1. J'utilise l'objet Database
        $db = new Database();

        // 2. J'appelle la fonction getconnection de Database
        $connexion = $db->getconnection();

        // 3. je prépare ma requète attention je veut récupérer les users dont le statut 
        $request = $connexion->prepare("
            SELECT *
            FROM user
            WHERE user_statut = 'Menage'
        ");

        // 4. J'exécute ma requête
        $request->execute();

        // 5. je renvoie les données au front en json
        $userInfos = $request->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($userInfos);

    }

    function getOneUser($user_id){

        $db = new Database();

        // 2. J'appelle la fonction getconnection de Database
        $connexion = $db->getconnection();

        // 3. je prépare ma requète attention je veut récupérer un user
        $request = $connexion->prepare(" 
            SELECT *
            FROM user
            WHERE user_id = :user_id
        ");
        // 4. J'exécute ma requête
        $request->execute([ ":user_id" => $user_id]);

        $userInfos = $request->fetch(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($userInfos);

    }

    function searchUser($params){
        $db = new Database();

        // 2. J'appelle la fonction getconnection de Database
        $connexion = $db->getconnection();

        // 3. je prépare ma requète attention je veut rechercher les users
        $request = $connexion->prepare("
            SELECT user_firstname, user_lastname, user_id, user_statut
            FROM user
            WHERE user_firstname LIKE :params
            OR user_lastname LIKE :params
            OR user_mail LIKE :params
        ");

        $params = "%$params%";

        // 4. J'exécute ma requête
        $request->execute([":params" => $params]);

        $userInfos = $request->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($userInfos);
    }

    function updateAccountForOneUser(){
        // Récupération des données du formulaire
        $userId = $_POST['userId'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $mail = $_POST['mail'];
        $birthday = $_POST['birthday'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $zipCode = $_POST['zipCode'];
        $city = $_POST['city'];
    
        // Validation des données (ajoutez vos propres validations ici)
    
        // 1. Utilisation de l'objet Database
        $db = new Database();
    
        // 2. Appel de la fonction getconnection de Database
        $connexion = $db->getconnection();

        // je stock la requête dans une variable
        $request = "UPDATE user SET ";
        // je stock l'id de l'enregitrement a modifier
        $params = array(':userId' => $userId);

        // Je vérifie que le champ a bien été renseigner
        if (!empty($firstname)) {
            $request .= "user_firstname = :firstname, ";
            $params[':firstname'] = $firstname;
        }
        if (!empty($lastname)) {
            $request .= "user_lastname = :lastname, ";
            $params[':lastname'] = $lastname;
        }
        if (!empty($mail)) {
            $request .= "user_mail = :mail, ";
            $params[':mail'] = $mail;
        }
        if (!empty($password)) {
            $request .= "user_password = :password, ";
            $params[':password'] = $password;
        }
        if (!empty($birthday)) {
            $request .= "user_birth = :birthday, ";
            $params[':birthday'] = $birthday;
        }
        if (!empty($phone)) {
            $request .= "user_phone = :phone, ";
            $params[':phone'] = $phone;
        }
        if (!empty($address)) {
            $request .= "user_address = :address, ";
            $params[':address'] = $address;
        }
        if (!empty($zipCode)) {
            $request .= "user_zip_code = :zipCode, ";
            $params[':zipCode'] = $zipCode;
        }
        if (!empty($city)) {
            $request .= "user_city = :city, ";
            $params[':city'] = $city;
        }

        // Supprimez la virgule et l'espace supplémentaires à la fin de la requête
        $request = rtrim($request, ', ');
    
        $request .= " WHERE user_id = :userId";
     
        $stmt = $connexion->prepare($request);
        $stmt->execute($params);
     
        $connexion = null;
        $message = "Vos informations personnelles ont bien été mise a jour";
        header('Location: http://localhost:3000/pages/userspace/profile.php?validate=' . urlencode($message));
        exit;
    }

    function getAccountForOneUser($user_id){

        // j'appelle l'objet base de donnée
        $db = new Database();

        // je me connecte à la BDD avec la fonction getconnexion de l'objet Database
        $connexion = $db->getconnection();

        // je prépare la requête
        $sql = $connexion->prepare("
        SELECT user.*,
            JSON_ARRAYAGG(JSON_OBJECT(
                'apartment-id', apartment.apartment_id,
                'apartment-name', apartment.apartment_adress,
                'apartment-zipCode', apartment.apartment_zip_code,
                'apartment-city', apartment.apartment_city,
                'start-date', apartment_rental.apartment_rental_start,
                'end-date', apartment_rental.apartment_rental_end

            )) AS rentals,
            (
            SELECT JSON_ARRAYAGG(
                JSON_OBJECT(
                    'apartment-name', apartment.apartment_adress,
                    'apartment-zipCode', apartment.apartment_zip_code,
                    'apartment-city', apartment.apartment_city,
                    'payment-date', user_invoice.user_invoice_created_at,
                    'amount', user_invoice.user_invoice_amount
                )
            )
            FROM user_invoice
            JOIN apartment 
            ON user_invoice.user_invoice_apartment_id = apartment.apartment_id
            WHERE user_invoice.user_invoice_user_id = :user_id
            ORDER BY user_invoice.user_invoice_created_at DESC
            ) AS invoices
            FROM user
            LEFT JOIN apartment_rental ON apartment_rental.apartment_rental_user_id = user.user_id
            LEFT JOIN apartment ON apartment_rental.apartment_rental_apartement_id = apartment.apartment_id
            WHERE user.user_id = :user_id
            GROUP BY user.user_id

        ");
        // j'exécute la requête
        $sql->execute([':user_id' => $user_id]);
        // je récupère tous les résultats dans users
        $user = $sql->fetch(PDO::FETCH_ASSOC);
        // je ferme la connexion
        $connexion = null;

        // je renvoie au front les données au format json
        header('Content-Type: application/json');
        echo json_encode($user);
    }
    
    function logoutAccount(){
        session_start();
        $_SESSION['id'] = null;
        $_SESSION['statut'] = null;
        session_destroy();

        $message = "vous avez bien été déconnecté";
        header('Location: http://localhost:3000/pages/userspace/login.php?message=' . urlencode($message));
        exit;
    }

    function desactiveAccountForOneUser($user_id) {
        $db = new Database();
        $connexion = $db->getconnection();
    

        $request = $connexion->prepare("
            UPDATE user 
            SET user_active = 0
            WHERE user_id = :user_id
        ");
    
        $request->execute([
            ":user_id" => $user_id
        ]);
    
        // Fermeture de la connexion
        $connexion = null;

        $message = "Le compte a bien été désactiver ";
        header('Location: http://localhost:3000/pages/userspace/login.php?message=' . urlencode($message));
        exit;
    
       
    }

    function reactiveAccountForOneUser($user_id, $user_statut) {
        $db = new Database();
        $connexion = $db->getconnection();
    
        $request = $connexion->prepare("
            UPDATE user 
            SET user_active = 1
            WHERE user_id = :user_id
        ");
    
        $request->execute([":user_id" => $user_id]);
    
        // Fermeture de la connexion
        $connexion = null;

        $message = "Le compte a bien été réactiver ";
        header('Location: http://localhost:3000/pages/userspace/login.php?message=' . urlencode($message));
        exit;

    }
    
    function updateStatutForOneUser() {
        
        $db = new Database();
        $connexion = $db->getconnection();
    
        $user_id = $_POST['user_id'];
        $statut = $_POST['statut'];

        $request = $connexion->prepare("
            UPDATE user 
            SET user_statut = :statut
            WHERE user_id = :user_id
        ");
    
        $request->execute([
            ":user_id" => $user_id,
            ":statut" => $statut
        ]);
    
        $connexion = null;
        $message = "le statut a bien été mis a jour";
        header('Location: http://localhost:3000/pages/company/employee/checklist.php?validate=' . urlencode($message));
        exit;
    }

    function deleteAccountForOneUser($user_id) {
        $db = new Database();
        $connexion = $db->getconnection();
    
        // Vérification des conditions supplémentaires avant de supprimer le compte de l'utilisateur
    
        // 1. Vérifier si l'utilisateur existe
        $checkUserQuery = $connexion->prepare("
            SELECT COUNT(*) as count
            FROM user
            WHERE user_id = :user_id
        ");
        $checkUserQuery->execute([
            ":user_id" => $user_id
        ]);
        $userExists = $checkUserQuery->fetchColumn();
    
        if (!$userExists) {
            // Si l'utilisateur n'existe pas, vous pouvez effectuer une action ou renvoyer un message d'erreur approprié
            $message = "L'utilisateur spécifié n'existe pas.";
            // Vous pouvez rediriger l'utilisateur vers une page spécifique, afficher un message d'erreur, etc.
            $response = [
                "success" => false,
                "message" => $message
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        $request = $connexion->prepare("
            DELETE FROM user 
            WHERE user_id = :user_id
        ");
    
        $request->execute([
            ":user_id" => $user_id
        ]);
    
        // Fermeture de la connexion
        $connexion = null;
    
        // Réponse JSON indiquant le succès de l'opération
        $response = [
            "success" => true,
            "message" => "Le compte de l'utilisateur a été supprimé avec succès."
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

}