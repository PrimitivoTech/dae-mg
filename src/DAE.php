<?php

namespace Primitivo\DAE;

use Carbon\Carbon;
use Primitivo\DAE\Enums\UF;
use Primitivo\DAE\Factories\LinhaDigitavelFactory;
use Primitivo\DAE\Interfaces\Rederable;
use stdClass;

/**
 * @property string $nome
 * @property string $endereco
 * @property string $municipio
 * @property UF $uf
 * @property string $telefone
 * @property string $documento
 * @property int $servico
 * @property string $cobranca
 * @property Carbon $vencimento
 * @property int $tipoIdentificacao
 * @property Carbon $mesReferencia
 * @property string $historico
 * @property float $valor
 * @property string $codigoMunicipio
 * @property float $acrescimos
 * @property float $juros
 * @property string $nossoNumero
 * @property stdClass $linhaDigitavel
 * @property int $orgaoDestino
 * @property string $empresa
 * @property int $taxa
 * @property int $codigoEstadual
 * @property bool $isento
 */
class DAE extends Fluent implements Rederable
{
    use Renderer;

    protected array $attributes = [
        'taxa'   => 0,
        'isento' => true,
    ];

    protected $casts = [
        'vencimento'    => 'date:d/m/Y',
        'mesReferencia' => 'date:m/Y',
        'estado'        => UF::class,
    ];

    /**
     * @param array{
     *     nome: string,
     *     endereco: string,
     *     municipio: string,
     *     uf: UF,
     *     telefone: string,
     *     documento: string,
     *     servico: int,
     *     cobranca: string,
     *     vencimento: Carbon,
     *     tipoIdentificacao: int,
     *     mesReferencia: string,
     *     historico: string,
     *     valor: float,
     *     codigoMunicipio: string,
     *     acrescimos: float,
     *     juros: float,
     *     nossoNumero: string,
     *     linhaDigitavel: stdClass,
     *     orgaoDestino: int,
     *     empresa: string,
     *     taxa: int,
     *     codigoEstadual: int,
     *     isento: bool
     * } $attributes
     */
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->bootstrapPDFRenderer();
        $this->geraNossoNumero();
    }

    #region Methods
    public function isIsento(): bool
    {
        return $this->isento;
    }

    protected function geraNossoNumero(): void
    {
        $nossoNumero = Utils::nossoNumero($this);

        $this->geraCodigoBarras($nossoNumero);

        $this->nossoNumero = Utils::formatNossoNumero($nossoNumero);
    }

    protected function geraCodigoBarras(string $nossoNumero): void
    {
        $this->linhaDigitavel = LinhaDigitavelFactory::make($this, $nossoNumero);
    }
    #endregion Methods
}
