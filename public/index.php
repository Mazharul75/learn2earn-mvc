<?php
// Load Config
require_once '../config/config.php';

// Load Core Classes
require_once '../core/Controller.php';
require_once '../core/Model.php';
require_once '../core/Database.php';

// Autoload Controllers
spl_autoload_register(function ($className) {
    if (file_exists('../app/controllers/' . $className . '.php')) {
        require_once '../app/controllers/' . $className . '.php';
    }
});

// Get URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Default Controller & Method
$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'AuthController';
$methodName = $url[1] ?? 'login';
$params = array_slice($url, 2);

// Check Controller
if (!file_exists('../app/controllers/' . $controllerName . '.php')) {
    die('Controller not found');
}

$controller = new $controllerName();

// Check Method
if (!method_exists($controller, $methodName)) {
    die('Method not found');
}

// Call Controller Method with Parameters
call_user_func_array([$controller, $methodName], $params);
