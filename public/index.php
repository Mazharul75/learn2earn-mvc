<?php
// Start session for entire application
session_start();

// Load configuration
require_once '../config/config.php';

// Load core MVC files
require_once '../core/Database.php';
require_once '../core/Controller.php';
require_once '../core/Model.php';

// Default controller and method
$controller = 'HomeController';
$method = 'index';
$params = [];

// Get URL if exists
if (isset($_GET['url'])) {
    $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    
    if (!empty($url[0])) {
        $controller = ucfirst($url[0]) . 'Controller';
        unset($url[0]);
    }

    if (isset($url[1])) {
        $method = $url[1];
        unset($url[1]);
    }

    $params = array_values($url);
}

// Controller file path
$controllerFile = '../app/controllers/' . $controller . '.php';

// Check controller existence
if (!file_exists($controllerFile)) {
    die('Controller not found');
}

require_once $controllerFile;

// Create controller instance
$controllerObject = new $controller();

// Check method
if (!method_exists($controllerObject, $method)) {
    die('Method not found');
}

// Call controller method
call_user_func_array([$controllerObject, $method], $params);
