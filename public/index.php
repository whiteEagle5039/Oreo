<?php

// require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/AutoView.php';
require_once __DIR__ . '/../app/Controllers/AutoViewController.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';

use App\Core\Router;

// Récupérer le chemin depuis .htaccess

$path = $_GET['path'] ?? 'home';

// Dispatcher vers le bon contrôleur
Router::dispatch($path);
