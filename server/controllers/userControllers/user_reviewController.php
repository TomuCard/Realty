<?php
//Inclusion du fichier pour afficher les erreurs 
require_once './debug.php';
//Inclusion du fichier pour la connexion a la BDD
require_once './database/client.php';

//Création d'un controller (objet) de la table user_review de la BDD
class User_review {

    function getAllCommentForOneApartment($apartment_id){

         // j'appelle l'objet base de donnée
         $db = new Database();

         // je me connecte à la BDD avec la fonction getConnection de l'objet Database
         $connexion = $db->getConnection();

         // je prépare la requête
         $sql = $connexion->prepare("   SELECT user_review.user_review_comment , user.firstname , user.lastname 
                                        FROM user_review 
                                        JOIN user 
                                        ON user.user_id = user.id 
                                        WHERE user_review.user_review_apartment_id = :apartment_id
                                    "); 
         // j'exécute la requête
         $sql->execute([
             'apartment_id' => $apartment_id
         ]);
         // je récupère tous les résultats dans users
         $comments = $sql->fetchAll(PDO::FETCH_ASSOC);
         // je ferme la connection
         $connection = null;

         // je renvoie au front les données au format json
         header('Content-Type: application/json');
         echo json_encode($comments);

        }
    function addCommentForOneApartment($apartment_id){

            $user_id = $_SESSION['user_id'];
            $user_review_comment = $_POST['user_review_comment'];

            // Create a new instance of the Database class
            $db = new Database();

            // Establish a connection to the database
            $connection = $db->getConnection();

            // Prepare the SQL statement to insert the relation
            $sql = "INSERT INTO comment (user_review.user_review_comment, user_review.user_review_user_id, user_review.user_review_apartment_id) VALUES (:user_review_comment, :user_id, :apartment_id)";
            $statement = $connection->prepare($sql);

            $statement->execute([
                ':user_review_comment' => $user_review_comment ,
                ':user_id' => $user_id ,
                ':apartment_id' => $apartment_id
            ]);

             // Close the database connection
            $connection = null;


    }

    function updateOneComment($comment_id){

        $user_id = $_SESSION['user_id'];
        $user_review_comment = $_POST['user_review_comment'];


        // Create a new instance of the Database class
        $db = new Database();

        // Establish a connection to the database
        $connection = $db->getConnection();

        // véfifier que l'utilisateur est l'auteur du commentaire
        $sql = "SELECT user_review.user_id
                FROM user_review
                WHERE user_reviw_user_id = :user_id
                AND user_review_user_id = :user_id
                ";

        $statement = $connection->prepare($sql);

        $statement->execute([':user_id' => $user_id]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if($user){

            // Prepare the SQL statement to update the comment
            $sql = "
                UPDATE user_review 
                SET user_review.user_review_comment = :user_review_comment 
                WHERE user_review__user_id = :user_id
            ";
            $statement = $connection->prepare($sql);

            $statement->execute([
                ':user_review_comment' => $user_review_comment,
                ':user_review_id' => $user_id
            ]);

            // Close the database connection
            $connection = null;

            $message = "les modifications ont bien été prit en compte";
            header('Location: http://localhost:3000/pages/location/locations.php' . urlencode($message));
            exit;

        }else{
            $message = "vous ne pouvez pas modifier le message";
            header('Location: http://localhost:3000/pages/location/locations.php' . urlencode($message));
            exit;
        }

    }

    function deleteOneComment($comment_id){

        // l'id de l'utilisateur

        $db = new Database();

        $user_id = $_SESSION['user_id']; 

        // Establish a connection to the database
        $connection = $db->getConnection();

         // véfifier que l'utilisateur est l'auteur du commentaire
         $sql = "
            SELECT user_review.user_id
                FROM user_review
                WHERE user_reviw_user_id = :user_id
                AND user_review_user_id = :user_id
        ";


        $statement = $connection->prepare($sql);

        $statement->execute([':user_id' => $user_id]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if($user){
            // Prepare the SQL statement to delete the comment
            $sql = "DELETE FROM comment WHERE comment.id = :comment_id";

            $statement = $connection->prepare($sql);

            $statement->execute([':comment_id' => $comment_id]);

            // Close the database connection
            $connection = null;

            $message = "le commentaire ont bien été supprimer";
            header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
            exit;

        }else{
            $message = "Vous n'avez pas l'authorisation";
            header('Location: http://localhost:3000/Page/#.php?message=' . urlencode($message));
            exit;
        }

    }


}
    

