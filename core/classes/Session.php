<?php


namespace Core;


use App\Users\Model;
use App\Users\User;

class Session
{

    private $model;
    private $user;

    public function __construct()
    {
        $this->model = new \App\Users\Model();
        $this->loginFromCookies();
    }

    public function loginFromCookies()
    {
        if (!empty($_SESSION)) {
            $this->login($_SESSION['email'], $_SESSION['password']);

        }
        return false;
    }

    public function login($email, $password)
    {
        $users = $this->model->get(
            [
                'email' => $email,
                'password' => $password,
            ]
        );

        if (!empty($users)) {
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;

            $this->user = $users[0];

            return true;
        }

        return false;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function userLoggedIn()
    {
        if ($this->user) {
            return true;
        }
        return false;
    }

    public function logout($redirect = false)
    {
        $_SESSION = [];

        setcookie(session_name(), null, time() - 1, '/');

        session_destroy();

        if ($redirect) {
            header('Location: ' . $redirect);
        }
    }
}
