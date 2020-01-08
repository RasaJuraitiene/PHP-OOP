<?php

/**
 * Patikrinimas ar laukelis nera tuscias
 *
 * @param $field_value Ivesti duomenis į laukelį
 * @param $field Laukelio masyvas iš formos
 * @return bool
 */
function validate_not_empty($field_value, &$field)
{
    if (empty($field_value)) {
        $field['error'] = 'Laukelis tuscias';
        return false;
    } else {
        return true;
    }
}

/**
 * Patikrinimas ar e-mail yra tinkamas
 *
 * @param $field_input
 * @param $field
 * @return bool
 */
function validate_email($field_input, &$field)
{
    $regex = '/^[a-zA-Z0-9._-]+[@]{1}[a-zA-Z0-9.]+[.]{1}[a-zA-Z0-9]{1,5}$/';
    if (!preg_match($regex, $field_input)) {
        $field['error'] = 'Netinkamas el pasto formatas';
        return false;
    }
    return true;
}

/**
 * Patikrinimas ar laukeliai sutampa
 *
 * @param $inputs Visas formos input'as (analogas POST masyvui)
 * @param $fields Visi formos laukeliai ($form['fields'])
 * @param $params Masyvas, kuriame nurodome kokie laukeliai turi sutapti (indeksai)
 * @return bool
 */
function validate_form_match($inputs, &$fields, $params)
{
    foreach ($params as $index) {
        $compare = $compare ?? $inputs[$index];
        if ($inputs[$index] !== $compare) {
            $fields[$index]['error'] = 'nesutampa reiksmes';
            return false;
        }
    }
    return true;
}

/**
 * Patikrinimas laukelio simboliu skaiciaus
 *
 * @param $field_input
 * @param $field
 * @param array $params
 * @return bool
 */
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

function validate_is_number($field_value, &$field)
{
    if (!is_numeric($field_value)) {
        $field['error'] = 'Laukelis privalo buti skaicius';
        return false;
    } else {
        return true;
    }
}
