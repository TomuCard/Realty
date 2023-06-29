<?php
//Inclusion du fichier pour afficher les erreurs 
require_once './debug.php';
//Inclusion du fichier pour la connexion a la BDD
require_once './database/client.php';

//Création d'un controller (objet) de la table User_invoice de la BDD
class User_invoice {

    function getOneUserInvoiceForOneUser($user_invoice_id, $invoice_id) {
        $db = new Database();
        $connexion = $db->getConnection();

        // Vérification de l'existence de l'utilisateur
        $checkUserQuery = $connexion->prepare("
            SELECT COUNT(*) as count
            FROM user
            WHERE user_id = :user_invoice_id
        ");
        $checkUserQuery->execute([
            ":user_invoice_id" => $user_invoice_id
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

        // Récupération de la facture de l'utilisateur spécifié
        $getInvoiceQuery = $connexion->prepare("
            SELECT *
            FROM user_invoice
            WHERE user_invoice_id = :user_invoice_id AND user_invoice_user_id = :invoice_id
        ");
        $getInvoiceQuery->execute([
            ":user_invoice_id" => $user_invoice_id,
            ":user_invoice_user_id" => $invoice_id
        ]);
        $invoice = $getInvoiceQuery->fetch(PDO::FETCH_ASSOC);

        // Vérification si la facture existe
        if (!$invoice) {
            $message = "La facture spécifiée n'existe pas.";
            $response = [
                "success" => false,
                "message" => $message
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // Fermeture de la connexion
        $connexion = null;

        // Réponse JSON contenant la facture de l'utilisateur
        $response = [
            "success" => true,
            "invoice" => $invoice
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }


    function getAllUserInvoiceForOneUser($user_invoice_id) {
        $db = new Database();
        $connexion = $db->getConnection();

        // Vérification de l'existence de l'utilisateur
        $checkUserQuery = $connexion->prepare("
            SELECT COUNT(*) as count
            FROM user
            WHERE user_id = :user_invoice_id
        ");
        $checkUserQuery->execute([
            ":user_invoice_id" => $user_invoice_id
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

        // Récupération de toutes les factures de l'utilisateur
        $getAllInvoicesQuery = $connexion->prepare("
            SELECT *
            FROM user_invoice
            WHERE user_invoice_id = :user_invoice_id
        ");
        $getAllInvoicesQuery->execute([
            ":user_invoice_id" => $user_invoice_id
        ]);
        $invoices = $getAllInvoicesQuery->fetchAll(PDO::FETCH_ASSOC);

            // Fermeture de la connexion
        $connexion = null;

        // Réponse JSON contenant toutes les factures de l'utilisateur
        $response = [
            "success" => true,
            "invoices" => $invoices
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
}


function getAllUserInvoiceAmountForDashboard() {
    // Créer une instance de la classe Database pour la connexion à la base de données
    $db = new Database();
    $connection = $db->getConnection();

    // Requête pour récupérer le montant total des factures pour le tableau de bord
    $query = "SELECT SUM(user_invoice_amount) AS total_amount FROM user_invoice";

    // Exécution de la requête
    $result = $connection->query($query);

    // Vérification du résultat de la requête
    if ($result) {
        // Récupération du montant total des factures
        $totalAmount = $result->fetchColumn();

        // Fermeture de la connexion à la base de données
        $connection = null;

        // Réponse JSON contenant le montant total des factures
        $response = [
            "success" => true,
            "total_amount" => $totalAmount
        ];
    } else {
        // Erreur lors de l'exécution de la requête
        $response = [
            "success" => false,
            "message" => "Une erreur s'est produite lors de la récupération du montant total des factures."
        ];
    }

    // Envoi de la réponse JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}


    function createOneUserInvoice() {
        // Vérifier si les données nécessaires sont présentes dans la requête
        if (!isset($_POST['user_id']) || !isset($_POST['amount'])) {
            $response = [
                "success" => false,
                "message" => "Les données requises sont manquantes."
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        // Récupérer les données de la requête
        $user_id = $_POST['user_id'];
        $amount = $_POST['amount'];
    
        $db = new Database();
        $connexion = $db->getConnection();
    
        // Vérification de l'existence de l'utilisateur
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
    
        // Insertion d'une nouvelle facture pour l'utilisateur
        $insertInvoiceQuery = $connexion->prepare("
            INSERT INTO user_invoice (user_id, user_invoice_amount)
            VALUES (:user_id, :amount)
        ");
        $insertInvoiceQuery->execute([
            ":user_id" => $user_id,
            ":user_invoice_amount" => $amount
        ]);
    
        // Récupération de l'ID de la facture nouvellement créée
        $invoiceId = $connexion->lastInsertId();
    
        // Récupération des informations de la facture créée
        $getInvoiceQuery = $connexion->prepare("
            SELECT *
            FROM user_invoice
            WHERE user_invoice_id = :invoice_id
        ");
        $getInvoiceQuery->execute([
            ":invoice_id" => $invoiceId
        ]);
        $invoice = $getInvoiceQuery->fetch(PDO::FETCH_ASSOC);
    
        // Fermeture de la connexion
        $connexion = null;
    
        // Réponse JSON indiquant le succès de la création de la facture et les informations de la facture créée
        $response = [
            "success" => true,
            "message" => "La facture a été créée avec succès.",
            "invoice" => $invoice
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    } 
    
}