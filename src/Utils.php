<?php

namespace Primitivo\DAE;

class Utils
{
    public static function fillZero($input, int $length): string
    {
        return str_pad($input, $length, 0, STR_PAD_LEFT);
    }

    public static function fillBlank($input, int $length): string
    {
        return str_pad($input, $length, ' ', STR_PAD_RIGHT);
    }

    public static function modulo11($numero): int
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
        } else {
            if ($dig == 1) {
                $dig = 0;
            } else {
                $dig = 11 - $dig;

                if ($dig > 9) {
                    $dig = 0;
                }
            }
        }

        return $dig;
    }

    public static function modulo10($numero): int
    {
        $mult = 2;
        $dig  = 0;

        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $somador = ((int)substr($numero, $i, 1) * $mult);

            if ($somador > 9) {
                for ($j = 0; $j < strlen($somador); $j++) {
                    $dig = $dig + (int)substr($somador, $j, 1);
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

    public static function digitoVerificador($numero): string
    {
        $dg10 = static::modulo10($numero);
        $dg11 = static::modulo11($numero . $dg10);

        return $dg10 . $dg11;
    }

    public static function nossoNumero(DAE $dae): string
    {
        $nossoNumero = static::fillZero($dae->servico, 2) . static::fillZero($dae->cobranca, 9);
        $nossoNumero .= static::digitoVerificador($nossoNumero);

        return $nossoNumero;
    }

    public static function formatNossoNumero(string $nossoNumero): string
    {
        return preg_replace('/([0-9]{2})([0-9]{9})([0-9]{2})/', '\1-\2/\3', $nossoNumero);
    }
}
