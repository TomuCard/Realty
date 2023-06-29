<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/apartmentControllers/apartment_serviceController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    // preg_mag est utiliser pour les routes en GET qui on un paramettre dans l'url
    case preg_match('@^/apartment/get/AllApartmentService/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Apartment_service();
        if ($method == 'GET') {
            $controller->getAllApartmentService($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case '/apartment/add/ApartmentService':
        $controller = new Apartment_service();
        if ($method == 'POST') {
            $controller->addApartmentService();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
    
    case '/apartment/update/oneApartmentService':
        $controller = new Apartment_service();
        if ($method == 'POST') {
            $controller->updateOneApartmentService();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/apartment/delete/oneApartmentService/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new Apartment_service();
            if ($method == 'GET') {
                $controller->deleteOneApartmentService($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;
}