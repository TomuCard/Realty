<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/userControllers/employee_reportController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    // preg_mag est utiliser pour les routes en GET qui on un paramettre dans l'url
    case preg_match('@^/user/employee/get/allMessage/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new Employee_report();
        if ($method == 'GET') {
            $controller->getAllMessageReport($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case '/user/employee/add/message':
        $controller = new Employee_report();
        if ($method == 'POST') {
            $controller->addMessageReport();
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case '/user/employee/update/message':
            $controller = new Employee_report();
            if ($method == 'POST') {
                $controller->updateMessageReport();
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: POST');
            };
            break;

    case preg_match('@^/user/employee/delete/message/(\d+)$@', $url, $matches) ? $url : '':
            $controller = new Employee_report();
            if ($method == 'GET') {
                $controller->deleteMessageReport($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;
}