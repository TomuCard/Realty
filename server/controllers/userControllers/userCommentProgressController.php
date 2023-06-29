<?php
//Inclusion du fichier pour afficher les erreurs 

require_once './debug.php';
//Inclusion du fichier pour la connexion a la BDD
require_once './database/client.php';

//Création d'un controller (objet) de la table user_review de la BDD
class Comment_progress {
    


    function addCommentProgress() {
        $db = new Database();
        $connexion = $db->getConnection();
    
        $user_id = $_POST['user_id'];
        $apartment_id = $_POST['apartment_id'];
        $comment = $_POST['comment'];
    
        $sql = $connexion->prepare(" 
            INSERT INTO comment_progress (
                comment_progress_user_id,
                comment_progress_apartment_id,
                comment_progress_comment
            ) VALUES (
                :user_id,
                :apartment_id,
                :comment
            )
        ");
    
        $sql->execute([
            ':user_id' => $user_id,
            ':apartment_id' => $apartment_id,
            ':comment' => $comment
        ]);
    
        $commentProgress_id = $connexion->lastInsertId();
    
        $logistic = $connexion->prepare("
            SELECT apartment_employee_logistique_user_id
            FROM apartment_employee
            WHERE apartment_employee_apartment_id = :apartment_id
        ");
    
        $logistic->execute([':apartment_id' => $apartment_id]);
    
        $idLogisticWant = $logistic->fetch(PDO::FETCH_ASSOC);
    
        $logistic_id = $idLogisticWant['apartment_employee_logistique_user_id'];
        $apartmentId = $apartment_id;
        $message = 'Un nouveau commentaire est à valider';
        $link = 'http://localhost:3000/pages/company/admin/updateapart.php?id=' . $apartmentId;
        $comment_id = $commentProgress_id;
    
        $notification = $connexion->prepare("
            INSERT INTO notification (
                notification_user_logistic_id,
                notification_apartment_id,
                notification_message,
                notification_link,
                notification_comment_id
            ) VALUES (
                :logistic_id,
                :apartmentId,
                :message,
                :link,
                :comment_id
            )
        ");
    
        $notification->execute([
            ':logistic_id' => $logistic_id,
            ':apartmentId' => $apartmentId,
            ':message' => $message,
            ':link' => $link,
            ':comment_id' => $comment_id
        ]);
    
        $connexion = null;
    
        $message = "Merci d'avoir partagé avec nous votre expérience";
        header('Location: http://localhost:3000/pages/userspace/profile.php?validate=' . urlencode($message));
        exit;
    }
    
    function getAllCommentProgressForOneApartment($apartment_id){
        $db = new Database();
        $connexion = $db->getConnection();

        $sql = $connexion->prepare(" 
            SELECT *
            FROM comment_progress
            WHERE comment_progress_apartment_id = :apartment_id
        ");

        $sql->execute([':apartment_id' => $apartment_id]);

        $commentsProgress = $sql->fetch(PDO::FETCH_ASSOC);

        $connexion = null;

        header('Content-Type: application/json');
        echo json_encode($commentsProgress);
    }

    function commentProgressValidate($comment_id){
        $db = new Database();
        $connexion = $db->getConnection();

        // $sql = $connexion->prepare(" 
        //     SELECT notification_id
        //     FROM notification
        //     WHERE notification_comment_id = :comment_id
        // ");

        // $sql->execute([':comment_id' => $comment_id]);

        // $idNotification = $sql->fetch(PDO::FETCH_ASSOC);

        $commentWant = $connexion->prepare(" 
            SELECT 
            comment_progress_user_id,
            comment_progress_apartment_id,
            comment_progress_comment
            FROM comment_progress
            WHERE comment_progress_id = :comment_id
        ");

        $commentWant->execute([':comment_id' => $comment_id]);
        $comment = $sql->fetch(PDO::FETCH_ASSOC);

        // $notification_id = $idNotification['notification_id'];
        $user_id = $comment['comment_progress_user_id'];
        $apartment_id = $comment['comment_progress_apartment_id'];
        $comment = $comment['comment_progress_comment'];

        $review = $connexion->prepare(" 
            INSERT INTO user_review (
                user_review_user_id,
                user_review_apartment_id,
                user_review_comment
            )VALUES (
                :user_id,
                :apartment_id,
                :comment
            )
        ");

        $review->execute([
            ':user_id' => $user_id,
            ':apartment_id' => $apartment_id,
            ':comment' => $comment
        ]
        );

        $DeleteCommentProgress = $connexion->prepare(" 
            DELETE FROM comment_progress
            WHERE comment_progress_id = :comment_id
        ");

        $DeleteCommentProgress->execute([':comment_id' => $comment_id]);
        $connexion = null;
        
    }

    function commentProgressDelete($comment_id){
        $db = new Database();
        $connexion = $db->getConnection();

        $DeleteCommentProgress = $connexion->prepare(" 
            DELETE FROM comment_progress
            WHERE comment_progress_id = :comment_id
        ");

        $DeleteCommentProgress->execute([':comment_id' => $comment_id]);
    }
    function getAllNotificationForOneUser($user_id){

        $db = new Database();
        $connexion = $db->getConnection();

        $sql = $connexion->prepare(" 
        SELECT 
            notification.notification_created_at,
            notification.notification_message,
            notification.notification_link,
            notification_message.notification_message_created_at,
            notification_message.notification_message_message,
            notification_message.notification_message_link
        FROM notification
        LEFT JOIN notification_message ON notification.notification_user_logistic_id = notification_message.notification_message_user_logistic_id
        WHERE notification.notification_user_logistic_id = :user_id
        AND (
            notification.notification_created_at IS NOT NULL
            OR notification.notification_message IS NOT NULL
            OR notification.notification_link IS NOT NULL
            OR notification_message.notification_message_created_at IS NOT NULL
            OR notification_message.notification_message_message IS NOT NULL
            OR notification_message.notification_message_link IS NOT NULL
    )
        ");

        $sql->execute([':user_id' => $user_id]);

        $notifications = $sql->fetchAll(PDO::FETCH_ASSOC);


        $connexion = null;

        header('Content-Type: application/json');
        echo json_encode($notifications);
    }
    
}