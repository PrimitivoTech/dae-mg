<?php

declare(strict_types = 1);

namespace Primitivo\DAE\Validation\Concerns;

use DateTime;
use InvalidArgumentException;
use ValueError;

trait ValidateAttributes
{
    public function requireParameterCount($count, $parameters, $rule): void
    {
        if (count($parameters) < $count) {
            throw new InvalidArgumentException("Validation rule $rule requires at least $count parameters.");
        }
    }

    public function validateBoolean(mixed $value): bool
    {
        $acceptable = [true, false, 0, 1, '0', '1'];

        return in_array($value, $acceptable, true);
    }

    public function validateInteger(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    public function validateFloat(mixed $value): bool
    {
        return is_float($value);
    }

    public function validateRequired(mixed $value): bool
    {
        if (is_null($value)) {
            return false;
        } elseif (is_string($value) && trim($value) === '') {
            return false;
        } elseif (is_countable($value) && count($value) < 1) {
            return false;
        }

        return true;
    }

    public function validateInArray($value, $parameters): bool
    {
        $this->requireParameterCount(1, $parameters, 'in_array');

        return in_array($value, $parameters);
    }

    public function validateDateFormat($value, $parameters): bool
    {
        $this->requireParameterCount(1, $parameters, 'date_format');

        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        foreach ($parameters as $format) {
            try {
                $date = DateTime::createFromFormat('!' . $format, $value);

                if ($date && $date->format($format) == $value) {
                    return true;
                }
            } catch (ValueError) {
                return false;
            }
        }

        return false;
    }

    public function validateRequiredIf($attribute, $value, $parameters): bool
    {
        $this->requireParameterCount(2, $parameters, 'required_if');

        if (!array_key_exists($parameters[0], $this->attributes)) {
            return true;
        }

        [$values, $other] = $this->parseDependentRuleParameters($parameters);

        if (in_array($other, $values, is_bool($other) || is_null($other))) {
            return $this->validateRequired($attribute, $value);
        }

        return true;
    }

    public function validateMin(string $value, $parameter): bool
    {
        return mb_strlen($value) >= $parameter[0];
    }

    public function validateMax(string $value, $parameter): bool
    {
        return mb_strlen($value) <= $parameter[0];
    }

    public function validateString($value): bool
    {
        return is_string($value);
    }

    public function validatePhone($value): bool
    {
        return (bool)preg_match('/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/', $value);
    }

    public function validateNullable(): bool
    {
        return true;
    }

    public function parseDependentRuleParameters($parameters): array
    {
        $other = $this->attributes[$parameters[0]] ?? null;

        $values = array_slice($parameters, 1);

        if ($this->shouldConvertToBoolean($parameters[0]) || is_bool($other)) {
            $values = $this->convertValuesToBoolean($values);
        }

        if (is_null($other)) {
            $values = $this->convertValuesToNull($values);
        }

        return [$values, $other];
    }

    protected function shouldConvertToBoolean($parameter): bool
    {
        return in_array('boolean', $this->rules[$parameter] ?? []);
    }

    protected function convertValuesToBoolean($values): array
    {
        return array_map(function ($value) {
            if ($value === 'true') {
                return true;
            } elseif ($value === 'false') {
                return false;
            }

            return $value;
        }, $values);
    }

    protected function convertValuesToNull($values): array
    {
        return array_map(
            fn ($value) => mb_strtolower($value) === 'null' ? null : $value, $values
        );
    }
}
