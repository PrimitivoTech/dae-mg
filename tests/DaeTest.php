<?php

namespace Tests;

use Carbon\Carbon;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Primitivo\DAE\DAE;

class DaeTest extends TestCase
{
    public function testDae()
    {
        $data = [
            // Dados do Sacado
            'nome'      => 'Matheus Lopes Santos',
            'endereco'  => 'Rua dos Jesuítas, 88, Nª Sª das Graças',
            'municipio' => 'Montes Claros',
            'uf'        => 'MG',
            'telefone'  => '(38) 99183-9930',
            'documento' => '101.384.146-88',

            // Dados da Cobrança
            'cobranca'          => '201600180',
            'vencimento'        => new Carbon('2019-01-10'),
            'tipoIdentificacao' => 4,
            'mesReferencia'     => date('m/Y'),
            'historico'         => '',
            'valor'             => 90,

            // Dados repassados pelo estado de minas gerais
            'codigoEstadual' => 856,
            'servico'        => 71,
            'orgaoDestino'   => 321,
            'empresa'        => '0213',
        ];

        $dae = new DAE($data);

        $this->assertInstanceOf(DAE::class, $dae);
        $this->assertIsString($dae->toHTML());
    }

    public function testGetters()
    {
        $data = [
            // Dados do Sacado
            'nome'      => 'Matheus Lopes Santos',
            'endereco'  => 'Rua dos Jesuítas, 88, Nª Sª das Graças',
            'municipio' => 'Montes Claros',
            'uf'        => 'MG',
            'telefone'  => '(38) 99183-9930',
            'documento' => '101.384.146-88',

            // Dados da Cobrança
            'cobranca'          => '201600180',
            'vencimento'        => new Carbon('2019-01-10'),
            'tipoIdentificacao' => 4,
            'mesReferencia'     => Carbon::now()->format('m/Y'),
            'historico'         => '',
            'valor'             => 90,

            // Dados repassados pelo estado de minas gerais
            'codigoEstadual' => 856,
            'servico'        => 71,
            'orgaoDestino'   => 321,
            'empresa'        => '0213',
        ];

        $dae = new DAE($data);

        $this->assertEquals($data['nome'], $dae->getNome());
        $this->assertEquals($data['endereco'], $dae->getEndereco());
        $this->assertEquals($data['municipio'], $dae->getMunicipio());
        $this->assertEquals($data['uf'], $dae->getUf());
        $this->assertEquals($data['telefone'], $dae->getTelefone());
        $this->assertEquals($data['documento'], $dae->getDocumento());
        $this->assertEquals($data['cobranca'], $dae->getCobranca());
        $this->assertEquals($data['vencimento'], $dae->getVencimento());
        $this->assertEquals($data['tipoIdentificacao'], $dae->getTipoIdentificacao());
        $this->assertEquals($data['historico'], $dae->getHistorico());
        $this->assertEquals($data['valor'], $dae->getValor());
        $this->assertEquals($data['codigoEstadual'], $dae->getCodigoEstadual());
        $this->assertEquals($data['servico'], $dae->getServico());
        $this->assertEquals($data['orgaoDestino'], $dae->getOrgaoDestino());
        $this->assertEquals($data['empresa'], $dae->getEmpresa());
    }

    public function testDaeSemValor()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('É necessário informar um valor para geração do DAE');

        $data = [
            // Dados do Sacado
            'nome'      => 'Matheus Lopes Santos',
            'endereco'  => 'Rua dos Jesuítas, 88, Nª Sª das Graças',
            'municipio' => 'Montes Claros',
            'uf'        => 'MG',
            'telefone'  => '(38) 99183-9930',
            'documento' => '101.384.146-88',

            // Dados da Cobrança
            'cobranca'          => '201600180',
            'vencimento'        => new Carbon('2019-01-10'),
            'tipoIdentificacao' => 4,
            'mesReferencia'     => Carbon::now()->format('m/Y'),
            'historico'         => '',

            // Dados repassados pelo estado de minas gerais
            'codigoEstadual' => 856,
            'servico'        => 71,
            'orgaoDestino'   => 321,
            'empresa'        => '0213',
        ];

        $dae = new DAE($data);
        $dae->toHTML();
    }
}
