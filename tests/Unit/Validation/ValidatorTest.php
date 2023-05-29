<?php

declare(strict_types = 1);

use Primitivo\DAE\Enums\UF;
use Primitivo\DAE\Exceptions\ValidationException;
use Primitivo\DAE\Validation\Validator;

it('should ensure that `nome` is required', function () {
    $validator = new Validator(['nome' => '']);

    $validator->validate();
})->throws(ValidationException::class, 'O nome é obrigatório.');

it('should ensure that `nome` has at least 3 chars', function () {
    (new Validator(['nome' => 'ab']))
        ->validate();
})->throws(ValidationException::class, 'O nome deve ter no mínimo 3 caracteres.');

it('should ensure that `nome` has up to 100 chars', function () {
    (new Validator(['nome' => str_repeat('a', 101)]))
        ->validate();
})->throws(ValidationException::class, 'O nome deve ter no máximo 100 caracteres.');

it('should ensure that `endereco` is required', function () {
    (new Validator([
        'nome'     => 'João Silva',
        'endereco' => null,
    ]))->validate();
})->throws(ValidationException::class, 'O endereco é obrigatório.');

it('should ensure that `municipio` is required', function () {
    (new Validator([
        'nome'     => 'João Silva',
        'endereco' => 'Rua do programador',
    ]))->validate();
})->throws(ValidationException::class, 'O municipio é obrigatório.');

it('should ensure that `uf` is required', function () {
    (new Validator([
        'nome'      => 'João Silva',
        'endereco'  => 'Rua do programador',
        'municipio' => 'São Paulo',
        'uf'        => null,
    ]))->validate();
})->throws(ValidationException::class, 'O uf é obrigatório.');

it('should ensure that `telefone` is a valid phone', function (string $phoneNumber) {
    (new Validator([
        'nome'      => 'João Silva',
        'endereco'  => 'Rua do programador',
        'municipio' => 'São Paulo',
        'uf'        => UF::MINAS_GERAIS->value,
        'telefone'  => $phoneNumber,
    ]))->validate();
})->with([
    '9919239',
    'abc32140000',
    '3030120',
    '123456789000',
])->throws(ValidationException::class, 'O telefone deve ser um número de telefone válido.');