<?php

require('bootloader.php');

$logged_in = is_logged_in();

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

$show_form = isset($_COOKIE['user_id']) ? false : true;

$table = !$show_form ? prepare_table(file_to_array(DB_FILE)) : null;

?>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
</head>
<body>
<?php if ($logged_in === false): ?>
    <h1>To see the table, please <a href="login.php">log in!</a></h1>
<?php else: ?>
    <?php require('templates/table.tpl.php'); ?>
    <a href="logOut.php">Click here to log out!</a>
    <a href="deleteAccount.php">Click here to delete your account!</a>
<?php endif; ?>
</body>
</html>
