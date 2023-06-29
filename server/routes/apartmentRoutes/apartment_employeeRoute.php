<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/apartmentControllers/apartment_employeeController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    // preg_mag est utiliser pour les routes en GET qui on un paramettre dans l'url
    case preg_match('@^/user/get/apartmentEmployee/(\d+)/([\w-]+)$@', $url, $matches) ? $url : '':
        $controller = new Apartment_employee();
        if ($method == 'GET') {
            $controller->getAllApartmentForOneEmployee($matches[1], $matches[2]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
        
    case '/user/add/employee':
        $controller = new Apartment_employee();
        if ($method == 'POST') {
            $controller->addEmployeeForOneApartment();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case '/user/update/employee':
        $controller = new Apartment_employee();
        if ($method == 'POST') {
            $controller->updateEmployeeForOneApartment();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
    
    case preg_match('@^/user/delete/employee/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Apartment_employee();
        if ($method == 'GET') {
            $controller->deleteEmployeeForOneApartment($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
}