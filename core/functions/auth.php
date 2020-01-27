<?php
//
//function is_logged_in()
//{
//    if (!empty($_SESSION)) {
//        $model = new \App\Users\Model();
//        $users = $model->get([
//            'email' => $_SESSION['email'],
//            'password' => $_SESSION['password']
//        ]);
//
//        if (!empty($users)) return true;
//    }
//
//    return false;
//}
//
//function loggout($redirect = false)
//{
//    $_SESSION = [];
//
//    setcookie(session_name(), null, time() - 1, '/');
//
//    session_destroy();
//
//    if ($redirect) {
//        header('Location: /login.php');
//    }
//}