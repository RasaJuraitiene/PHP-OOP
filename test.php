<?php
//set current sesion ID
$user_id = $_COOKIE['user_id'] ?? uniqid();
$visits = ($_COOKIE['visits'] ?? 0) + 1;

setCookie('user_id', $user_id, time() + 3600, "/");
setCookie('visits', $visits, time() + 3600, "/");

session_start();
​
$_SESSION['visits'] = ($_SESSION['visits'] ?? 0) + 1;
​
$h1 = session_id();
$h2 = $_SESSION['visits'];

//if (empty($_COOKIE['user_id'])) {
//    $user_id = rand(1, 100000);
//    $h1 = $user_id;
//    setCookie('user_id', $user_id, time() + 3600, "/");
//} else {
//    $h1 = $_COOKIE['user_id'];
//}
//
//if (!isset($_COOKIE['count'])) {
//    $h2 = 1;
//    setcookie('count', $h2, time() + 3600, "/");
//} else {
//    $h2 = ++$_COOKIE['count'];
//    setcookie('count', $h2, time() + 3600, "/");
//}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1><?php print $user_id; ?></h1>
<h2><?php print $visits; ?></h2>
</body>
</html>

