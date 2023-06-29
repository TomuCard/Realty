<?php
require_once './debug.php';
// inclure les controllers nécessaires
require_once './controllers/userControllers/user_invoiceController.php';

// Obtenir le chemin de l'URL demandée
$url = $_SERVER['REQUEST_URI'];

// Obtenir la méthode HTTP actuelle
$method = $_SERVER['REQUEST_METHOD'];

$matched = false;

switch ($url) {
    // Route utilisateur de l'API
    // preg_mag est utiliser pour les routes en GET qui on un paramettre dans l'url
    case preg_match('@^/user/get/oneUserInvoice/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new User_invoice();
        if ($method == 'POST') {
            $controller->getOneUser_invoiceForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: POST');
        };
        break;

    case preg_match('@^/user/get/AllUserInvoice/(\d+)$@', $url, $matches) ? $url : '':
        $controller = new User_invoice();
        if ($method == 'GET') {
            $controller->getAllUser_invoiceForOneUser($matches[1]);
            $matched = true;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET');
        };
        break;

    case preg_match('@^/user/get/allUserInvoiceAmount(\d+)$@', $url, $matches) ? $url : '':
            $controller = new User_invoice();
            if ($method == 'GET') {
                $controller->getAllUser_invoiceAmountForDashboard($matches[1]);
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: GET');
            };
            break;

    case '/user/create/oneuserInvoice':
            $controller = new User_invoice();
            if ($method == 'POST') {
                $controller->createOneUser_invoice();
                $matched = true;
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                header('Allow: POST');
            };
            break;       
}