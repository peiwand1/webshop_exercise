<?php
require_once 'php/page/HtmlDoc.php';
require_once 'php/forms/Form.php';

class RegisterDoc extends HtmlDoc
{
    private FieldCollection $fieldCollection;

    public function __construct(string $aPageTitle, string $aDirectory)
    {
        parent::__construct($aPageTitle, $aDirectory);

        $fieldFactory = new FieldFactory();
        $this->fieldCollection = new FieldCollection(
            field_info: getExtendedFieldsByPage('register'),
            field_factory: $fieldFactory
        );
    }

    protected function showPageContent(): void
    {
        $form = $this->generateForm('register', $this->fieldCollection,'index.php?page=home');

        echo $form->show();
    }
}
