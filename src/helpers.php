<?php

/**
 * @deprecated
 */
function fillZero($input, $length)
{
    return str_pad($input, $length, 0, STR_PAD_LEFT);
}

/**
 * @deprecated
 */
function fillBlank($input, $length)
{
    return str_pad($input, $length, ' ', STR_PAD_RIGHT);
}

/**
 * @deprecated
 */
function modulo11($numero)
{
    $mult = 2;
    $dig  = 0;

    for ($i = strlen($numero) - 1; $i >= 0; $i--) {
        $dig  = $dig + (substr($numero, $i, 1) * $mult);
        $mult = $mult + 1;

        if ($mult > 11) {
            $mult = 2;
        }
    }

    $dig = $dig % 11;

    if ($dig == 0) {
        $dig = 1;
    } else if ($dig == 1) {
        $dig = 0;
    } else {
        $dig = 11 - $dig;

        if ($dig > 9) {
            $dig = 0;
        }
    }

    return $dig;
}

/**
 * @deprecated
 */
function modulo10($numero)
{
    $mult    = 2;
    $somador = 0;
    $dig     = 0;

    for ($i = strlen($numero) - 1; $i >= 0; $i--) {
        $somador = (substr($numero, $i, 1) * $mult);

        if ($somador > 9) {
            for ($j = 0; $j < strlen($somador); $j++) {
                $dig = $dig + substr($somador, $j, 1);
            }
        } else {
            $dig = $dig + $somador;
        }

        if ($mult == 2) {
            $mult = 1;
        } else {
            $mult = 2;
        }
    }

    $dig = $dig % 10;
    $dig = 10 - $dig;

    if ($dig > 9) {
        $dig = 0;
    }

    return $dig;
}

/**
 * @deprecated
 */
function digitoVerificador($numero)
{
    $dg10 = modulo10($numero);
    $dg11 = modulo11($numero . $dg10);

    return $dg10 . $dg11;
}
