<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/apartmentControllers/apartment_rentalController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    // preg_mag est utiliser pour les routes en GET qui on un paramettre dans l'url
    case '/apartment/add/apartmentRental':
        $controller = new Apartment_rental();
        if ($method == 'POST') {
            $controller->addApartmentRental();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
        
    case preg_match('@^/apartment/get/oneApartmentRental/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Apartment_rental();
        if ($method == 'GET') {
            $controller->getOneApartmentRental($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/apartment/get/allApartmentRental/(\d+)$@', $url, $matches) ? $url : '':
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: GET, POST");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Credentials: true");
        $controller = new Apartment_rental();
        if ($method == 'GET') {
            $controller->getAllApartmentRental($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/apartment/get/rentalInProgress/(\d+)$@', $url, $matches) ? $url : '':

        $controller = new Apartment_rental();
        if ($method == 'GET') {
            $controller->getApartmentRentalInProgress($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
    
    case '/apartment/update/apartmentRental/':
        $controller = new Apartment_rental();
        if ($method == 'POST') {
            $controller->updateApartmentRental();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/delete/apartmentRental/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new Apartment_rental();
            if ($method == 'GET') {
                $controller->deleteApartmentRental($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;
}