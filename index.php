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
    $array = file_to_array(DB_FILE);
    unset($inputs['password_repeat']);
    $array[] = $inputs;
    array_to_file($array, DB_FILE);
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
    $status = validate_form($form, $inputs);
} else {
    $status = false;
}

$h1 = $status ? 'Viskas OK' : 'Viskas hujne';

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form</title>
</head>
<body>
<h1><?php print $h1; ?></h1>
<?php require('templates/form.tpl.php'); ?>
</body>
</html>
