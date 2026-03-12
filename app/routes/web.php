<?php
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$urlParts = explode('/', $url);

$controllerName = !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'ProductController';
$methodName = !empty($urlParts[1]) ? $urlParts[1] : 'index';
$param = $urlParts[2] ?? null;

if ($controllerName == 'Controller') $controllerName = 'ProductController';

$controllerFile = "../app/controllers/" . $controllerName . ".php";
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();
    if (method_exists($controller, $methodName)) {
        $controller->$methodName($param);
    } else {
        die("Method not found");
    }
} else {
    die("Controller not found");
}