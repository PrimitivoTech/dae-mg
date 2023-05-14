<?php

require_once('../vendor/autoload.php');

use Carbon\Carbon;
use Igrejanet\DAE\DAE;

$data = [
    // Dados do Sacado
    'nome'      => 'João da Silva Olímpio',
    'endereco'  => 'Praça Dr. Carlos, S/N, Centro',
    'municipio' => 'Montes Claros',
    'uf'        => 'MG',
    'telefone'  => '(38) 3221-0000',
    'documento' => '123.456.789-09',

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

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="file.pdf"');
echo $dae->toPDF();
