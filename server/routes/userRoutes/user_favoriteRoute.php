<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/userControllers/user_favoriteController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    // preg_mag est utiliser pour les routes en GET qui on un paramettre dans l'url
    case '/user/createFavorite':
        $controller = new User_favorite();
        if ($method == 'POST') {
            $controller->createFavoriteforOneUser();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case '/user/updateFavorite':
        $controller = new User_favorite();
        if ($method == 'POST') {
            $controller->updateFavoriteforOneUser();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/user/delete/oneFavorite/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new User_favorite();
            if ($method == 'GET') {
                $controller->deleteFavoriteforOneUser($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;

    case preg_match('@^/user/get/oneFavorite/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new User_favorite();
            if ($method == 'GET') {
                $controller->getOneFavoriteForOneUser($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;
    case preg_match('@^/user/get/allFavorite/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new User_favorite();
            if ($method == 'GET') {
                $controller->getAllFavoriteForOneUser($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;        
}