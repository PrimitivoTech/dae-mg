<?php

namespace Primitivo\DAE;

use InvalidArgumentException;
use Knp\Snappy\Pdf;

trait Renderer
{
    protected Pdf $pdf;

    public function __toString(): string
    {
        return $this->toHTML();
    }

    public function toHTML(bool $forPDFPrinting = false): string
    {
        if (!$this->isIsento() && (!$this->valor || $this->valor == 0)) {
            throw new InvalidArgumentException('É necessário informar um valor para geração do DAE');
        }

        ob_start();

        $data = get_object_vars($this);

        extract($data);

        $forPDFPrinting
            ? include(__DIR__ . '/../resources/view/dae-pdf.phtml')
            : include(__DIR__ . '/../resources/view/dae.phtml');

        return ob_get_clean();
    }

    public function toPDF(): string
    {
        return $this->pdf->getOutputFromHtml(
            $this->toHTML(true)
        );
    }

    public function bootstrapPDFRenderer()
    {
        $this->pdf = new Pdf(__DIR__ . '/../vendor/bin/wkhtmltopdf-amd64');
    }

    public function setPDFGeneratorBinary(string $binary)
    {
        if (!file_exists($binary)) {
            throw new InvalidArgumentException('The generator binary not exists');
        }

        $this->pdf->setBinary($binary);
    }
}
