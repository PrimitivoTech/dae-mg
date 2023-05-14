<?php

namespace Primitivo\DAE\Factories;

use Laminas\Barcode\Barcode;
use Laminas\Barcode\Object\Code25interleaved;
use Laminas\Barcode\Renderer\RendererInterface;

/**
 * BarcodeFactory
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 2.0.0
 * @package Igrejanet\Dae\Factories
 */
class BarcodeFactory
{
    public static function make(string $text, $barHeight = 80): RendererInterface
    {
        $barcodeOptions  = ['text' => $text, 'drawText' => false, 'barheight' => $barHeight];
        $rendererOptions = ['imageType' => 'jpg'];

        return Barcode::factory(new Code25interleaved($barcodeOptions), 'image', $rendererOptions);
    }
}