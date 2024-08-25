<?php

namespace Controllers;

use View\View;
use Models\Users\User;

class AboutMeController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../templates');
    }

    public function view()
    {
        session_start();

        if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['nickname'])) {
            $user = User::getByNickName($_SESSION['nickname']);

            if ($user) {
                $this->view->renderHtml('about-me/about-me.php', ['user' => $user]);
            } else {
                echo "Error: User data not available.";
            }
        } else {
            header('Location: http://localhost/project/project/www/login.php');
            exit();
        }
    }
}
