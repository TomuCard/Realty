<?php
//Inclusion du fichier pour afficher les erreurs 
require_once './debug.php';
//Inclusion du fichier pour la connexion a la BDD
require_once './database/client.php';

//Création d'un controller (objet) de la table User_favorite de la BDD
class User_favorite {
    
    function createFavoriteforOneUser() {
        // Vérifier si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $message = "La méthode de requête n'est pas autorisée.";
            $response = [
                "success" => false,
                "message" => $message
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        // Récupérer les données de la requête POST
        $user_id = $_POST['user_id'];
        $favorite_data = $_POST['favorite_data'];
    
        // Vérifier si l'utilisateur existe dans la base de données
        $db = new Database();
        $connexion = $db->getConnection();
    
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
            $message = "L'utilisateur spécifié n'existe pas.";
            $response = [
                "success" => false,
                "message" => $message
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        // Vérifier si le favori existe déjà pour cet utilisateur
        $checkFavoriteQuery = $connexion->prepare("
            SELECT COUNT(*) as count
            FROM user_favorite
            WHERE user_id = :user_id AND favorite_data = :favorite_data
        ");
        $checkFavoriteQuery->execute([
            ":user_id" => $user_id,
            ":favorite_data" => $favorite_data
        ]);
        $favoriteExists = $checkFavoriteQuery->fetchColumn();
    
        if ($favoriteExists) {
            $message = "Le favori existe déjà pour cet utilisateur.";
            $response = [
                "success" => false,
                "message" => $message
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        // Insérer le favori dans la base de données
        $insertFavoriteQuery = $connexion->prepare("
            INSERT INTO user_favorite (user_id, favorite_data)
            VALUES (:user_id, :favorite_data)
        ");
    
        $insertFavoriteQuery->execute([
            ":user_id" => $user_id,
            ":favorite_data" => $favorite_data
        ]);
    
        // Fermer la connexion à la base de données
        $connexion = null;
    
        $response = [
            "success" => true,
            "message" => "Le favori a été ajouté avec succès pour l'utilisateur."
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    

    function updateFavoriteforOneUser() {
        // Vérifier si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $message = "La méthode de requête n'est pas autorisée.";
            $response = [
                "success" => false,
                "message" => $message
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        // Récupérer les données de la requête POST
        $favorite_id = $_POST['favorite_id'];
        $new_favorite_data = $_POST['new_favorite_data'];
    
        // Vérifier si le favori existe dans la base de données
        $db = new Database();
        $connexion = $db->getConnection();
    
        $checkFavoriteQuery = $connexion->prepare("
            SELECT COUNT(*) as count
            FROM user_favorite
            WHERE favorite_id = :favorite_id
        ");
        $checkFavoriteQuery->execute([
            ":favorite_id" => $favorite_id
        ]);
        $favoriteExists = $checkFavoriteQuery->fetchColumn();
    
        if (!$favoriteExists) {
            $message = "Le favori spécifié n'existe pas.";
            $response = [
                "success" => false,
                "message" => $message
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        // Mettre à jour le favori dans la base de données
        $updateFavoriteQuery = $connexion->prepare("
            UPDATE user_favorite
            SET favorite_data = :new_favorite_data
            WHERE favorite_id = :favorite_id
        ");
    
        $updateFavoriteQuery->execute([
            ":new_favorite_data" => $new_favorite_data,
            ":favorite_id" => $favorite_id
        ]);
    
        // Fermer la connexion à la base de données
        $connexion = null;
    
        $response = [
            "success" => true,
            "message" => "Le favori a été mis à jour avec succès."
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    

    function deleteFavoriteforOneUser() {
        // Vérifier si la requête est de type GET
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $message = "La méthode de requête n'est pas autorisée.";
            $response = [
                "success" => false,
                "message" => $message
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        // Récupérer le favori ID depuis les paramètres de l'URL
        $favorite_id = $_GET['favorite_id'];
    
        // Vérifier si le favori existe dans la base de données
        $db = new Database();
        $connexion = $db->getConnection();
    
        $checkFavoriteQuery = $connexion->prepare("
            SELECT COUNT(*) as count
            FROM user_favorite
            WHERE favorite_id = :favorite_id
        ");
        $checkFavoriteQuery->execute([
            ":favorite_id" => $favorite_id
        ]);
        $favoriteExists = $checkFavoriteQuery->fetchColumn();
    
        if (!$favoriteExists) {
            $message = "Le favori spécifié n'existe pas.";
            $response = [
                "success" => false,
                "message" => $message
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        // Supprimer le favori de la base de données
        $deleteFavoriteQuery = $connexion->prepare("
            DELETE FROM user_favorite
            WHERE favorite_id = :favorite_id
        ");
    
        $deleteFavoriteQuery->execute([
            ":favorite_id" => $favorite_id
        ]);
    
        // Fermer la connexion à la base de données
        $connexion = null;
    
        $response = [
            "success" => true,
            "message" => "Le favori a été supprimé avec succès."
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    

    function getOneFavoriteForOneUser() {
        // Vérifier si la requête est de type GET
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $message = "La méthode de requête n'est pas autorisée.";
            $response = [
                "success" => false,
                "message" => $message
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        // Récupérer le favori ID depuis les paramètres de l'URL
        $favorite_id = $_GET['favorite_id'];
    
        // Vérifier si le favori existe dans la base de données
        $db = new Database();
        $connexion = $db->getConnection();
    
        $getFavoriteQuery = $connexion->prepare("
            SELECT *
            FROM user_favorite
            WHERE favorite_id = :favorite_id
        ");
        $getFavoriteQuery->execute([
            ":favorite_id" => $favorite_id
        ]);
        $favorite = $getFavoriteQuery->fetch(PDO::FETCH_ASSOC);
    
        if (!$favorite) {
            $message = "Le favori spécifié n'existe pas.";
            $response = [
                "success" => false,
                "message" => $message
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        // Fermer la connexion à la base de données
        $connexion = null;
    
        $response = [
            "success" => true,
            "favorite" => $favorite
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    
    function getAllFavoriteForOneUser() {
        // Vérifier si la requête est de type GET
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $message = "La méthode de requête n'est pas autorisée.";
            $response = [
                "success" => false,
                "message" => $message
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        // Récupérer l'ID de l'utilisateur depuis les paramètres de l'URL
        $user_id = $_GET['user_id'];
    
        // Vérifier si l'utilisateur existe dans la base de données
        $db = new Database();
        $connexion = $db->getConnection();
    
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
            $message = "L'utilisateur spécifié n'existe pas.";
            $response = [
                "success" => false,
                "message" => $message
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        // Récupérer tous les favoris de l'utilisateur depuis la base de données
        $getAllFavoritesQuery = $connexion->prepare("
            SELECT *
            FROM user_favorite
            WHERE user_id = :user_id
        ");
        $getAllFavoritesQuery->execute([
            ":user_id" => $user_id
        ]);
        $favorites = $getAllFavoritesQuery->fetchAll(PDO::FETCH_ASSOC);
    
        // Fermer la connexion à la base de données
        $connexion = null;
    
        $response = [
            "success" => true,
            "favorites" => $favorites
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
}