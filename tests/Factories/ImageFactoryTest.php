<?php

namespace Tests\Factories;

use Primitivo\DAE\Factories\BarcodeFactory;
use Primitivo\DAE\Factories\ImageFactory;
use PHPUnit\Framework\TestCase;

class ImageFactoryTest extends TestCase
{
    public function testMake()
    {
        $barcode = BarcodeFactory::make(123456);
        $image   = ImageFactory::make($barcode);

        $this->assertIsString($image);
    }
}
