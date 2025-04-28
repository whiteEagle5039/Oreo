<?php

namespace App\Core;

use App\Controllers\AutoViewController;
use App\Controllers\HomeController;

class Router
{
    public static function dispatch($path)
    {
        $path = trim($path, '/');

        if ($path === '' || $path === 'home') {
            $controller = new HomeController();
            $controller->index();
            return;
        }

        // Gérer les vues automatiques prédéfinies
        $standardViews = ['login', 'signin', 'forgot-password', 'reset-password'];

        if (in_array($path, $standardViews)) {
            $controller = new AutoViewController();
            $controller->handle($path);
            return;
        }

        // Ici tu pourras ajouter plus tard des routes custom
        // Ex: /produit, /user, /profile etc.

        // Sinon 404
        self::abort404();
    }

    public static function abort404()
    {
        http_response_code(404);
        echo "<h1>404 - Page non trouvée</h1>";
    }
}
