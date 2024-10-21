<?php
require_once 'php/forms/fields/BaseField.php';
class TextArea extends BaseField
{
    public function __construct(string $input_name, array $input_attributes, string $input_label)
    {
        parent::__construct($input_name, '', $input_attributes, $input_label);
    }

    protected function showField(): string
    {
        return '<textarea name="' . $this->name . '">' . $this->value . '</textarea><br/><br/>';
    }
}
