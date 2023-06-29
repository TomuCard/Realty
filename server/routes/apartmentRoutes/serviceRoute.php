<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/apartmentControllers/serviceController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    // preg_mag est utiliser pour les routes en GET qui on un paramettre dans l'url
    case preg_match('@^/apartment/service/get/allService/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Service();
        if ($method == 'GET') {
            $controller->getAllServiceForOneApartment($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case '/apartment/service/add/service':
        $controller = new Service();
        if ($method == 'POST') {
            $controller->addOneServiceForOneApartment();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case '/apartment/service/update/oneService':
            $controller = new Service();
            if ($method == 'POST') {
                $controller->updateOneService();
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: POST');
            };
            break;

    case preg_match('@^/apartment/service/delete/oneService/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new Service();
            if ($method == 'GET') {
                $controller->deleteOneService($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;
}