<?php

namespace Controllers;

use Models\Users\User;
use View\View;

class RegisterController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../templates');
    }

    public static function handleRegistration()
    {
        spl_autoload_register(function ($className) {
            $path = str_replace('\\', '/', $className) . '.php';
            require_once $path;
        });

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nickname = $_POST['nickname'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!User::findOne(['nickname' => $nickname])) {
                $user = new User;
                $user->setNickName($nickname);
                $user->setEmail($email);
                $user->setPasswordHash(password_hash($password, PASSWORD_BCRYPT));
                $user->save();
                header('Location: http://localhost/project/project/www/login.php');
                exit();
            } else {
                echo "Nickname already exists. Please choose a different one.";
            }
        }
    }

    public function add()
    {

    }

    public function view(){
        $this->view->renderHtml('register/register.html');
        $this->handleRegistration();
    }
}