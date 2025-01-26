<?php

function isChar($char)
{
    if (($char >= 65 && $char <= 90) || ($char >= 97 && $char <= 122)) {
        return true;
    }
    return false;
}

function isNumber($number)
{
    if ($number >= 48 && $number <= 57) {
        return true;
    }
    return false;
}

function comprobar_letra($dni)
{
    $codigo = "TRWAGMYFPDXBNJZSQVHLCKE";
    $numeros = substr($dni, 0, 8);
    $resto = $numeros % 23;
    return $codigo[$resto] == strtoupper($dni[8]);
}

function comprobar_dni($dni)
{
    if (strlen($dni) == 9) {
        for ($i = 0; $i < strlen($dni); $i++) {
            $char = ord($dni[$i]);
            if ($i == 8) {
                if (!isChar($char)) {
                    return false;
                }
            } else {
                if (!isNumber($char)) {
                    return false;
                }
            }
        }
    } else {
        return false;
    }

    return comprobar_letra($dni);
}

function comprobar_codigo($codigo)
{
    if (strlen($codigo) <9) {
        for ($i = 0; $i < strlen($codigo); $i++) {
            $char = ord($codigo[$i]);
            if ($i == 0 || $i == 1 || $i == 2 ) {
                if (!isChar($char)) {
                    return false;
                }
            } else {
                if (!isNumber($char)) {
                    return false;
                }
            }
        }
        return true;
    } else {
        return false;
    }
}