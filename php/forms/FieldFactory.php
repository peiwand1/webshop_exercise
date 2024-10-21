<?php
require_once 'php/forms/fields/BaseField.php';
class FieldFactory
{

    public function createField(string $input_name, string $input_type, array $input_attributes = [], string $input_label = '', mixed $input_value = ''): BaseField
    {
        switch ($input_type) {
            case "textarea":
                require_once 'php/forms/fields/TextArea.php';
                return new TextArea($input_name, $input_attributes, $input_label);
            case "email":
                require_once 'php/forms/fields/EmailField.php';
                return new EmailField($input_name, $input_attributes, $input_label);
            case "number":
                require_once 'php/forms/fields/NumberField.php';
                return new NumberField($input_name, $input_attributes, $input_label, $input_value);
            case "hidden":
                require_once 'php/forms/fields/HiddenField.php';
                return new HiddenField($input_name);
            default:
                return new BaseField($input_name, $input_type, $input_attributes, $input_label);
        }
    }
}
