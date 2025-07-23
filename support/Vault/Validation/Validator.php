<?php
namespace Support\Vault\Validation;

class Validator
{
    protected array $errors = [];

    /**
     * Validate the data against the rules.
     * 
     * @param array $data Input data to validate
     * @param array $rules Validation rules ['field' => 'rule1|rule2:param']
     * @return bool True if validation passes, false otherwise
     */
    public function passes(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $ruleString) {
            $rulesArray = explode('|', $ruleString);
            $value = $data[$field] ?? null;

            if (in_array('nullable', $rulesArray, true) && $value === null) {
                continue;
            }

            foreach ($rulesArray as $rule) {
                if ($rule === 'nullable') {
                    continue;
                }

                $params = null;

                if (strpos($rule, ':') !== false) {
                    [$ruleName, $params] = explode(':', $rule, 2);
                } else {
                    $ruleName = $rule;
                }

                $method = 'validate' . ucfirst($ruleName);

                if (!method_exists($this, $method)) {
                
                    continue;
                }

                if (!$this->$method($field, $value, $params, $data)) {
                    break; 
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * Get validation errors.
     * 
     * @return array Errors as ['field' => 'message']
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function addError(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = $message;
        }
    }

    // --- Validation rules ---

    protected function validateRequired(string $field, $value, $params, array $data): bool
    {
        if ($value === null || $value === '' || (is_array($value) && empty($value))) {
            $this->addError($field, "The $field field is required.");
            return false;
        }
        return true;
    }

    protected function validateEmail(string $field, $value, $params, array $data): bool
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "The $field field must be a valid email address.");
            return false;
        }
        return true;
    }

    protected function validateMin(string $field, $value, $params, array $data): bool
    {
        if ($value !== null && strlen($value) < (int)$params) {
            $this->addError($field, "The $field field must be at least $params characters.");
            return false;
        }
        return true;
    }

    protected function validateMax(string $field, $value, $params, array $data): bool
    {
        if ($value !== null && strlen($value) > (int)$params) {
            $this->addError($field, "The $field field may not be greater than $params characters.");
            return false;
        }
        return true;
    }

    protected function validateSame(string $field, $value, $params, array $data): bool
    {
        if (!isset($data[$params]) || $value !== $data[$params]) {
            $this->addError($field, "The $field field must match $params.");
            return false;
        }
        return true;
    }

    protected function validateConfirmed(string $field, $value, $params, array $data): bool
    {
        $confirmationField = $field . '_confirmation';
        if (!isset($data[$confirmationField]) || $value !== $data[$confirmationField]) {
            $this->addError($field, "The $field confirmation does not match.");
            return false;
        }
        return true;
    }

    protected function validateNumeric(string $field, $value, $params, array $data): bool
    {
        if ($value !== null && !is_numeric($value)) {
            $this->addError($field, "The $field field must be a number.");
            return false;
        }
        return true;
    }

    protected function validateInteger(string $field, $value, $params, array $data): bool
    {
        if ($value !== null && filter_var($value, FILTER_VALIDATE_INT) === false) {
            $this->addError($field, "The $field field must be an integer.");
            return false;
        }
        return true;
    }

    protected function validateBoolean(string $field, $value, $params, array $data): bool
    {
        if ($value !== null && !in_array($value, [true, false, 1, 0, '1', '0'], true)) {
            $this->addError($field, "The $field field must be true or false.");
            return false;
        }
        return true;
    }

    protected function validateUrl(string $field, $value, $params, array $data): bool
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_URL)) {
            $this->addError($field, "The $field field must be a valid URL.");
            return false;
        }
        return true;
    }

    protected function validateDate(string $field, $value, $params, array $data): bool
    {
        if ($value && strtotime($value) === false) {
            $this->addError($field, "The $field field must be a valid date.");
            return false;
        }
        return true;
    }

    protected function validateIn(string $field, $value, $params, array $data): bool
    {
        $allowed = explode(',', $params);
        if ($value !== null && !in_array($value, $allowed, true)) {
            $this->addError($field, "The $field field must be one of the following: $params.");
            return false;
        }
        return true;
    }

    protected function validateNotIn(string $field, $value, $params, array $data): bool
    {
        $disallowed = explode(',', $params);
        if ($value !== null && in_array($value, $disallowed, true)) {
            $this->addError($field, "The $field field may not be one of the following: $params.");
            return false;
        }
        return true;
    }

    protected function validateAlpha(string $field, $value, $params, array $data): bool
    {
        if ($value !== null && !preg_match('/^[a-zA-Z]+$/', $value)) {
            $this->addError($field, "The $field field may only contain letters.");
            return false;
        }
        return true;
    }

    protected function validateAlphaNum(string $field, $value, $params, array $data): bool
    {
        if ($value !== null && !preg_match('/^[a-zA-Z0-9]+$/', $value)) {
            $this->addError($field, "The $field field may only contain letters and numbers.");
            return false;
        }
        return true;
    }

    protected function validateAlphaDash(string $field, $value, $params, array $data): bool
    {
        if ($value !== null && !preg_match('/^[a-zA-Z0-9_-]+$/', $value)) {
            $this->addError($field, "The $field field may only contain letters, numbers, dashes, and underscores.");
            return false;
        }
        return true;
    }
}