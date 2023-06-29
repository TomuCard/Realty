<?php
//Inclusion du fichier pour afficher les erreurs 
require_once './debug.php';
//Inclusion du fichier pour la connexion a la BDD
require_once './database/client.php';

//Création d'un controller (objet) de la table apartment_rental de la BDD
class Apartment_rental {
    
    function addApartmentRental(){
        $db = new Database();

        $connexion = $db->getconnection();

        $user_id = $_POST["user_id"];
        $apartment_id = $_POST["apartment_id"];
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
        $amount = $_POST["amount"];

        if( $user_id && $apartment_id && $start_date && $end_date && $amount){
            $current_date = date('Y-m-d');
            if($start_date >= $current_date && $end_date > $start_date){

                $request = $connexion->prepare("
                    SELECT *
                    FROM apartment_rental
                    WHERE apartment_rental.apartment_rental_apartement_id = :apartment_id
                ");
                $request->execute([":apartment_id" => $apartment_id]);
        
                $apartment_rental = $request->fetchAll(PDO::FETCH_ASSOC);
        
                if($apartment_rental){
    
                    $available = true;
                    foreach($apartment_rental as $rental){
    
                        $rentalStart = $rental['apartment_rental_start'];
                        $rentalEnd = $rental['apartment_rental_end'];
                        $startDate = $start_date;
                        $endDate = $end_date;
            
                        if (($startDate == $rentalStart || $endDate == $rentalEnd ||
                            ($startDate >= $rentalStart && $startDate <= $rentalEnd) ||
                            ($endDate >= $rentalStart && $endDate <= $rentalEnd) ||
                            ($rentalStart >= $startDate && $rentalStart <= $endDate) ||
                            ($rentalEnd >= $startDate && $rentalEnd <= $endDate))) {
                                
                                $available = false;
                                
                            }
                        if($available){
    
                            $request = $connexion->prepare("
            
                                INSERT INTO apartment_rental(
                                    apartment_rental_user_id,
                                    apartment_rental_apartement_id,
                                    apartment_rental_start,
                                    apartment_rental_end
                                )VALUES(
                                    :user_id,
                                    :apartment_id,
                                    :start_date,
                                    :end_date
                                )
            
                            ");
                            $request->execute([
                                ':user_id' => $user_id,
                                ':apartment_id' => $apartment_id,
                                ':start_date' => $start_date,
                                ':end_date' => $end_date
                            ]);
            
                            $bill = $connexion->prepare("
            
                                INSERT INTO user_invoice(
                                    user_invoice_user_id,
                                    user_invoice_apartment_id,
                                    user_invoice_amount
                                )VALUES(
                                    :user_id,
                                    :apartment_id,
                                    :amount
                                )
            
                            ");
            
                            $bill->execute([
                                ':user_id' => $user_id,
                                ':apartment_id' => $apartment_id,
                                ':amount' => $amount  
                            ]);
            
                            $connexion= null;
            
                            $message = "Votre location a été réserver avec succes";
                            header('Location: http://localhost:3000/pages/location/locationdetails.php?id=' . $apartment_id . '&validate=' . urlencode($message));
    
                            exit;  
                        }else{
                            $message = "Le bien ne peut etre réserver a cette date";
                            header('Location: http://localhost:3000/pages/location/locationdetails.php?id=' . $apartment_id . '&error=' . urlencode($message));
                            exit;  
                        }
                        
                    }
        
                }else{
                    $request = $connexion->prepare("
        
                            INSERT INTO apartment_rental(
                                apartment_rental_user_id,
                                apartment_rental_apartement_id,
                                apartment_rental_start,
                                apartment_rental_end
                            )VALUES(
                                :user_id,
                                :apartment_id,
                                :start_date,
                                :end_date
                            )
        
                        ");
                        $request->execute([
                            ':user_id' => $user_id,
                            ':apartment_id' => $apartment_id,
                            ':start_date' => $start_date,
                            ':end_date' => $end_date
                        ]);
        
                        $bill = $connexion->prepare("
        
                            INSERT INTO user_invoice(
                                user_invoice_user_id,
                                user_invoice_apartment_id,
                                user_invoice_amount
                            )VALUES(
                                :user_id,
                                :apartment_id,
                                :amount
                            )
        
                        ");
        
                        $bill->execute([
                            ':user_id' => $user_id,
                            ':apartment_id' => $apartment_id,
                            ':amount' => $amount  
                        ]);
        
                        $connexion= null;
        
                        $message = "Votre location a été réserver avec succes";
                        header('Location: http://localhost:3000/pages/location/locationdetails.php?id=' . $apartment_id . '&validate=' . urlencode($message));
    
                        exit;  
                }
    
            }else{
                $message = "La date de départ doit etre plus grande ou égale a aujourd'huit et la date de rétour plus grande que la date d'arriver";
                header('Location: http://localhost:3000/pages/location/locationdetails.php?id=' . $apartment_id . '&error=' . urlencode($message));
                exit;
            }
        }else{
            ;
            $message = "Tous les champs son requis";
                header('Location: http://localhost:3000/pages/location/locationdetails.php?id=' . $apartment_id . '&error=' . urlencode($message));
                exit;
        }


    }

    function getOneApartmentRental($rental_id){
        $db = new Database();

        $connexion = $db->getconnection();

        $request = $conexion->prepare("
            SELECT *
            FROM apartment_renal
            JOIN apartment
            ON apartment_rental_apartment_id = apartment_id
            JOIN user
            ON apartment_rental_user_id = user_id
            WHERE rental_id = :rental_id
        ");

        $request->execute([':rental_id' => $rental_id]);

        $apartmentInfos = $request->fetch(PDO::FETCH_ASSOC);

        $connexion= null;

        header('Content-Type: application/json');
        echo json_encode($apartmentInfos);
    }

    function getAllApartmentRental($apartment_id){
        
        $db = new Database();

        $connexion = $db->getconnection();
        
        $request = $connexion->prepare("
            SELECT
            apartment_id,  
            apartment_rental_start,
            apartment_rental_end
            FROM apartment_rental
            JOIN apartment ON apartment_rental.apartment_rental_apartement_id = apartment_id
            WHERE apartment.apartment_id = :apartment_id
            AND apartment_rental_start >= CURDATE()
            ORDER BY apartment_rental_start DESC;
        ");

        $request->execute([':apartment_id' => $apartment_id]);

        $apartmentsRentals = $request->fetchAll(PDO::FETCH_ASSOC);

        $connexion = null;

        header('Content-Type: application/json');
        echo json_encode($apartmentsRentals);

        
    }

    function getApartmentRentalInProgress($user_id){
        $db = new Database();

        $connexion = $db->getconnection();
        
        $request = $connexion->prepare("
            SELECT
            apartment.apartment_id,  
            apartment.apartment_adress,
            apartment.apartment_zip_code,
            apartment.apartment_city
            FROM apartment_rental
            JOIN apartment ON apartment_rental.apartment_rental_apartement_id = apartment_id
            JOIN user ON apartment_rental.apartment_rental_user_id = user.user_id
            WHERE apartment_rental.apartment_rental_user_id = :user_id
            AND CURRENT_DATE BETWEEN apartment_rental.apartment_rental_start AND apartment_rental.apartment_rental_end;
            
        ");

        $request->execute([':user_id' => $user_id]);

        $apartmentsRental = $request->fetch(PDO::FETCH_ASSOC);

        $connexion = null;

        header('Content-Type: application/json');
        echo json_encode($apartmentsRental);

        
    }

    function updateApartmentRental($rental_id){
        
    }

    function deleteApartmentRental($rental_id){
        
    }
}