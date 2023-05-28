<?php

use Carbon\Carbon;
use Primitivo\DAE\Enums\UF;
use Primitivo\DAE\Fluent;

it('should create a new `Fluent` instance adding the attributes dynamically', function () {
    $fluent = new \Primitivo\DAE\Fluent([
        'foo' => 'bar',
    ]);

    expect($fluent->foo)->toBe('bar')
        ->and($fluent->getAttributes())->toHaveKeys(['foo']);
});

it('should ensure that `Fluent` casts a date attribute', function () {
    $fluent = new Fluent([
        'date' => Carbon::parse('2021-01-01'),
    ]);

    $property = new ReflectionProperty($fluent, 'casts');
    $property->setAccessible(true);
    $property->setValue($fluent, [
        'date' => 'date:d/m/Y',
    ]);

    $response = $fluent->toArray();

    expect($response)->toBeArray()
        ->and($response['date'])->toBe('01/01/2021');
});

it('should ensure that `Fluent` casts an enum attribute', function () {
    $fluent = new Fluent([
        'estado' => UF::MINAS_GERAIS,
    ]);

    $property = new ReflectionProperty($fluent, 'casts');
    $property->setAccessible(true);
    $property->setValue($fluent, [
        'estado' => UF::class,
    ]);

    $response = $fluent->toArray();

    expect($response)->toBeArray()
        ->and($response['estado'])->toBe(UF::MINAS_GERAIS->value);
});
