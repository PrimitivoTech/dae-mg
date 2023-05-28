<?php

declare(strict_types = 1);

namespace Primitivo\DAE;

class LinhaDigitavel
{
    public function __construct(
        public readonly string $linhaDigitavel,
        public readonly string $numeroBarra,
        public readonly string $codigoImpresso,
    ) {
    }
}
