<?php

define('ROOT', __DIR__);
require('bootloader.php');

/**
 * F-ija, kurią iškviečia validate_form
 * jeigu forma buvo gerai užpildyta
 *
 * @param $form
 * @param $inputs
 */
function form_success($form, $inputs)
{
    // Tam, kad neisirasytu sitas field i faila
    unset($inputs['password_repeat']);

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
        'validate_form_match' => [
            'password',
            'password_repeat',
        ]
    ],
    'fields' => [
        'username' => [
            'label' => 'Username',
            'type' => 'text',
            'extra' => [
                'attr' => [
                    'class' => 'username',
                    'placeholder' => 'username'
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
                    'placeholder' => 'password'
                ],
            ],
            'validators' => [
                'validate_not_empty',
                'validate_chars_length' => [
                    'min' => 6,
                ],
            ],
        ],
        'password_repeat' => [
            'label' => 'Repeat password',
            'type' => 'password',
            'extra' => [
                'attr' => [
                    'class' => 'password-repeat',
                    'placeholder' => 'repeat password'
                ],
            ],
            'validators' => [
                'validate_not_empty',
            ],
        ],
    ],
    'buttons' => [
        'send' => [
            'title' => 'Siusti',
            'extra' => [
                'attr' => [
                    'class' => 'send-btn',
                ],
            ],
        ],
    ],
    //'message' => 'Zinute nuo formos',
];

if (!empty($_POST)) {
    $inputs = get_form_input($form);
    $success = validate_form($form, $inputs);
} else {
    $success = false;
}

$show_form = isset($_COOKIE['user_id']) ? false : true;
/* trumpinys
if (isset($_COOKIE['user_id'])) {
    // Jeigu forma jau buvo submittinta sito userio
    $show_form = false;
} else {
    $show_form = true;
}
*/

$h1 = $success ? 'Viskas OK' : 'Viskas xujne';
$table = !$show_form ? prepare_table(file_to_array(DB_FILE)) : null;

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form</title>
    <style>
        table, th, td {
            border: 2px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<?php if ($show_form): ?>
    <h1><?php print $h1; ?></h1>
    <?php require('templates/form.tpl.php'); ?>
<?php else: ?>
    <?php require('templates/table.tpl.php'); ?>
<?php endif; ?>
</body>
</html>
