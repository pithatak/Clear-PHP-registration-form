<?php

namespace App\Core;

class Validator
{
    private array $data;
    private array $rules;
    private array $errors = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->validate();
    }

    private function validate(): void
    {
        foreach ($this->rules as $field => $rules) {
            $value = trim($this->data[$field] ?? '');

            foreach ($rules as $rule) {
                if ($rule === 'required' && $value === '') {
                    $this->errors[$field][] = "Field \"{$field}\" is required.";

                    break;
                }

                if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field][] = "Field \"{$field}\" must be a valid email.";
                }

                if (str_starts_with($rule, 'min:')) {
                    $min = (int)substr($rule, 4);
                    if (strlen($value) < $min) {
                        $this->errors[$field][] = "The \"{$field}\" field cannot be less than {$min} letters long.";
                    }
                }

                if (str_starts_with($rule, 'max:')) {
                    $max = (int)substr($rule, 4);
                    if (strlen($value) > $max) {
                        $this->errors[$field][] = "The \"{$field}\" field cannot be more than than {$max} letters long.";
                    }
                }

                if (str_starts_with($rule, 'length:')) {
                    $len = (int)substr($rule, 7);
                    if (strlen($value) !== $len) {
                        $this->errors[$field][] = "The \"{$field}\" field must be exactly {$len} characters.";
                    }
                }

                if ($rule === 'alpha' && !ctype_alpha($value)) {
                    $this->errors[$field][] = "The \"{$field}\" field must contain only letters.";
                }

                if ($rule === 'numeric' && !ctype_alnum($value)) {
                    $this->errors[$field][] = "The \"{$field}\" field must contain only numbers.";
                }
            }
        }
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
