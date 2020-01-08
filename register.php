<?php

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

function validate_username($field_input, &$field)
{
    $array = file_to_array(DB_FILE);

    foreach ($array as $record) {
        if ($record['username'] === $field_input) {
            $field['error'] = 'Toks vartotojas jau egzistuoja!';
            return false;
        }

    }
    return true;
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
                    'placeholder' => 'Enter Username'
                ],
            ],
            'validators' => [
                'validate_not_empty',
                'validate_username'
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
                    'placeholder' => 'Repeat password'
                ],
            ],
            'validators' => [
                'validate_not_empty',
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

$h1 = 'Registracija sėkminga!';
$table = !$show_form ? prepare_table(file_to_array(DB_FILE)) : null;

?>

<!doctype html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="register_form">
    <?php if ($show_form): ?>
        <?php require('templates/form.tpl.php'); ?>
    <?php else: ?>
        <h1><?php print $h1; ?></h1>
        <!--        --><?php //require('templates/table.tpl.php'); ?>
    <?php endif; ?>
</div>
</body>
</html>
