<?php
require_once 'php/forms/fields/BaseField.php';
class EmailField extends BaseField
{
    public function __construct(string $input_name, array $input_attributes, string $input_label)
    {
        parent::__construct($input_name, 'email', $input_attributes, $input_label);
    }

    public function validate(): bool
    {
        if (parent::validate() === false) {
            return false;
        }
        $value = filter_var($this->value, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE);
        if (is_null($value)) {
            $this->error = $this->label . ' is not a valid email';
            $this->value = '';
            return false;
        }
        return true;
    }
}
