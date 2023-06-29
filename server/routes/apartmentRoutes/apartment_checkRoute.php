<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/apartmentControllers/apartment_checkController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    // preg_mag est utiliser pour les routes en GET qui on un paramettre dans l'url
    case preg_match('@^/apartment/get/AllApartmentTask/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Apartment_check();
        if ($method == 'GET') {
            $controller->getAllApartmentTask($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
        
    case '/apartment/add/ApartmentTask':
        $controller = new Apartment_check();
        if ($method == 'POST') {
            $controller->addOneApartmentTask();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case '/apartment/update/ApartmentTask':
        $controller = new Apartment_check();
        if ($method == 'POST') {
            $controller->updateOneApartmentTask();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
    
    case preg_match('@^/apartment/delete/ApartmentTask/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Apartment_check();
        if ($method == 'GET') {
            $controller->deleteOneApartmentTask($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
}