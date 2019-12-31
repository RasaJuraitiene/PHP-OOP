<?php

require('functions/form/validators.php');

/**
 * F-ija uzpildanti laukeliu vertes
 *
 * @param $form visas $form masyvas
 * @param $input visas input'as (analogas POST masyvui)
 */
function fill_form(&$form, $input)
{
    foreach ($input as $field_index => $field_value) {
        $form['fields'][$field_index]['value'] = $field_value;
    }
}

/**
 * F-ija, išfiltruojanti POST masyvą nuo hujnių
 *
 * @param $form
 * @return mixed
 */
function get_form_input($form)
{
    $filter_params = [];
    foreach ($form['fields'] as $fieldName => $field) {
        if (isset($field['filter'])) {
            $filter_params[$fieldName] = $field['filter'];
        } else {
            $filter_params[$fieldName] = FILTER_SANITIZE_FULL_SPECIAL_CHARS;
        }
    }

    return filter_input_array(INPUT_POST, $filter_params);
}

/**
 * Pagr. f-ija, kuri iškviečia visus formos validatorius
 * ir grąžina atsakymą, ar viskas buvo gerai užpildyta
 *
 * @param $form Visas form masyvas
 * @param $inputs Visi form inputai (Jau turi būti prafiltruoti su get_form_input)
 * @return bool
 */
function validate_form(&$form, $inputs)
{
    $success = true;

    foreach ($form['fields'] as $name => &$field) {
        $field_value = $inputs[$name];

        foreach ($field['validators'] ?? [] as $validator_index => $validator) {
            if (is_array($validator)) {
                $validator_function = $validator_index;
                $params = $validator;

                $is_valid = $validator_function($field_value, $field, $params);
            } else {
                $is_valid = $validator($field_value, $field);
            }

            if (!$is_valid) {
                $success = false;
                break;
            } else {
                // Jeigu laukas teisingai uzpildytas, tam, kad nedingtų jo vertė:
                $field['value'] = $field_value;
            }
        }
    }

    // Formos masto validatorius yra tolkas kviesti tik tada
    // kai fieldų validatoriai nepašiko reikalo. T.y. forma gerai užpildyta
    if ($success) {
        foreach ($form['validators'] as $validator_index => $validator) {
            if (is_array($validator)) {
                $validator_function = $validator_index;
                $params = $validator;

                $is_valid = $validator_function($inputs, $form['fields'], $params);
            } else {
                $is_valid = $validator($inputs, $form['fields']);
            }

            if (!$is_valid) {
                $success = false;
                break;
            }
        }
    }

    if (isset($form['callbacks'])) {
        $index = $success ? 'success' : 'fail';
        if ($form['callbacks'][$index] ?? false) $form['callbacks'][$index]($form, $inputs);
    }

    return $success;
}

