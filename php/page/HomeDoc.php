<?php
require_once 'php/page/HtmlDoc.php';

class HomeDoc extends HtmlDoc
{
    public function __construct(string $aPageTitle, string $aDirectory)
    {
        parent::__construct($aPageTitle, $aDirectory);
    }
    
    protected function showPageContent(): void
    {
        echo "<p>Welkom</p>";
    }
}
