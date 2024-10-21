<?php
class Validator
{
    protected FieldCollection $field_collection;

    public function __construct(FieldCollection $field_collection)
    {
        $this->field_collection = $field_collection;
    }

    public function validate(): bool
    {
        // echo 'validating';
        $result = true;
        foreach ($this->field_collection->getFields() as $field) {
            // echo '<br>validateloop ' . $field->getName() . ' ' . $field->getValue();
            if ($field->validate() === false) {
                $result = false;
                // echo 'failed to validate';
            }
        }

        return $result;
    }
}
