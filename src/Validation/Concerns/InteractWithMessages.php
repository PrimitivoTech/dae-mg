<?php

declare(strict_types = 1);

namespace Primitivo\DAE\Validation\Concerns;

use Primitivo\DAE\Exceptions\ValidationException;

trait InteractWithMessages
{
    protected array $errorMessages = [
        'required'    => 'O :attribute é obrigatório.',
        'required_if' => 'O :attribute é obrigatório quando :other for :value.',
        'min'         => 'O :attribute deve ter no mínimo :value caracteres.',
        'max'         => 'O :attribute deve ter no máximo :value caracteres.',
        'integer'     => 'O :attribute deve ser um número inteiro.',
        'numeric'     => 'O :attribute deve ser um número.',
        'float'       => 'O :attribute deve ser um número decimal.',
        'date_format' => 'O :attribute deve ser uma data válida, com formato :value.',
        'boolean'     => 'O :attribute deve ser um valor booleano.',
        'phone'       => 'O :attribute deve ser um número de telefone válido.',
    ];

    private array $messages = [];

    private function triggerError(string $attribute, string $rule, array $parameters): void
    {
        throw new ValidationException(
            $this->makeFailureMessage($attribute, $rule, $parameters)
        );
    }

    private function makeFailureMessage(string $attribute, string $rule, array $parameters): string
    {
        $message = $this->errorMessages[$rule] ?? '';

        $placeholders = [':attribute', ':value'];
        $values       = [$attribute, $parameters[0] ?? ''];

        if (count($parameters) === 2) {
            $placeholders = [':attribute', ':other', ':value'];
            $values       = [$attribute, $parameters[0] ?? '', $parameters[1] ?? ''];
        }

        return str_replace($placeholders, $values, $message);
    }
}