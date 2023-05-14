<?php

namespace Tests\Factories;

use Laminas\Barcode\Renderer\RendererInterface;
use PHPUnit\Framework\TestCase;
use Primitivo\DAE\Factories\BarcodeFactory;

class BarcodeFactoryTest extends TestCase
{
    public function testBarcodeFactory()
    {
        $factory = BarcodeFactory::make('123456');

        $this->assertInstanceOf(RendererInterface::class, $factory);
    }
}
