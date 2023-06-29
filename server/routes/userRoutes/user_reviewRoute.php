<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/userControllers/user_reviewController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    // preg_mag est utiliser pour les routes en GET qui on un paramettre dans l'url
    case preg_match('@^/user/get/allComment/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new User_review();
        if ($method == 'GET') {
            $controller->getAllCommentForOneApartment($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case '/user/update/oneComment':
        $controller = new User_review();
        if ($method == 'POST') {
            $controller->updateOneComment();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/user/delete/oneComment/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new User_review();
            if ($method == 'GET') {
                $controller->deleteOneComment($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;

    case '/user/add/comment':
            $controller = new User_review();
            if ($method == 'POST') {
                $controller->addCommentForOneApartment();
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: POST');
            };
            break;       
}