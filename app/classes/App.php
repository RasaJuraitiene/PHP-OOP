<?php


namespace App;


use Core\FileDB;

class App
{
    public static $db;
    public static $session;

    public function __construct()
    {
        session_start();
        self::$db = new \Core\FileDB(DB_FILE);
        self::$session = new \Core\Session();
    }

}