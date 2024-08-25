<?php

namespace Controllers;

use Models\Users\User;
use View\View;

class LoginController
{
    private $view;
    private $active;
    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../templates');
        // $this->active=new ActiveRecordEntity(__DIR__ .'/../Models/Users/ActiveRecordEntity');
    }

    public function view()
    {
        $this->view->renderHtml('login/login.html');
        $this->processLogin();
    }

    public function processLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nickname = $_POST['nickname'];
            $password = $_POST['password'];

            $user = User::findOne(['nickname' => $nickname]);
            print_r($password);
            print_r($nickname);

            if ($user && password_verify($password, $user->getPasswordHash())) {
                // Устанавливаем идентификатор пользователя в сессии
                session_start();
                $_SESSION['user_id'] = $user->getId();

                $_SESSION['nickname'] = $nickname;
                $_SESSION['email'] = $user->getEmail();
                // $this->active->__setId($user->getId());
                header('Location: http://localhost/project/project/www/about-me.php');
                exit;
            } else {
                $this->displayErrorMessage();
            }
        }
    }

    private function displayErrorMessage()
    {
        echo "Invalid nickname or password.";
    }
}
