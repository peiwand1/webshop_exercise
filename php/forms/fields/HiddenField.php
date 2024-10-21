<?php
require_once 'php/forms/fields/BaseField.php';

class HiddenField extends BaseField
{
    public function __construct(string $input_name)
    {
        parent::__construct($input_name, 'hidden');
    }

    public function validate(): bool
    {
        if (parent::validate() === false) {
            return false;
        }
        $value = filter_var($this->value, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE);
        if (is_null($value)) {
            $this->error = $this->label . ' is not a valid input';
            $this->value = '';
            return false;
        }
        return true;
    }
}
