<?php
//Inclusion du fichier pour afficher les erreurs 
require_once './debug.php';
//Inclusion du fichier pour la connexion a la BDD
require_once './database/client.php';

//Création d'un controller (objet) de la table apartment de la BDD
class Apartment {
    
    function addApartment(){
        
        $db = new Database();

        $connexion = $db->getconnection();

        $title = $_POST["title"];
        $description = $_POST["description"];
        $mainPicture = $_FILES["mainPicture"];
        $picture360 = $_FILES["picture360"];
        $adress = $_POST["adress"];
        $zipCode = $_POST["zipCode"];
        $city = $_POST["city"];
        $price = $_POST["price"];
        $size = $_POST["size"];
        $bedroom = $_POST["bedroom"];
        $capacity = $_POST["capacity"];

        if(
        $title
        && $description
        && $mainPicture
        && $picture360
        && $adress
        && $zipCode
        && $city
        && $price
        && $size
        && $bedroom
        && $capacity
        ){
            // enregistrement de mainPicture
            $mainPictureDir = './images/pictures/';
            $mainPictureName = basename($mainPicture['name']);
            $mainPicturePath = $mainPictureDir . $mainPictureName;

            $imageFileType = strtolower(pathinfo($mainPicturePath, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(array('message' => 'Le fichier doit être une image (jpg, jpeg, png).'));
                return;
            }
            // enregistrement de pisture360
            $picture360Dir = './images/360/';
            $picture360Name = basename($picture360['name']);
            $picture360Path = $picture360Dir . $picture360Name;

            $imageFileType = strtolower(pathinfo($picture360Path, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(array('message' => 'Le fichier doit être une image (jpg, jpeg, png).'));
                return;
            }

            if(
                move_uploaded_file($mainPicture['tmp_name'], $mainPicturePath) 
                && move_uploaded_file($picture360['tmp_name'], $picture360Path) 
            ) {

                $request = $conexion->prepare("
                    INSERT INTO apartment (
                        apartment_title,
                        apartment_description,
                        apartment_main_picture,
                        apartment_360_picture,
                        apartment_adress,
                        apartment_zip_code,
                        apartment_city,
                        apartment_price,
                        apartment_size,
                        apartment_bedroom,
                        apartment_capacity   
                    ) VALUES (
                        :title
                        :description
                        :mainPicture
                        :picture360
                        :adress
                        :zipCode
                        :city
                        :price
                        :size
                        :bedroom
                        :capacity
                    )
                "); 

                $mainPicturePath = 'http://localhost:4000/images/pictures/' . $mainPictureName;
                $picture360Path = 'http://localhost:4000/images/pictures/' . $picture360Name;

                $request->execute([
                        ':title' => $title,
                        ':description' => $description,
                        ':mainPicture' => $mainPicturePath,
                        ':picture360' => $picture360Path,
                        ':adress' => $adress,
                        ':zipCode' => $zipCode,
                        ':city' => $city,
                        ':price' => $price,
                        ':size' => $size,
                        ':bedroom' => $bedroom,
                        ':capacity' => $capacity
                ]);

                $connexion= null;
                $message = "l'appartement à bien été ajouter";
                // header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
                exit;
            }else{
                $connexion= null;
                $message = "Enregitrement de l'image impossible";
                // header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
                exit;
            }
        }else{
            $connexion= null;
            $message = "tous les champs sont requis";
            // header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
            exit;
        }

    }

    function updateApartment() {
        $db = new Database();
        $connexion = $db->getConnection();
    
        $apartment_id = $_POST['apartment_id'];
        $request = "UPDATE apartment SET ";
    
        $params = array(':apartment_id' => $apartment_id);
    
        if (!empty($_POST['title'])) {
            $request .= "apartment_title = :title, ";
            $params[':title'] = $_POST['title'];
        }
        if (!empty($_POST['description'])) {
            $request .= "apartment_description = :description, ";
            $params[':description'] = $_POST['description'];
        }
        if (!empty($_FILES['mainPicture'])) {
            $request .= "apartment_main_picture = :mainPicture, ";

            $mainPictureDir = './images/pictures/';
            $mainPictureName = basename($mainPicture['name']);
            $mainPicturePath = $mainPictureDir . $mainPictureName;

            $imageFileType = strtolower(pathinfo($mainPicturePath, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(array('message' => 'Le fichier doit être une image (jpg, jpeg, png).'));
                return;
            }
            if(move_uploaded_file($mainPicture['tmp_name'], $mainPicturePath)){
                $mainPicturePath = 'http://localhost:4000/images/pictures/' . $mainPictureName;
                $params[':mainPicture'] = $mainPicturePath;
            }
        }
        if (!empty($_POST['picture360'])) {
            $request .= "apartment_360_picture = :picture360, ";

            $picture360Dir = './images/360/';
            $picture360Name = basename($picture360['name']);
            $picture360Path = $picture360Dir . $picture360Name;

            $imageFileType = strtolower(pathinfo($picture360Path, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(array('message' => 'Le fichier doit être une image (jpg, jpeg, png).'));
                return;
            }
            if(move_uploaded_file($picture360['tmp_name'], $picture360Path)){
                $picture360Path = 'http://localhost:4000/images/pictures/' . $picture360Name;
                $params[':picture360'] = $picture360Path;
            }
        }
        if (!empty($_POST['adress'])) {
            $request .= "apartment_adress = :adress, ";
            $params[':adress'] = $_POST['adress'];
        }
        if (!empty($_POST['zipCode'])) {
            $request .= "apartment_zip_code = :zipCode, ";
            $params[':zipCode'] = $_POST['zipCode'];
        }
        if (!empty($_POST['city'])) {
            $request .= "apartment_city = :city, ";
            $params[':city'] = $_POST['city'];
        }
        if (!empty($_POST['price'])) {
            $request .= "apartment_price = :price, ";
            $params[':price'] = $_POST['price'];
        }
        if (!empty($_POST['size'])) {
            $request .= "apartment_size = :size, ";
            $params[':size'] = $_POST['size'];
        }
        if (!empty($_POST['bedroom'])) {
            $request .= "apartment_bedroom = :bedroom, ";
            $params[':bedroom'] = $_POST['bedroom'];
        }
        if (!empty($_POST['capacity'])) {
            $request .= "apartment_capacity = :capacity, ";
            $params[':capacity'] = $_POST['capacity'];
        }
    
        // Supprimez la virgule et l'espace supplémentaires à la fin de la requête
        $request = rtrim($request, ', ');
    
        $request .= " WHERE apartment_id = :apartment_id";
    
        $stmt = $connexion->prepare($request);
        $stmt->execute($params);
    
        $connexion = null;
        $message = "L'appartement a bien été mis à jour";
        // header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
        exit;
    }

    function getOneApartment($apartment_id){
        // get avec parametre
        $db = new Database();

        $connexion = $db->getconnection();

        // récupérer les infos d'un appartement 
        $request = $connexion->prepare("
            SELECT apartment.*,
            JSON_ARRAYAGG(JSON_OBJECT('service_name', service.service_name)) AS services,
            (
            SELECT JSON_ARRAYAGG(
                JSON_OBJECT(
                    'id', user_review.user_review_id,
                    'firstname', user.user_firstname,
                    'lastname', user.user_lastname,
                    'comment', user_review.user_review_comment
                )
            )
            FROM user_review
            JOIN user 
            ON user_review.user_review_user_id = user.user_id
            WHERE user_review.user_review_apartment_id = :apartment_id
            ) AS reviews
            FROM apartment
            LEFT JOIN apartment_service ON apartment.apartment_id = apartment_service.apartment_service_apartment_id
            LEFT JOIN service ON apartment_service.apartment_service_service_id = service.service_id
            WHERE apartment.apartment_id = :apartment_id
            GROUP BY apartment.apartment_id
    
        ");
        
        $request->execute([':apartment_id' => $apartment_id]);

        $apartmentInfos = $request->fetch(PDO::FETCH_ASSOC);

        $connexion= null;


        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: GET, POST");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Credentials: true");

        header('Content-Type: application/json; charset=utf-8' );
        echo json_encode($apartmentInfos);
    }

    function getOneImageOfOneApartment($apartment_id){
         // get avec parametre
        $db = new Database();

        $connexion = $db->getconnection();

        // récupérer les infos d'un appartement 
        $request = $connexion->prepare("
            SELECT apartment_360_picture
            FROM apartment
            WHERE apartment_id = :apartment_id
        ");

        $request->execute([':apartment_id' => $apartment_id]);

        $apartmentImage = $request->fetch(PDO::FETCH_ASSOC);

        $connexion= null;

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST");
        header("Access-Control-Allow-Headers: Content-Type");

        header('Content-Type: application/json');
        $apartmentImage['apartment_360_picture'] = str_replace('.', '-', $apartmentImage['apartment_360_picture']);
        echo json_encode($apartmentImage);
    }

    function getAllApartment(){
        
        // 1. J'utilise l'objet Database
        $db = new Database();

        // 2. J'appelle la fonction getconnection de Database
        $connexion = $db->getconnection();

        // 3. je prépare ma requète
        $request = $connexion->prepare("
        SELECT *
        FROM apartment
        LEFT JOIN apartment_rental ON apartment_rental_apartement_id = apartment_id
        WHERE (
            CURDATE() < apartment_rental.apartment_rental_start
            OR CURDATE() > apartment_rental.apartment_rental_end
            OR apartment_rental.apartment_rental_start IS NULL
            OR apartment_rental.apartment_rental_end IS NULL
        );
        
        ");
        // 4. J'exécute ma requête
        $request->execute();

        // 5. je renvoie les données au front en json
        $apartmentInfos = $request->fetchAll(PDO::FETCH_ASSOC);

        $connexion= null;
        
        // je renvoie au front les données au format json
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($apartmentInfos);


    }

    function deleteApartment($apartment_id){

        $db = new Database();

        $connexion = $db->getconnection();
        
        $request = $connexion->prepare("
            DELETE FROM apartment
            WHERE apartment_id = :apartment_id
        ");

        $request->execute([':apartment_id' => $apartment_id]);

        $connexion= null;

        $message = "l'appartement à bien été suprimer";
        // header('Location: http://localhost:3000/messagePages/viewAllMessages.php=' . urlencode($message));
        exit;

    }

    function searchApartment($zipCode, $startDate, $endDate){

        $db = new Database();

        $connexion = $db->getconnection();

        if($zipCode && !$startDate && !$endDate ){
            $request = $connexion->prepare("
                SELECT *
                FROM apartment
                WHERE apartment.apartment_zip_code = :zipCode
            ");
            // 4. J'exécute ma requête
            $request->execute([':zipCode' => $zipCode]);
    
            // 5. je renvoie les données au front en json
            $apartments = $request->fetchAll(PDO::FETCH_ASSOC);
    
            $connexion= null;
            
            if ($apartments) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($apartments);
            } else {
                $message = "aucun appartement trouvé";
                header('Location: http://localhost:3000/pages/location/locations.php?message=' . urlencode($message));
                exit;
            }

        }else if ($zipCode && $startDate && $endDate){
            $request = $connexion->prepare("
                SELECT 
                apartment.apartment_id,
                apartment.apartment_main_picture,
                apartment.apartment_adress,
                apartment.apartment_description,
                apartment.apartment_price,
                apartment_rental.apartment_rental_start,
                apartment_rental.apartment_rental_end
                FROM apartment
                JOIN apartment_rental
                ON apartment_rental.apartment_rental_apartement_id = apartment.apartment_id
                WHERE apartment.apartment_zip_code = :zipCode
            ");
            // 4. J'exécute ma requête
            $request->execute([':zipCode' => $zipCode]);
    
            // 5. je renvoie les données au front en json
            $apartments = $request->fetchAll(PDO::FETCH_ASSOC);
    
            $connexion= null;

            if($apartments){
                $apartment_free = array();
                foreach ($apartments as $apartment) {
                    $rentalStart = $apartment['apartment_rental_start'];
                    $rentalEnd = $apartment['apartment_rental_end'];
                
                    if (!($startDate == $rentalStart || $endDate == $rentalEnd ||
                        ($startDate >= $rentalStart && $startDate <= $rentalEnd) ||
                        ($endDate >= $rentalStart && $endDate <= $rentalEnd) ||
                        ($rentalStart >= $startDate && $rentalStart <= $endDate) ||
                        ($rentalEnd >= $startDate && $rentalEnd <= $endDate))) {
                        
                        if ($startDate < $rentalEnd){     
                            array_push($apartment_free, $apartment);
                        }
                    }
                }
                if ($apartment_free){
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($apartment_free);
                }else{
                    $connexion= null;
                    $message = "aucun appartement trouvé";
                    header('Location: http://localhost:3000/pages/location/locations.php?message=' . urlencode($message));
                    exit;
                }



            }else{
                $connexion= null;
                $message = "aucun appartement trouvé";
                header('Location: http://localhost:3000/pages/location/locations.php?message=' . urlencode($message));
                exit;
            }

        }else if (!$zipCode && $startDate && $endDate){
            $request = $connexion->prepare("
                SELECT
                apartment.apartment_id, 
                apartment.apartment_main_picture,
                apartment.apartment_adress,
                apartment.apartment_description,
                apartment.apartment_price,
                apartment_rental.apartment_rental_start,
                apartment_rental.apartment_rental_end
                FROM apartment
                JOIN apartment_rental
                ON apartment_rental.apartment_rental_apartement_id = apartment.apartment_id
            ");
            // 4. J'exécute ma requête
            $request->execute();
    
            
            // 5. je renvoie les données au front en json
            $apartments = $request->fetchAll(PDO::FETCH_ASSOC);
    
            $connexion= null;

            if($apartments){
                $apartment_free = array();
                foreach ($apartments as $apartment) {
                    $rentalStart = $apartment['apartment_rental_start'];
                    $rentalEnd = $apartment['apartment_rental_end'];
                
                    if (!($startDate == $rentalStart || $endDate == $rentalEnd ||
                        ($startDate >= $rentalStart && $startDate <= $rentalEnd) ||
                        ($endDate >= $rentalStart && $endDate <= $rentalEnd) ||
                        ($rentalStart >= $startDate && $rentalStart <= $endDate) ||
                        ($rentalEnd >= $startDate && $rentalEnd <= $endDate))) {
                        
                        if ($startDate < $rentalEnd){

                            array_push($apartment_free, $apartment);
                        }      
                        
                    }
                }
                if ($apartment_free){
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($apartment_free);
                }else{
                    $connexion= null;
                    $message = "aucun appartement trouvé";
                    header('Location: http://localhost:3000/pages/location/locations.php?message=' . urlencode($message));
                    exit;
                }
            }else{
                $connexion= null;
                $message = "aucun appartement trouvé";
                header('Location: http://localhost:3000/pages/location/locations.php?message=' . urlencode($message));
                exit;
            }

        }
    }
    function logisticGetOneApartment($apartment_id){
         $db = new Database();

         $connexion = $db->getconnection();

         $request = $connexion->prepare("
             SELECT apartment.*,
             JSON_ARRAYAGG(JSON_OBJECT(
                'service_id', service.service_id,
                'service_name', service.service_name
            )) AS servicesOfApartment,
             (
             SELECT JSON_ARRAYAGG(
                 JSON_OBJECT(
                     'firstname', user.user_firstname,
                     'lastname', user.user_lastname,
                     'id', comment_progress.comment_progress_id,
                     'comment', comment_progress.comment_progress_comment
                 )
             )
             FROM comment_progress
             JOIN user 
             ON comment_progress.comment_progress_user_id = user.user_id
             WHERE comment_progress.comment_progress_apartment_id = :apartment_id
             ) AS commentProgress
             FROM apartment
             LEFT JOIN apartment_service ON apartment.apartment_id = apartment_service.apartment_service_apartment_id
             LEFT JOIN service ON apartment_service.apartment_service_service_id = service.service_id
             WHERE apartment.apartment_id = :apartment_id
             GROUP BY apartment.apartment_id
     
         ");
         
         $request->execute([':apartment_id' => $apartment_id]);
 
         $apartmentInfos = $request->fetch(PDO::FETCH_ASSOC);
 
         $connexion= null;
 
 
         header("Access-Control-Allow-Origin: http://localhost:3000");
         header("Access-Control-Allow-Methods: GET, POST");
         header("Access-Control-Allow-Headers: Content-Type");
         header("Access-Control-Allow-Credentials: true");
 
         header('Content-Type: application/json; charset=utf-8' );
         echo json_encode($apartmentInfos);
    }

}