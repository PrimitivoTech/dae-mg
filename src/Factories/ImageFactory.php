<?php

namespace Primitivo\DAE\Factories;

use Laminas\Barcode\Renderer\RendererInterface;

/**
 * ImageFactory
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 2.0.0
 * @package Igrejanet\Dae\Factories
 */
class ImageFactory
{
    public static function make(RendererInterface $barcode): string
    {
        $renderer = $barcode->draw();

        ob_start();

        imagejpeg($renderer, null, 100);

        $image = ob_get_clean();
        $image = base64_encode($image);

        imagedestroy($renderer);

        return $image;
    }
}