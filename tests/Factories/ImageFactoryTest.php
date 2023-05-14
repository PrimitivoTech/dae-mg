<?php

namespace Tests\Factories;

use PHPUnit\Framework\TestCase;
use Primitivo\DAE\Factories\{BarcodeFactory, ImageFactory};

class ImageFactoryTest extends TestCase
{
    public function testMake()
    {
        $barcode = BarcodeFactory::make(123456);
        $image   = ImageFactory::make($barcode);

        $this->assertIsString($image);
    }
}
