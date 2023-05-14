<?php

use Laminas\Barcode\Renderer\RendererInterface;
use Primitivo\DAE\Factories\BarcodeFactory;

it('should create a new instance of `BarcodeInterface`', function () {
    $factory = BarcodeFactory::make('123456');

    $this->assertInstanceOf(RendererInterface::class, $factory);
});
