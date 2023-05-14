<?php

namespace Primitivo\DAE\Factories;

use Laminas\Barcode\Barcode;
use Laminas\Barcode\Object\Code25interleaved;
use Laminas\Barcode\Renderer\RendererInterface;

class BarcodeFactory
{
    public static function make(string $text, $barHeight = 80): RendererInterface
    {
        $barcodeOptions  = ['text' => $text, 'drawText' => false, 'barheight' => $barHeight];
        $rendererOptions = ['imageType' => 'jpg'];

        return Barcode::factory(new Code25interleaved($barcodeOptions), 'image', $rendererOptions);
    }
}
