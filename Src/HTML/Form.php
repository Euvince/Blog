<?php

namespace App\HTML;

use DateTimeInterface;

class Form 
{
    private $data;

    private $errors;

    public function __construct($data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function input(string $key, string $label): string
    {
        $value = $this->getValue($key);
        $type = $key === 'password' ? 'password' : 'text';
        return <<<HTML
        <div class="form-group">
            <label for="field{$key}">{$label}</label>
            <input type="{$type}" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" value="{$value}" required>
            {$this->getErrorFeedback($key)}
        </div>
HTML;
    }

    public function textarea(string $key, string $label): string
    {
        $value = $this->getValue($key);
        return <<<HTML
        <div class="form-group">
            <label for="field{$key}">{$label}</label>
            <textarea type="text" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" required>{$value}</textarea>
            {$this->getErrorFeedback($key)}
        </div>
HTML;
    }

    private function getValue (string $key): ?string
    {
        if (is_array($this->data))
        {
            return $this->data[$key] ?? null;
        }
        /* $method = 'get' . ucfirst($key); */
        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        $value = $this->data->$method();
        if ($value instanceof DateTimeInterface)
        {
           return $value->format('Y-m-d H:i:s');
        }
        return $value;
    }

    private function getInputClass (string $key): string
    {
        $inputClass = 'form-control';
        if (array_key_exists($key, $this->errors))
        {
            $inputClass .= ' is-invalid';
        }
        return $inputClass;
    }

    public function getErrorFeedback (string $key): string
    {
        $invalidFeddback = '';
        if (array_key_exists($key, $this->errors)){
            if (is_array($this->errors[$key])){
                $error = implode('<br>', $this->errors[$key]);
            }else {
                $error = $this->errors[$key];
            }
            return '<div class="invalid-feedback">' . $error . '</div>';
        }
        return '';
    }
    
}