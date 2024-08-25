<?php

namespace Controllers;

use View\View;

class LogoutController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../templates');
    }

    public function view()
    {
        session_start();
        session_destroy();
        header('Location: http://localhost/project/project/www');
        exit();
    }
}
