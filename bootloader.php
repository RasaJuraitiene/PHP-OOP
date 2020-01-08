<?php
session_start();

define('DB_FILE' , 'data/db.txt');
define('ROOT', __DIR__);

require('functions/form/core.php');
require('functions/html.php');
require('functions/file.php');
require ('functions/auth.php');