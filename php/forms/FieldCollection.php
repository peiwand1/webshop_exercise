<?php
require_once 'php/forms/FieldFactory.php';
class FieldCollection
{
    protected array $fields;
    protected FieldFactory $field_factory;

    public function __construct(array $field_info, FieldFactory $field_factory)
    {
        $this->field_factory = $field_factory;
        $this->createFields($field_info);
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    protected function createFields(array $field_info): void
    {
        $this->fields = [];
        foreach ($field_info as $name => $info) {
            $this->fields[] = $this->field_factory->createField(
                $name,
                $info['type'],
                isset($info['attributes']) ? $info['attributes'] : [],
                isset($info['label']) ? $info['label'] : '',
                isset($info['value']) ? $info['value'] : ''
            );
        }
    }
}
