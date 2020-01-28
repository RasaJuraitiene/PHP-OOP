<?php


namespace App\Users;


use App\DataHolder;

class User extends DataHolder
{
    protected $properties = [
        'username', 'email', 'password'
    ];

    public function setUsername(string $username)
    {
        $this->data['username'] = $username;
    }

    public function getUsername()
    {
        return $this->data['username'] ?? null;
    }

    public function setEmail(string $email)
    {
        $this->data['email'] = $email;
    }

    public function getEmail()
    {
        return $this->data['email'];
    }

    public function setPassword(string $password)
    {
        $this->data['password'] = $password;
    }

    public function getPassword()
    {
        return $this->data['password'];
    }
}