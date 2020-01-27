<?php
require '../bootloader.php';

use App\Views\Form;

if ($user = \App\App::$session->getUser()) {
    $show_form = true;
}

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
$form_order_button = [
    'callbacks' => [
        'success' => 'form_success_order_button',
        'fail' => 'form_fail',
    ],
    'attr' => [
        'method' => 'POST',
        'class' => 'my-form',
    ],
    'fields' => [
        'id' => [
            'type' => 'hidden',
        ]
    ],
    'buttons' => [
        'action' => [
            'title' => 'Deliver',
            'extra' => [
                'attr' => [
                    'class' => 'save-btn',
                ]
            ]
        ]
    ]
];

function form_success_order_button($inputs, &$form)
{
    $modelOrders = new \App\Orders\Model();
    $order = $modelOrders->getById($inputs['id']);
    $order->setStatus('Delivered');

    $modelOrders->update($order);
}

function form_fail(&$form, $input)
{
    var_dump('Failas');
}

if (!empty($_POST)) {
    $inputs = get_form_input($form_order_button);
    $success = validate_form($form_order_button, $inputs);
} else {
    $success = false;
}

$show_form = !$success;

//\App\App::$session->userLoggedIn();

$navigationView = new \App\Views\Navigation();

$orders_model = new \App\Orders\Model();
$orders = $orders_model->get([]);

$modelDrinks = new \App\Drinks\Model();
$drink = new \App\Drinks\Drink();

$orders_catalog = [];
foreach ($orders as $order) {
    $form_order_button['fields']['id']['value'] = $order->getId();
    $orders_catalog[] = [
        'order' => $order,
        'drink' => $modelDrinks->getById($order->getDrinkId()),
        'form_order_button' => new Form($form_order_button)
    ];
}

$navigationView = new \App\Views\Navigation();

$h1 = "Completed!"

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="media/css/normalize.css">
    <link rel="stylesheet" href="media/css/milligram.min.css">
    <link rel="stylesheet" href="media/css/style.css">
    <title>Orders</title>
</head>
<body>
<div class="nav_bar">
    <?php print $navigationView->render(); ?>
</div>
<div>
    <table>
        <thead>
        <tr>
            <td>Drink Name</td>
            <td>Drink ID</td>
            <td>Order ID</td>
            <td>Order time</td>
            <td>Status</td>
            <td>Action</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders_catalog as $item) : ?>
            <tr>
                <td><?php print $item['drink'] ? $item['drink']->getName() : 'Neebeegzistuoja'; ?></td>
                <td><?php print $item['order']->getDrinkId(); ?></td>
                <td><?php print $item['order']->getId(); ?></td>
                <td><?php print date('Y/d/m H:i:s', $item['order']->getTimestamp()); ?></td>
                <td><?php print $item['order']->getStatus(); ?></td>
                <td><?php if ($item['order']->getStatus() == 'Ordered'): ?>
                        <?php print $item['form_order_button']->render(); ?>
                    <?php else: ?>
                        <?php print $h1; ?>
                    <?php endif; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>

