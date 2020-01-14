<?php

use Core\FileDB;

require '../bootloader.php';
require '../core/classes/FileDB.php';
require '../core/classes/User.php';
require '../app/classes/Drinks/Drink.php';


$user = New \Core\User();

//$sandwich =
//    [
//        'price' => 2,
//        'size' => 'xl'
//    ];
//$table_name = 'sumustiniai';
//$file_db = New \Core\FileDB('../app/data/db.txt');
//$file_db ->createTable($table_name);
//$file_db->insertRow($table_name, $sandwich);
//$file_db ->save();

$users = [
    [
        'username' => 'Alius',
        'password' => 'meskutis'
    ],
    [
        'username' => 'Tadas',
        'password' => 'vilkas'
    ]
];
//$table_name = 'Users';
//$file_db = New \Core\FileDB('../app/data/db.txt');
//$file_db->createTable($table_name);
//$file_db->insertRow($table_name, $users[0]);
//$file_db->insertRow($table_name, $users[1]);
//$file_db->save();
////var_dump($users);
//$conditions = '?';
//$file_db->getRowsWhere($table_name, ['username' => 'Alius',
//    'password' => 'meskutis'],
//    ['username' => 'tadas',
//        'password' => 'k']);

$modelDrinks = new \App\Drinks\Model();

$drink = New \App\Drinks\Drink([
    'name' => 'Vodka',
    'amount' => '40',
    'abarot' => '0.7',
    'image' => 'www.delfi.lt',
    'id' => '656'

]);

$modelDrinks->insert($drink);
var_dump($modelDrinks);

//$table_name = 'Drinks';
//$tableDB = New FileDB('../app/data/db.txt');
//$tableDB->load();
//$tableDB->createTable($table_name);
////var_dump($tableDB);
//$tableDB->insertRow($table_name, $drink->getData());
////var_dump($tableDB);
//$tableDB->save();

//var_dump($tableDB);

//$test = New \App\Drinks\Drink();
//$test->setdata($drinksArray);
//var_dump($test->getData());


?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="media/css/normalize.css">
    <link rel="stylesheet" href="media/css/milligram.min.css">
    <link rel="stylesheet" href="media/css/style.css">
    <title>OOP</title>
</head>
<body>
<h1>Darome HIP, darome OOP</h1>
</body>
</html>
