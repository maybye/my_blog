<?php

spl_autoload_register(function (string $className) {
    $classPath = '../src/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($classPath)) {
        require_once($classPath);
    }
});

$route = $_GET['route'] ?? '';
$routes = require '../src/routes.php';

$isRouteFound = false;
foreach ($routes as $pattern => $controllerAndAction) {
    preg_match($pattern, $route, $matches);
    if (!empty($matches)) {
        $isRouteFound = true;
        break;
    }
}
if (!$isRouteFound) {
    echo "Страница не найдена";
    return;
}

unset($matches[0]);
$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];

$controller = new $controllerName;
$controller->$actionName(...$matches);
