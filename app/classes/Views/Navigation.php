<?php


namespace App\Views;

use App\App;
use Core\View;

class Navigation extends \Core\View
{

    public function __construct()
    {
        $this->data = [
            'left' => [
                ['title' => 'Home', 'url' => '/index.php']
            ],
            'right' => [
                'login' => ['title' => 'Login', 'url' => '/login.php'],
                'register' => ['title' => 'Register', 'url' => '/register.php'],
                'orders_table' => ['title' => 'Orders Table', 'url' => '/orders.php'],
                'logout' => ['title' => 'Logout', 'url' => '/logout.php']
            ],
        ];
        if (App::$session->userLoggedIn()) {
            unset($this->data['right']['login']);
            unset($this->data['right']['register']);
        } else {
            unset($this->data['right']['orders_table']);
            unset($this->data['right']['logout']);
        }
    }

    public function render($template_path = ROOT . '\app\templates\navigation.tpl.php')
    {
        return parent::render($template_path);
    }

}