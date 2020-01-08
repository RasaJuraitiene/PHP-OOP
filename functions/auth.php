<?php

function is_logged_in()
{
    if (!empty($_SESSION)) {

        $array = file_to_array(DB_FILE);

        foreach ($array as $key => $value) {

            if ($value['username'] === $_SESSION['username'] && $value['password'] === $_SESSION['password']) {
                return true;
            }
        }

    }
    return false;
}

function loggout($redirect = false)
{
    $_SESSION =[];

    setcookie(session_name(), null, time() -1, '/');

    session_destroy();

    if ($redirect){
        header('Location: /login.php');
    }
}

function delete_account($redirect = false){
    if (!empty($_SESSION)) {

        $array = file_to_array(DB_FILE);

        foreach ($array as $key => $value) {

            if ($value['username'] === $_SESSION['username'] && $value['password'] === $_SESSION['password']) {
                $_SESSION =[];

                setcookie(session_name(), null, time() -1, '/');

                session_destroy();

                if ($redirect){
                    header('Location: /register.php');
                }
                return true;
            }
        }

    }
    return false;
}