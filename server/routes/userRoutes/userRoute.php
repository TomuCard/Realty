<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/userControllers/userController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    // preg_mag est utiliser pour les routes en GET qui on un paramettre dans l'url
    case '/user/createAccount':
        $controller = new User();
        if ($method == 'POST') {
            $controller->createAccount();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case '/user/loginAccount':
        $controller = new User();
        if ($method == 'POST') {
            $controller->loginAccount();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case '/user/employee':
            $controller = new User();
            if ($method == 'GET') {
                $controller->getAllUserWhereStatutIsMenage();
                $matched = true;
        } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;

    case preg_match('@^/user/oneUser/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new User();
            if ($method == 'GET') {
                $controller->getOneUser($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;

    case preg_match('~^/user/search/([\w.-]+(?:@[\w.-]+)?)$~', $url, $matches) ? $url : '':
            $param = urldecode($matches[1]);
            $controller = new User();
            if ($method == 'GET') {
                $controller->searchUser($param);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            }
            break;       

    case '/user/updateAccount':
            $controller = new User();
            if ($method == 'POST') {
                $controller->updateAccountForOneUser();
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: POST');
            };
            break;

    case preg_match('@^/user/getAccount/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new User();
            if ($method == 'GET') {
                $controller->getAccountForOneUser($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;
    case '/user/logout':
            $controller = new User();
            if ($method == 'GET') {
                $controller->logoutAccount();
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;        

    case preg_match('@^/user/desactiveAccount/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new User();
            if ($method == 'GET') {
                $controller->desactiveAccountForOneUser($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;

    case preg_match('@^/user/reactiveAccount/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new User();
            if ($method == 'GET') {
                $controller->reactiveAccountForOneUser($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break; 
                   
    case '/user/updateStatus':
            $controller = new User();
            if ($method == 'POST') {
                $controller->updateStatutForOneUser();
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: POST');
            };
            break;

    case preg_match('@^/user/deleteAccount/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new User();
            if ($method == 'GET') {
                $controller->deleteAccountForOneUser($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break; 
                   
    

}