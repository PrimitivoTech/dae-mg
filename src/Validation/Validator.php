<?php

declare(strict_types = 1);

namespace Primitivo\DAE\Validation;

class Validator
{
    use Concerns\InteractWithMessages;
    use Concerns\ValidateAttributes;

    private array $rules = [
        'nome'              => ['required', 'min:3', 'max:100'],
        'endereco'          => ['required'],
        'municipio'         => ['required'],
        'uf'                => ['required'],
        'telefone'          => ['nullable'],
        'documento'         => ['required'],
        'servico'           => ['required', 'integer'],
        'cobranca'          => ['required', 'string'],
        'vencimento'        => ['required', 'date_format:d/m/Y'],
        'tipoIdentificacao' => ['required', 'integer'],
        'mesReferencia'     => ['required', 'date_format:m/Y'],
        'historico'         => ['nullable', 'string'],
        'valor'             => ['required_if:isento,false', 'float'],
        'codigoMunicipio'   => ['required', 'string'],
        'acrescimos'        => ['nullable', 'float'],
        'juros'             => ['nullable', 'float'],
        'nossoNumero'       => ['required', 'string'],
        'linhaDigitavel'    => ['required'],
        'orgaoDestino'      => ['required', 'integer'],
        'empresa'           => ['required', 'string'],
        'taxa'              => ['required', 'integer'],
        'codigoEstadual'    => ['required', 'integer'],
        'isento'            => ['nullable', 'boolean'],
    ];

    public function __construct(
        private readonly array $attributes
    ) {}

    public function validate(): bool
    {
        foreach ($this->rules as $attribute => $rules) {
            foreach ($rules as $rule) {
                $this->validateAttribute($attribute, $rule);
            }
        }

        return true;
    }

    protected function validateAttribute(string $attribute, string $rule): void
    {
        [$rule, $parameters] = $this->parseRule($rule);

        if ($rule === '') {
            return;
        }

        $value = $this->attributes[$attribute] ?? null;

        $method = "validate" . ucfirst($rule);

        if (!$this->$method($value, $parameters, $this)) {
            $this->triggerError($attribute, $rule, $parameters);
        }
    }

    private function parseRule(string $rule): array
    {
        if (!str_contains($rule, ':')) {
            return [$rule, []];
        }

        [$rule, $parameters] = explode(':', $rule, 2);

        return [$rule, explode(',', $parameters)];
    }
}