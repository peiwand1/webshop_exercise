<?php
require_once 'php/page/HtmlDoc.php';
require_once 'php/forms/Form.php';

class ContactDoc extends HtmlDoc
{
    private FieldCollection $fieldCollection;

    public function __construct(string $aPageTitle, string $aDirectory)
    {
        parent::__construct($aPageTitle, $aDirectory);

        $fieldFactory = new FieldFactory();
        $this->fieldCollection = new FieldCollection(
            field_info: getExtendedFieldsByPage('contact'),
            field_factory: $fieldFactory
        );
    }

    protected function showPageContent(): void
    {
        $form = $this->generateForm('contact', $this->fieldCollection, 'index.php?page=home');

        echo $form->show();
    }
}
