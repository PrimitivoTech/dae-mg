<?php

use Primitivo\DAE\Utils;

it('should test helpers', function () {
    $strZero = Utils::fillZero(71, 7);
    $blanked = Utils::fillBlank(71, 7);

    expect($strZero)->toBe('0000071')
        ->and($blanked)->toBe('71     ');
});
