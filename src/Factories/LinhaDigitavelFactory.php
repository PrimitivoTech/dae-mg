<?php

namespace Primitivo\DAE\Factories;

use Primitivo\DAE\DAE;
use Primitivo\DAE\Utils;
use stdClass;

/**
 * LinhaDigitavelFactory
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 2.0.0
 * @package Igrejanet\Dae\Factories
 */
class LinhaDigitavelFactory
{
    public const VERSAO_DAE = 12;

    public static function make(DAE $dae, string $nossoNumero): stdClass
    {
        $inicio       = $dae->getCodigoEstadual();
        $empresa      = $dae->getEmpresa();
        $valor        = $dae->getValor();
        $vencimento   = $dae->getVencimento()->format('ymd');
        $orgaoDestino = $dae->getOrgaoDestino();
        $taxa         = $dae->getTaxa();

        // Deixamos o valor plano, sem pontuação, e preenche com zeros à esquerda
        $valor  = Utils::fillZero(preg_replace("/[^0-9]/", '', $valor), 11);
        $versao = self::VERSAO_DAE;

        $campos = $valor . $empresa . $vencimento . $versao . $nossoNumero . $taxa . $orgaoDestino;

        $codigoBarra = $inicio . Utils::modulo10($inicio . $campos) . $campos;

        $linhaDigitavel = preg_replace_callback('/([0-9]{11})/', function ($match) {
            return $match[1] . ' ' . Utils::modulo10($match[1]) . ' ';
        }, $codigoBarra);

        $barcode = BarcodeFactory::make($codigoBarra, 50);
        $image   = ImageFactory::make($barcode);

        $barra                 = new stdClass();
        $barra->linhaDigitavel = $linhaDigitavel;
        $barra->numeroBarra    = $codigoBarra;
        $barra->codigoImpresso = $image;

        return $barra;
    }
}