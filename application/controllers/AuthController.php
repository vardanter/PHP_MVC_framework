<?php

namespace application\controllers;

use application\models\Users;
use engine\classes\Controller;
use engine\Debug;

class AuthController extends Controller
{
    public function index()
    {
        $user = new Users();
        $user->email = 'testmail.ru';

        if (isset($_POST['signup'])) {
            $userData = $_POST['User'];
            if ($_FILES['User']) {
                $user->avatar = $_FILES['User'];
            }
            $user->email = $userData['email'];
            $user->phone = $userData['phone'];
            $user->password = $userData['password'];
            $user->confirm_password = $userData['confirm_password'];
            $user->agreement = isset($userData['agreement']) ? !!$userData['agreement'] : null;
            if ($user->create()) {
                $_SESSION['auth'] = true;
                $_SESSION['user'] = $user->id;
                header("Location: /profile");
                die('red');
            }
        }

        $this->render('index', [
            'model' => $user,
            'errors' => $user->getErrors()
        ]);
    }
    
    public function profile()
    {
        if (!$_SESSION['auth'] || !$_SESSION['user']) {
            header("Location: /");
        }
        $model = new Users();
        $user = $model->find('*', 'id=:id', [':id' => ['value' => $_SESSION['user'], 'type' => \PDO::PARAM_INT]])->one();

        $this->render('profile', [
            'user' => $user
        ]);
    }

    public function logout()
    {
        unset($_SESSION['auth']);
        unset($_SESSION['user']);
        header("Location: /");
    }
}