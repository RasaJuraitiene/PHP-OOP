<?php

/**
 * F-ija įrašanti array'jų į failą
 * (Json encode-ina)
 *
 * @param $array
 * @param $file
 * @return bool
 */
function array_to_file($array, $file)
{
    $string = json_encode($array);
    $bytes_written = file_put_contents($file, $string);
    if (is_numeric($bytes_written)) {
        return true;
    } else {
        return false;
    }
}

/**
 * F-ija nuskaitanti faila ir iš jo atgaminanti array'jų
 * (Json decode-ina)
 *
 * @param $file
 * @return bool|mixed
 */
function file_to_array($file)
{
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true);
    } else {
        return false;
    }
}
