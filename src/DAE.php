<?php

namespace Primitivo\DAE;

use Carbon\Carbon;
use InvalidArgumentException;
use Primitivo\DAE\Factories\LinhaDigitavelFactory;
use Primitivo\DAE\Interfaces\Rederable;
use stdClass;

/**
 * Dae
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 2.0.0
 * @package Igrejanet\Dae
 */
class DAE implements Rederable
{
    use Renderer;

    protected string $nome;

    protected string $endereco;

    protected string $municipio;

    protected string $uf;

    protected string $telefone;

    protected string $documento;

    protected int $servico;

    protected string $cobranca;

    protected Carbon $vencimento;

    protected int $tipoIdentificacao;

    protected string $mesReferencia;

    protected string $historico;

    protected ?float $valor = null;

    protected ?string $codigoMunicipio = null;

    protected float $acrescimos = 0.00;

    protected float $juros = 0.00;

    protected string $nossoNumero;

    protected stdClass $linhaDigitavel;

    protected int $orgaoDestino;

    protected string $empresa;

    protected int $taxa = 0;

    protected int $codigoEstadual;

    protected bool $isento = false;

    public function __construct(array $dados)
    {
        foreach ($dados as $key => $item) {
            $method = 'set' . ucfirst($key);

            $this->$method($item);
        }

        $this->bootstrapPDFRenderer();
        $this->geraNossoNumero();
    }

    protected function geraNossoNumero()
    {
        $nossoNumero = Utils::nossoNumero($this);

        $this->geraCodigoBarras($nossoNumero);

        $this->nossoNumero = Utils::formatNossoNumero($nossoNumero);
    }

    protected function geraCodigoBarras(string $nossoNumero)
    {
        $this->linhaDigitavel = LinhaDigitavelFactory::make($this, $nossoNumero);
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): DAE
    {
        $this->nome = $nome;

        return $this;
    }

    public function getEndereco(): string
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): DAE
    {
        $this->endereco = $endereco;

        return $this;
    }

    public function getMunicipio(): string
    {
        return $this->municipio;
    }

    public function setMunicipio(string $municipio): DAE
    {
        $this->municipio = $municipio;

        return $this;
    }

    public function getUf(): string
    {
        return $this->uf;
    }

    public function setUf(string $uf): DAE
    {
        if (strlen($uf) != 2) {
            throw new InvalidArgumentException('A UF deve conter 2 caracteres');
        }

        $this->uf = $uf;

        return $this;
    }

    public function getTelefone(): string
    {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): DAE
    {
        $this->telefone = $telefone;

        return $this;
    }

    public function getDocumento(): string
    {
        return $this->documento;
    }

    public function setDocumento(string $documento): DAE
    {
        $this->documento = $documento;

        return $this;
    }

    public function getServico(): int
    {
        return $this->servico;
    }

    public function setServico(int $servico): DAE
    {
        $this->servico = $servico;

        return $this;
    }

    public function getCobranca(): string
    {
        return $this->cobranca;
    }

    public function setCobranca(string $cobranca): DAE
    {
        $this->cobranca = $cobranca;

        return $this;
    }

    public function getVencimento(): Carbon
    {
        return $this->vencimento;
    }

    public function setVencimento(Carbon $vencimento): DAE
    {
        $this->vencimento = $vencimento;

        return $this;
    }

    public function getTipoIdentificacao(): int
    {
        return $this->tipoIdentificacao;
    }

    public function setTipoIdentificacao(int $tipoIdentificacao): DAE
    {
        $this->tipoIdentificacao = $tipoIdentificacao;

        return $this;
    }

    public function getMesReferencia(): string
    {
        return $this->mesReferencia;
    }

    public function setMesReferencia(string $mesReferencia): DAE
    {
        $this->mesReferencia = $mesReferencia;

        return $this;
    }

    public function getHistorico(): string
    {
        return $this->historico;
    }

    public function setHistorico(string $historico): DAE
    {
        $this->historico = $historico;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(?float $valor): DAE
    {
        $this->valor = $valor;

        return $this;
    }

    public function getCodigoMunicipio(): ?string
    {
        return $this->codigoMunicipio;
    }

    public function setCodigoMunicipio(?string $codigoMunicipio): DAE
    {
        $this->codigoMunicipio = $codigoMunicipio;

        return $this;
    }

    public function getAcrescimos(): float
    {
        return $this->acrescimos;
    }

    public function setAcrescimos(float $acrescimos): DAE
    {
        $this->acrescimos = $acrescimos;

        return $this;
    }

    public function getJuros(): float
    {
        return $this->juros;
    }

    public function setJuros(int $juros): DAE
    {
        $this->juros = $juros;

        return $this;
    }

    public function getOrgaoDestino(): int
    {
        return $this->orgaoDestino;
    }

    public function setOrgaoDestino(int $orgaoDestino): DAE
    {
        $this->orgaoDestino = $orgaoDestino;

        return $this;
    }

    public function getEmpresa(): string
    {
        return $this->empresa;
    }

    public function setEmpresa(string $empresa): DAE
    {
        $this->empresa = $empresa;

        return $this;
    }

    public function getTaxa(): int
    {
        return $this->taxa;
    }

    public function setTaxa(int $taxa): DAE
    {
        $this->taxa = $taxa;

        return $this;
    }

    public function getCodigoEstadual(): int
    {
        return $this->codigoEstadual;
    }

    public function setCodigoEstadual(int $codigoEstadual): DAE
    {
        $this->codigoEstadual = $codigoEstadual;

        return $this;
    }

    public function isIsento(): bool
    {
        return $this->isento;
    }

    public function setIsento(bool $isento): void
    {
        $this->isento = $isento;
    }
}
