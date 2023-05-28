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

    public function validateAlpha(string $attribute, mixed $value, array $parameters = []): bool
    {
        if (isset($parameters[0]) && $parameters[0] === 'ascii') {
            return is_string($value) && preg_match('/\A[a-zA-Z]+\z/u', $value);
        }

        return is_string($value) && preg_match('/\A[\pL\pM]+\z/u', $value);
    }

    public function validateBoolean(string $attribute, mixed $value): bool
    {
        $acceptable = [true, false, 0, 1, '0', '1'];

        return in_array($value, $acceptable, true);
    }

    public function validateInteger(string $attribute, mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    public function validateNumeric(string $attribute, mixed $value): bool
    {
        return is_numeric($value);
    }

    public function validateRequired(string $attribute, mixed $value): bool
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

    public function validateNullable(): bool
    {
        return true;
    }

    public function validateInArray($attribute, $value, $parameters): bool
    {
        $this->requireParameterCount(1, $parameters, 'in_array');

        return in_array($value, $parameters);
    }

    public function validateDateFormat($attribute, $value, $parameters): bool
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
}
