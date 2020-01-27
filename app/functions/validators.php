<?php

function validate_login($inputs, &$form)
{
    $success = \App\App::$session->login($inputs['email'], $inputs['password']);

    if (!$success) {
    $form['fields']['email']['error'] = 'Neteisingai įvesti duomenys!';
    $form['fields']['password']['error'] = 'Neteisingai įvesti duomenys!';
        return false;
    }
    return true;
}

function validate_email_is_unique($field_value, &$field) {
    $modelUser = new \App\Users\Model();
    $users = $modelUser->get(['email' => $field_value]);
    if ($users) {
        $field['error'] = 'Vartotojas tokiu el.paštu jau registruotas!';
        return false;
    }
    
    return true;
}

function validate_chars_length($field_input, &$field, $params)
{
    $l = strlen($field_input);

    if (isset($params['max'])) {
        if ($l > $params['max']) {
            $field['error'] = "Virsytas leistinu simboliu kiekis (max: {$params['max']})";
            return false;
        }
    }

    if (isset($params['min'])) {
        if ($l < $params['min']) {
            $field['error'] = "Nepakankamas simbolių kiekis (min: {$params['min']})";
            return false;
        }
    }

    return true;
}