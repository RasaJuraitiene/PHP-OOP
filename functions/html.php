<?php

function html_attr($array)
{
    $attributes = [];
    foreach ($array as $key => $value) {
        $attribute = "$key=\"$value\"";
        $attributes[] = $attribute;
    }

    return implode(' ', $attributes);;
}