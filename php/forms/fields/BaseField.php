<?php
class BaseField
{
    protected string $name;
    protected string $type;
    protected array $attributes;
    protected string $label;
    protected string $error;
    protected mixed $value;

    public function __construct(string $input_name, string $input_type, array $input_attributes = [], string $input_label = '', mixed $input_value = '')
    {
        $this->name = $input_name;
        $this->type = $input_type;
        $this->attributes = $input_attributes;
        $this->label = $input_label;
        $this->error = '';
        $this->value = $input_value;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function show(): string
    {
        $str = '';
        if (strcmp($this->label, '') !== 0) {
            $str .= $this->showLabel(); // only show label if it is set
        }

        $str .= $this->showField();

        if (!empty($this->error)) {
            $str .= $this->showError();
        }

        return $str;
    }

    public function validate(): bool
    {
        $value = filter_input(INPUT_POST, $this->name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (is_null($value)) {
            $this->error = $this->name . ' not found.';
            return false;
        }
        if ($value === false) {
            $this->error = $this->name . ' is invalid';
            return false;
        }
        $value = trim($value);
        if (empty($value) && $value !== '0') {
            $this->error = $this->name . ' is empty';
            return false;
        }
        $this->value = $value;
        return true;
    }

    protected function showLabel(): string
    {
        return '<label for="' . $this->name . '" >' . $this->label . '</label><br/>';
    }

    protected function showField(): string
    {
        $str = '<input type="' . $this->type . '" name="' . $this->name . '" value="' . $this->value . '" ' . $this->getAttributesAsString() . '/>';

        // if field is not hidden, add line break
        if (strcmp($this->type, 'hidden') !== 0) {
            $str .= '<br/><br/>';
        }

        return $str;
    }

    protected function showError(): string
    {
        return '<span class="input_error">' . $this->error . '</span><br/>';
    }

    protected function getAttributesAsString(): string
    {
        $str = '';
        foreach ($this->attributes as $attribute => $value) {
            $str .= $attribute . '="' . $value . '" ';
        }

        return $str;
    }
}
