<?php

use App\Views\Form;

require '../bootloader.php';

if ($user = \App\App::$session->getUser()) {
    $show_form = true;
} else {
    $show_form = false;
}

$form_update = [
    'callbacks' => [
        'success' => 'form_success_update',
        'fail' => 'form_fail',
    ],
    'attr' => [
        //'method' => 'POST', //defaultu postas yra
        'class' => 'my-form',
        'id' => 'login-form',
    ],
    'fields' => [
        'id' => [
            'label' => '',
            'type' => 'hidden',
            'value' => $_GET['id'],
        ],
        'name' => [
            'label' => '',
            'type' => 'text',
            'value' => 'dhszfvszb',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                ],
                'attr' => [
                    'class' => 'name',
                    'placeholder' => 'Drink Name'
                ],
            ],
        ],
        'amount' => [
            'label' => '',
            'type' => 'number',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                ],
                'attr' => [
                    'class' => 'amount',
                    'placeholder' => 'Amount (ml)'
                ],
            ],
        ],
        'abarot' => [
            'label' => '',
            'type' => 'number',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                ],
                'attr' => [
                    'class' => 'abarot',
                    'placeholder' => 'Abarot (%)',
                    'step' => '0.01'
                ],
            ],
        ],
        'price' => [
            'label' => 'Price(Eur)',
            'type' => 'number',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                ],
                'attr' => [
                    'class' => 'price',
                    'placeholder' => 'Pvz.: 10.50',
                    'step' => '0.01'
                ],
            ],
        ],
        'stock' => [
            'label' => 'In Stock',
            'type' => 'number',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                ],
                'attr' => [
                    'class' => 'in_stock',
                    'placeholder' => 'Pvz.: 25',
                    'step' => '0.01'
                ],
            ],
        ],
        'image' => [
            'label' => 'Image',
            'type' => 'text',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                ],
                'attr' => [
                    'class' => 'image',
                    'placeholder' => 'Url',
                ],
            ],
        ],
    ],

    'buttons' => [
        'create' => [
            'title' => 'Update',
            'extra' => [
                'attr' => [
                    'class' => 'send-btn',
                ],
            ],
        ],
    ],
    'message' => 'Duomenys sėkmingai suvesti!',
];

function form_success_update($inputs, &$form)
{
    $modelDrinks = new \App\Drinks\Model();
    $drinkADD = new App\Drinks\Drink($inputs);

    $modelDrinks->update($drinkADD);
}


function form_fail(&$form, $input)
{
    var_dump('Failas');
}

if (!empty($_POST)) {
    $inputs = get_form_input($form_update);
    $success = validate_form($form_update, $inputs);
} else {
    $success = false;
}

\App\App::$session->userLoggedIn();

$modelDrinks = new \App\Drinks\Model();
$drink = $modelDrinks->getById($_GET['id']);

$form_update['fields']['name']['value'] = $drink->getName();
$form_update['fields']['amount']['value'] = $drink->getAmount();
$form_update['fields']['abarot']['value'] = $drink->getAbarot();
$form_update['fields']['price']['value'] = $drink->getPrice();
$form_update['fields']['stock']['value'] = $drink->getInStock();
$form_update['fields']['image']['value'] = $drink->getImage();

$formView = new Form($form_update);
$navigationView = new \App\Views\Navigation();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="media/css/normalize.css">
    <link rel="stylesheet" href="media/css/milligram.min.css">
    <link rel="stylesheet" href="media/css/style.css">
    <title>Edit order</title>
</head>
<body>
<div class="nav_bar">
    <?php print $navigationView->render(); ?>
</div>
<div>
    <h3>EDIT DRINK CARD</h3>
    <?php print $formView->render(); ?>
</div>
</body>
</html>
