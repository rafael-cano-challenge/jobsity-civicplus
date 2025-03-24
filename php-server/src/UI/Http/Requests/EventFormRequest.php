<?php

namespace App\UI\Http\Requests;

class EventFormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ];
    }

    public function validate(array $data): array
    {
        $errors = [];

        foreach ($this->rules() as $field => $fieldRules) {
            $this->validateField($field, explode('|', $fieldRules), $data, $errors);
        }

        return [
            'success' => empty($errors),
            'errors' => $errors,
        ];
    }

    protected function validateField(string $field, array $rules, array $data, array &$errors): void
    {
        foreach ($rules as $rule) {
            if ($this->checkRuleFailed($field, $rule, $data)) {
                $errors[$field][] = $this->getErrorMessage($field, $rule);

                if ($rule === 'required') break;
            }
        }
    }

    protected function checkRuleFailed(string $field, string $rule, array $data): bool
    {
        $value = $data[$field] ?? null;

        return match ($rule) {
            'required' => empty($value),
            'string' => !is_string($value),
            'date' => !$this->isValidDate($value),
            default => false,
        };
    }

    protected function isValidDate(mixed $value): bool
    {
        if (!is_string($value)) return false;

        try {
            new \DateTime($value);
            return true;
        } catch (\Exception) {
            return false;
        }
    }

    protected function getErrorMessage(string $field, string $rule): string
    {
        return $this->messageErrors()["$field.$rule"] ?? "Validation error for $field ($rule)";
    }

    public function messageErrors(): array
    {
        return [
            'title.required' => 'The title is required',
            'title.string' => 'The title must be a string',

            'description.required' => 'The description is required',
            'description.string' => 'The description must be a string',

            'startDate.required' => 'The start date is required',
            'startDate.date' => 'The start date must be a valid date',

            'endDate.required' => 'The end date is required',
            'endDate.date' => 'The end date must be a valid date',
        ];
    }
}