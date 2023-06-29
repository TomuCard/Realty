<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/userControllers/user_planningController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    // preg_mag est utiliser pour les routes en GET qui on un paramettre dans l'url
    case '/planning/add/planning':
        $controller = new User_planning();
        if ($method == 'POST') {
            $controller->addUserPlanning();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case '/planning/update/onePlanning':
        $controller = new User_planning();
        if ($method == 'POST') {
            $controller->updateOnePlanning();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

        
    case preg_match('@^/planning/delete/planning/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new User_planning();
        if ($method == 'GET') {
            $controller->deletePlanning($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
    
    case preg_match('@^/user/get/onePlanning/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new User_planning();
        if ($method == 'GET') {
            $controller->getOnePlanningForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
    

    case preg_match('@^/user/get/allPlanning/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new User_planning();
        if ($method == 'GET') {
            $controller->getAllPlanningForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/apartment/get/allPlanning/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new User_planning();
        if ($method == 'GET') {
            $controller->getAllPlanningForOneApartment($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/apartment/get/onePlanning/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new User_planning();
        if ($method == 'GET') {
            $controller->getOnePlanningForOneApartement($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
}