<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/apartmentControllers/apartmentController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    // preg_mag est utiliser pour les routes en GET qui on un paramettre dans l'url
    case '/apartment/add/apartment':
        $controller = new Apartment();
        if ($method == 'POST') {
            $controller->addApartment();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case '/apartment/update/apartment/':
        $controller = new Apartment();
        if ($method == 'POST') {
            $controller->updateApartment();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;
    
    case preg_match('@^/apartment/get/oneApartment/(\d+)$@', $url, $matches) ? $url : '':
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: GET, POST");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Credentials: true");
        $controller = new Apartment();
        if ($method == 'GET') {
            $controller->getOneApartment($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/get/image/(\d+)$@', $url, $matches) ? $url : '':
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST");
        header("Access-Control-Allow-Headers: Content-Type");
        $controller = new Apartment();
        if ($method == 'GET') {
            $controller->getOneImageOfOneApartment($matches[1]);
            $matched = true;
        } else{
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };

        break;

    case preg_match('@^/images/(.*)$@', $url, $matches) ? $url : '':
            header("Access-Control-Allow-Origin: http://localhost:3000");
            header("Access-Control-Allow-Methods: GET, POST");
            header("Access-Control-Allow-Headers: Content-Type");
            header("Access-Control-Allow-Credentials: true");

            // /image/pano1.jpg
            // $matches[1] = pano1.jpg
            // chemin ver l'image : /img/pano1.jpg
            $chemin = './img/' . str_replace('-', '.', $matches[1]);
            if(file_exists($chemin))
            {
                $matched = true;
                header('Content-Type: image/jpg');
                readfile($chemin);
            }
            break;

    case '/apartment/get/allApartment':
            $controller = new Apartment();
            if ($method == 'GET') {
                $controller->getAllApartment();
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;

    case preg_match('@^/apartment/delete/apartment/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Apartment();
        if ($method == 'GET') {
            $controller->deleteApartment($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;
        case preg_match('@^/apartment/search(?:/(\d{5}))?(?:/(\d{4}-\d{2}-\d{2}))?(?:/(\d{4}-\d{2}-\d{2}))?$@', $url, $matches) ? $url : '':
            $controller = new Apartment();
            if ($method == 'GET') {
                $zipCode = isset($matches[1]) ? $matches[1] : null;
                $startDate = isset($matches[2]) ? $matches[2] : null;
                $endDate = isset($matches[3]) ? $matches[3] : null;
                $controller->searchApartment($zipCode, $startDate, $endDate);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            }
            break;

    case preg_match('@^/apartment/logistic/get/oneApartment/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new Apartment();
            if ($method == 'GET') {
                $controller->logisticGetOneApartment($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;
}