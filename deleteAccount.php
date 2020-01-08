<?php

require('bootloader.php');

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
        'buttons' => [
            'send' => [
                'title' => 'Delete',
                'extra' => [
                    'attr' => [
                        'class' => 'send-btn',
                    ],
                ],
            ],
        ],
    ]
];


function form_success(&$form, $inputs)
{
    loggout();
//    $array = file_to_array(DB_FILE);
//    $array[] = $inputs;
//    array_to_file($array, DB_FILE);
//
//    $_COOKIE['user_id'] = $_COOKIE['user_id'] ?? uniqid();
//    setcookie('user_id', $_COOKIE['user_id'], time() + 3600, '/');
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

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete Account</title>
</head>
<body>
<?php require('templates/form.tpl.php'); ?>
</body>
</html>
