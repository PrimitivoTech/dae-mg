<?php

namespace Primitivo\DAE\Interfaces;

interface Rederable
{
    public function toHTML(): string;

    public function toPDF(): string;
}
