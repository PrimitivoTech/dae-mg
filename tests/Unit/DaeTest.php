<?php

use Carbon\Carbon;
use Primitivo\DAE\DAE;
use Primitivo\DAE\Enums\UF;

it('should generate a new `DAE` instance', function () {
    $data = [
        'nome'              => 'João Silva',
        'endereco'          => 'Alameda dos programadores',
        'municipio'         => 'Montes Claros',
        'uf'                => UF::MINAS_GERAIS,
        'telefone'          => '(38) 99191-2345',
        'documento'         => '187.489.162-18',
        'cobranca'          => '201600180',
        'vencimento'        => Carbon::today()->endOfMonth(),
        'tipoIdentificacao' => 4,
        'mesReferencia'     => Carbon::today(),
        'historico'         => '',
        'valor'             => 90,
        'codigoEstadual'    => 856,
        'servico'           => 71,
        'orgaoDestino'      => 321,
        'empresa'           => '0213',
    ];

    $dae = new DAE($data);

    expect($dae)->toBeInstanceOf(DAE::class)
        ->nome->toBe($data['nome'])
        ->endereco->toBe($data['endereco'])
        ->municipio->toBe($data['municipio'])
        ->uf->toBe(UF::MINAS_GERAIS)
        ->telefone->toBe($data['telefone'])
        ->documento->toBe($data['documento'])
        ->cobranca->toBe($data['cobranca'])
        ->vencimento->toBeInstanceOf(Carbon::class)
        ->tipoIdentificacao->toBe($data['tipoIdentificacao'])
        ->mesReferencia->toBeInstanceOf(Carbon::class)
        ->historico->toBe($data['historico'])
        ->valor->toBe($data['valor'])
        ->codigoEstadual->toBe($data['codigoEstadual'])
        ->servico->toBe($data['servico'])
        ->orgaoDestino->toBe($data['orgaoDestino'])
        ->empresa->toBe($data['empresa']);
});

it('should check if variables will be transformed when calling `toArray` method', function () {
    $data = [
        'nome'              => 'João Silva',
        'endereco'          => 'Alameda dos programadores',
        'municipio'         => 'Montes Claros',
        'uf'                => UF::MINAS_GERAIS,
        'telefone'          => '(38) 99191-2345',
        'documento'         => '187.489.162-18',
        'cobranca'          => '201600180',
        'vencimento'        => Carbon::today()->endOfMonth(),
        'tipoIdentificacao' => 4,
        'mesReferencia'     => Carbon::today(),
        'historico'         => '',
        'valor'             => 90,
        'codigoEstadual'    => 856,
        'servico'           => 71,
        'orgaoDestino'      => 321,
        'empresa'           => '0213',
    ];

    $dae = (new DAE($data))
        ->toArray();

    expect($dae)->toBeArray()
        ->and($dae['nome'])->toBe($data['nome'])
        ->and($dae['endereco'])->toBe($data['endereco'])
        ->and($dae['municipio'])->toBe($data['municipio'])
        ->and($dae['uf'])->toBe(UF::MINAS_GERAIS->value)
        ->and($dae['telefone'])->toBe($data['telefone'])
        ->and($dae['documento'])->toBe($data['documento'])
        ->and($dae['cobranca'])->toBe($data['cobranca'])
        ->and($dae['vencimento'])->toBe($data['vencimento']->format('d/m/Y'))
        ->and($dae['tipoIdentificacao'])->toBe($data['tipoIdentificacao'])
        ->and($dae['mesReferencia'])->toBe($data['mesReferencia']->format('m/Y'))
        ->and($dae['historico'])->toBe($data['historico'])
        ->and($dae['valor'])->toBe((float)$data['valor'])
        ->and($dae['codigoEstadual'])->toBe($data['codigoEstadual'])
        ->and($dae['servico'])->toBe($data['servico'])
        ->and($dae['orgaoDestino'])->toBe($data['orgaoDestino'])
        ->and($dae['empresa'])->toBe($data['empresa']);
});
