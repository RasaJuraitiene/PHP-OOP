<?php

use Core\FileDB;
use App\Views\Form;
use App\Views;
use App\Users\User;

require('../bootloader.php');

$form = [
    'callbacks' => [
        'success' => 'form_success',
        'fail' => 'form_fail',
    ],
    'attr' => [
//        'method' => 'POST', defaultu postas yra
        'class' => 'my-form',
        'id' => 'register-form',
    ],
    'validators' => [
        'validate_fields_match' => [
            'password',
            'password_repeat',
        ]
    ],
    'fields' => [
        'username' => [
            'label' => 'Username',
            'type' => 'text',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                ],
                'attr' => [
                    'class' => 'username',
                    'placeholder' => 'Enter Username'
                ],
            ],
        ],
        'email' => [
            'label' => 'Email',
            'type' => 'email',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                    'validate_email_is_unique'
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
                    'validate_chars_length' => [
                        'min' => 6,
                    ],
                ],
                'attr' => [
                    'class' => 'password',
                    'placeholder' => 'Enter password'
                ],
            ],
        ],
        'password_repeat' => [
            'label' => 'Repeat password',
            'type' => 'password',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                ],
                'attr' => [
                    'class' => 'password-repeat',
                    'placeholder' => 'Repeat password'
                ],
            ],
        ],
    ],
    'buttons' => [
        'send' => [
            'title' => 'Register',
            'extra' => [
                'attr' => [
                    'class' => 'send-btn',
                ],
            ],
        ],
    ],
    'message' => 'Registracija sėkminga!',
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
    $modelUsers = new \App\Users\Model();
    $userADD = new App\Users\User([
//        'id' => $inputs['id'],
        'username' => $inputs['username'],
        'email' => $inputs['email'],
        'password' => $inputs['password']
    ]);

    $modelUsers->insert($userADD);
}

//$newUser = new \App\Users\User([
//    'id' => '444',
//    'username' => 'kiaune',
//    'email' => 'kiaune@gmail.com',
//    'password' => 'rukas'
//]);

$modelUsers = new \App\Users\Model();

//$modelUsers->insert($newUser);

$usersArray = $modelUsers->get([]);

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


//$show_form = isset($_COOKIE['user_id']) ? false : true;
/* trumpinys
if (isset($_COOKIE['user_id'])) {
    // Jeigu forma jau buvo submittinta sito userio
    $show_form = false;
} else {
    $show_form = true;
}
*/
$show_form = !$success;
$h1 = 'Registracija sėkminga!';
//$table = !$show_form ? prepare_table(file_to_array(DB_FILE)) : null;
$formView = new \App\Views\Form($form);
$navigationView = new \App\Views\Navigation();
?>

<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="media/css/normalize.css">
    <link rel="stylesheet" href="media/css/milligram.min.css">
    <link rel="stylesheet" href="media/css/style.css">
    <title>Register</title>
</head>
<body>
<div class="nav_bar">
    <?php print $navigationView->render(); ?>
</div>
<div class="register_form">
    <?php if ($show_form): ?>
        <?php print $formView->render(); ?>
    <?php else: ?>
        <h1><?php print $h1; ?></h1>
        <!--        --><?php //require('templates/table.tpl.php'); ?>
    <?php endif; ?>
</div>
</body>
</html>

