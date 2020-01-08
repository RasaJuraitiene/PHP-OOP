<?php

require('bootloader.php');

if(isset($_SESSION['username'])){
    header('Location: /index.php');
}

$form = [
    'callbacks' => [
        'success' => 'form_success',
        'fail' => 'form_fail',
    ],
    'attr' => [
//        'method' => 'POST', defaultu postas yra
        'class' => 'my-form',
        'id' => 'login-form',
    ],
    'validators' => [
        'validate_login'
    ],
    'fields' => [
        'username' => [
            'label' => 'Username',
            'type' => 'text',
            'extra' => [
                'attr' => [
                    'class' => 'username',
                    'placeholder' => 'Enter Username'
                ],
            ],
            'validators' => [
                'validate_not_empty',
            ],
        ],
        'password' => [
            'label' => 'Password',
            'type' => 'password',
            'extra' => [
                'attr' => [
                    'class' => 'password',
                    'placeholder' => 'Enter password'
                ],
            ],
            'validators' => [],
        ],
    ],
    'buttons' => [
        'send' => [
            'title' => 'Login',
            'extra' => [
                'attr' => [
                    'class' => 'send-btn',
                ],
            ],
        ],
    ],
    'message' => 'Registracija sėkminga!',
];

function validate_login($inputs, &$fields)
{
    $array = file_to_array(DB_FILE);

    foreach ($array as $key => $value) {

        if ($value['username'] === $inputs['username'] && $value['password'] === $inputs['password']) {
            return true;
        }
    }
    $fields['username']['error'] = 'Neteisingai įvesti duomenys!';
    $fields['password']['error'] = 'Neteisingai įvesti duomenys!';
    return false;
}


/**
 * F-ija, kurią iškviečia validate_form
 * jeigu forma buvo gerai užpildyta
 *
 * @param $form
 * @param $inputs
 */
function form_success(&$form, $inputs)
{
    $_SESSION['username'] = $inputs['username'];
    $_SESSION['password'] = $inputs['password'];

    header('Location: /index.php');
//    $form['message'] = 'User logged in!';

    $array = file_to_array(DB_FILE);
    $array[] = $inputs;
    array_to_file($array, DB_FILE);

    $_COOKIE['user_id'] = $_COOKIE['user_id'] ?? uniqid();
    setcookie('user_id', $_COOKIE['user_id'], time() + 3600, '/');
}

/**
 * F-ija, kurią iškviečia validate_form
 * jeigu forma buvo hujovai užpildyta
 *
 * @param $form
 * @param $input
 */
function form_fail(&$form, $input)
{
    var_dump('Failas');
}


if (!empty($_POST)) {
    $inputs = get_form_input($form);
    $success = validate_form($form, $inputs);
} else {
    $success = false;
}


$show_form = !$success;
/* trumpinys
if (isset($_COOKIE['user_id'])) {
    // Jeigu forma jau buvo submittinta sito userio
    $show_form = false;
} else {
    $show_form = true;
}
*/

$h1 = 'Sėkmingai prisijungėte!';

?>

<!doctype html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="register_form">
    <?php if ($show_form): ?>
        <?php require('templates/form.tpl.php'); ?>
    <?php else: ?>
        <h1><?php print $h1; ?></h1>
    <?php endif; ?>
</div>
</body>
</html>