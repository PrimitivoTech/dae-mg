<?php

namespace Primitivo\DAE\Factories;

use Laminas\Barcode\Renderer\RendererInterface;

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
