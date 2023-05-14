<?php

namespace Primitivo\DAE\Interfaces;

/**
 * Interface Rederable
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package Igrejanet\DAE\Interfaces
 */
interface Rederable
{
    public function toHTML(): string;

    public function toPDF(): string;
}