<?php

use Carbon\Carbon;
use Primitivo\DAE\DAE;

it('should generate a new `DAE` instance', function () {
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

    expect($dae)->toBeInstanceOf(DAE::class)
        ->toHTML()->toBeString();
});

it('should test `DAE` getters', function () {
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

    expect($dae)->toBeInstanceOf(DAE::class)
        ->getNome()->toBe($data['nome'])
        ->getEndereco()->toBe($data['endereco'])
        ->getMunicipio()->toBe($data['municipio'])
        ->getUf()->toBe($data['uf'])
        ->getTelefone()->toBe($data['telefone'])
        ->getDocumento()->toBe($data['documento'])
        ->getCobranca()->toBe($data['cobranca'])
        ->getVencimento()->toBe($data['vencimento'])
        ->getTipoIdentificacao()->toBe($data['tipoIdentificacao'])
        ->getHistorico()->toBe($data['historico'])
        ->getValor()->toBe((float)$data['valor'])
        ->getCodigoEstadual()->toBe($data['codigoEstadual'])
        ->getServico()->toBe($data['servico'])
        ->getOrgaoDestino()->toBe($data['orgaoDestino'])
        ->getEmpresa()->toBe($data['empresa']);
});

it('should throw an exception if dae does not have a value', function () {
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
})->throws(InvalidArgumentException::class, 'É necessário informar um valor para geração do DAE');
