<?php

function html_attr($array)
{
    $attributes = [];
    foreach ($array as $key => $value) {
        $attribute = "$key=\"$value\"";
        $attributes[] = $attribute;
    }

    return implode(' ', $attributes);
}

/**
 * Funkcija, kuri gauna lentelei reiksmes
 *
 * @param $array
 * @return array|bool
 */
function prepare_table($array)
{
    $db_table = [];

    if (!empty($array)) {

        foreach ($array as $values) {
            $compare = $compare ?? array_keys($values);
            if (array_keys($values) !== $compare) {
                return false;
            }
        }

        $db_table['thead'] = $compare;
        $db_table['tbody'] = $array;
    }

    return $db_table;
}
