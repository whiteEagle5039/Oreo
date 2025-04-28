<?php
namespace App\Controllers;

use App\Core\AutoView;

class AutoViewController
{
    private $autoView;

    public function __construct()
    {
        $this->autoView = new AutoView();
    }

    public function handle($view)
    {
        if ($this->autoView->viewExists($view)) {
            $this->autoView->handleForm($view);
            $this->autoView->renderForm($view);
        } else {
            echo "<h1>404 - Vue '$view' non trouvée</h1>";
        }
    }
}
