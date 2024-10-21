<?php
require_once 'php/forms/fields/BaseField.php';

class NumberField extends BaseField
{
    public function __construct(string $input_name, array $input_attributes, string $input_label, mixed $input_value)
    {
        parent::__construct($input_name, 'number', $input_attributes, $input_label, $input_value);
    }

    public function validate(): bool
    {
        if (parent::validate() === false) {
            return false;
        }
        $value = filter_var($this->value, FILTER_SANITIZE_NUMBER_INT, FILTER_NULL_ON_FAILURE);
        if (is_null($value)) {
            $this->error = $this->label . ' is not a valid number';
            $this->value = '';
            return false;
        }
        return true;
    }
}
