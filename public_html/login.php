<?php

require('../bootloader.php');

use Core\FileDB;
use App\Views\Form;
use App\Views;
use App\Users\User;
use Core\Session;

if (isset($_SESSION['email'])) {
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
        'email' => [
            'label' => 'Email',
            'type' => 'email',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                ],
                'attr' => [
                    'class' => 'email',
                    'placeholder' => 'Enter Email'
                ],
            ],
        ],
        'password' => [
            'label' => 'Password',
            'type' => 'password',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                ],
                'attr' => [
                    'class' => 'password',
                    'placeholder' => 'Enter password'
                ],
            ],
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
    'message' => 'Prisijungimas sėkmingas!',
];


/**
 * F-ija, kurią iškviečia validate_form
 * jeigu forma buvo gerai užpildyta
 *
 * @param $form
 * @param $inputs
 */
function form_success($inputs, &$form)
{
    header('Location: /index.php');
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

//$h1 = 'Sėkmingai prisijungėte!';
$formView = new \App\Views\Form($form);
$navigationView = new \App\Views\Navigation();

?>

<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="media/css/normalize.css">
    <link rel="stylesheet" href="media/css/milligram.min.css">
    <link rel="stylesheet" href="media/css/style.css">
    <title>Login</title>
</head>
<body>
<div class="nav_bar">
    <?php print $navigationView->render(); ?>
</div>
<div class="login_form">
    <?php if ($show_form): ?>
        <?php print $formView->render(); ?>
    <?php endif; ?>
</div>
</body>
</html>
