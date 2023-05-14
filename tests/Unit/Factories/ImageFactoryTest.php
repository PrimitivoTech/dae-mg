<?php

use Primitivo\DAE\Factories\{BarcodeFactory, ImageFactory};

it('makes an image from a barcode', function () {
    $barcode = BarcodeFactory::make(123456);
    $image   = ImageFactory::make($barcode);

    expect($image)->toBeString();
});
