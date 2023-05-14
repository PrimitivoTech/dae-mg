<?php

namespace Tests;

use Primitivo\DAE\Utils;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase
{
    public function testHelpers()
    {
        $strZero = Utils::fillZero(71, 7);
        $blanked = Utils::fillBlank(71, 7);

        $this->assertEquals('0000071', $strZero);
        $this->assertEquals('71     ', $blanked);
    }
}