<?php

use Core\FileDB;
use App\Views\Form;
use App\Views;
use App\Users\User;

require '../bootloader.php';

$form_create = [
    'callbacks' => [
        'success' => 'form_success_create',
        'fail' => 'form_fail',
    ],
    'attr' => [
        //'method' => 'POST', //defaultu postas yra
        'class' => 'my-form',
        'id' => 'login-form',
    ],
    'fields' => [
        'name' => [
            'label' => '',
            'type' => 'text',
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
    ],
    'buttons' => [
        'create' => [
            'title' => 'Submit',
            'extra' => [
                'attr' => [
                    'class' => 'send-btn',
                ],
            ],
        ],
    ],
    'message' => 'Duomenys sėkmingai suvesti!',
];

$form_delete = [
    'callbacks' => [
        'success' => 'form_success_delete',
        'fail' => 'form_fail',
    ],
    'attr' => [
        'method' => 'POST',
        'class' => 'my-form',
        'id' => 'login-form'
    ],
    'fields' => [
        'id' => [
            'type' => 'hidden',
        ]
    ],
    'buttons' => [
        'delete' => [
            'title' => 'Delete',
            'extra' => [
                'attr' => [
                    'class' => 'save-btn',
                ]
            ]
        ]
    ]
];

$form_order = [
    'callbacks' => [
        'success' => 'form_success_order',
        'fail' => 'form_fail',
    ],
    'attr' => [
        'method' => 'POST',
        'class' => 'my-form',
        'id' => 'login-form'
    ],
    'fields' => [
        'id' => [
            'type' => 'hidden',
        ]
    ],
    'buttons' => [
        'order' => [
            'title' => 'Order',
            'extra' => [
                'attr' => [
                    'class' => 'save-btn',
                ]
            ]
        ]
    ]
];

$form_update = [
    'callbacks' => [
        'success' => 'form_success_update',
        'fail' => 'form_fail',
    ],
    'attr' => [
        'method' => 'GET',
        'class' => 'my-form',
        'action' => 'edit-drink.php'
    ],
    'fields' => [
        'id' => [
            'type' => 'hidden',
        ]
    ],
    'buttons' => [
        'update' => [
            'title' => 'Update',
            'extra' => [
                'attr' => [
                    'class' => 'save-btn',
                ]
            ]
        ]
    ]
];

/**
 * F-ija, kurią iškviečia validate_form
 * jeigu forma buvo gerai užpildyta
 *
 * @param $form
 * @param $inputs
 */
function form_success_create($inputs, &$form)
{
    $modelDrinks = new \App\Drinks\Model();
    $drinkADD = new App\Drinks\Drink($inputs);

    $modelDrinks->insert($drinkADD);
//    $drinksArray = $modelDrinks->get([]);
}

function form_success_delete($inputs, &$form)
{
    $modelDrinks = new \App\Drinks\Model();
    $drinkADD = new App\Drinks\Drink($inputs);

    $modelDrinks->delete($drinkADD);

//    $drinksArray = $modelDrinks->get([]);
}

function form_success_order($inputs, &$form)
{

    $modelOrders = new \App\Orders\Model();
    $orderADD = new App\Orders\Order([
        'drink_id' => $inputs['id'],
        'timestamp' => time(),
        'status' => 'Ordered'
    ]);
    $modelOrders->insert($orderADD);


    $modelDrinks = new \App\Drinks\Model();

    $drink = $modelDrinks->getById($inputs['id']);

    $stock_left = $drink->getInStock() - 1;
    $drink->setInStock($stock_left);

    $modelDrinks->update($drink);

}

function form_success_update($inputs, &$form)
{
    $modelDrinks = new \App\Drinks\Model();
    $drinkADD = new App\Drinks\Drink($inputs);

    $modelDrinks->update($drinkADD);
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
    switch (get_form_action()) {
        case 'create':
            $inputs = get_form_input($form_create);
            $success = validate_form($form_create, $inputs);
            break;

        case 'delete':
            $inputs = get_form_input($form_delete);
            $success = validate_form($form_delete, $inputs);
            break;

        case 'order':
            $inputs = get_form_input($form_order);
            $success = validate_form($form_order, $inputs);
            break;

        case 'update':
            $inputs = get_form_input($form_update);
            $success = validate_form($form_update, $inputs);
            break;

    }
} else {
    $success = false;
}

$modelDrinks = new \App\Drinks\Model();
$drinksArray = $modelDrinks->get([]);

$show_form = !$success;

$h1 = 'Jau!';
\App\App::$session->userLoggedIn();


$formView = new Form($form_create);
$navigationView = new \App\Views\Navigation();

$catalog = [];
foreach ($drinksArray as $drink) {
    $form_delete['fields']['id']['value'] = $drink->getId();
    $form_order['fields']['id']['value'] = $drink->getId();
    $form_update['fields']['id']['value'] = $drink->getId();
    $catalog[] = [
        'form_delete' => new Form($form_delete),
        'form_order' => new Form($form_order),
        'form_update' => new Form($form_update),
         'dataholder' => $drink,
    ];
}

$cookie = new \Core\Cookie('tracking');
$data = $cookie->read();


if(empty($data)){
    $data = [
        'count' => 1
    ];
} else {
    $data['count']++;

    $cookie->save($data, 60);
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="media/css/normalize.css">
    <link rel="stylesheet" href="media/css/milligram.min.css">
    <link rel="stylesheet" href="media/css/style.css">
    <title>Index</title>
</head>
<body>
<div class="nav_bar">
    <?php print $navigationView->render(); ?>
</div>
<?php if (\App\App::$session->userLoggedIn() === false): ?>
    <h1>To see the form, please <a href="login.php">Log in!</a></h1>
<?php else: ?>
    <?php if ($show_form): ?>
        <?php print $formView->render(); ?>
    <?php else: ?>
        <h1><?php print $h1; ?></h1>
    <?php endif; ?>
<?php endif; ?>
<?php foreach ($catalog as $item): ?>
    <div class="drink">
        <div>
            <span class="drink-price"><?php print $item['dataholder']->getPrice() . '£'; ?></span>
            <img class="drink-image" src="<?php print $item['dataholder']->getImage(); ?>">
            <div class="drink_align">
                <span><?php print $item['dataholder']->getAmount() . ' ml'; ?></span>
                <span class="drink-name"><?php print $item['dataholder']->getName(); ?></span>
                <span><?php print $item['dataholder']->getAbarot() . ' %'; ?></span>
            </div>
        </div>
    </div>
    <div class="drink-stock"><?php print 'In Stock: ' . $item['dataholder']->getInStock(); ?></div>
    <?php if (\App\App::$session->userLoggedIn() === true): ?>
        <div><?php print $item['form_delete']->render(); ?></div>
        <div><?php print $item['form_update']->render(); ?></div>
    <?php else: ?>
        <div><?php print $item['form_order']->render(); ?></div>
    <?php endif; ?>
<?php endforeach; ?>
</body>
</html>
