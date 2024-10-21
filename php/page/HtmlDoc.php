<?php

require_once 'php/forms/Form.php';

class HtmlDoc
{
    protected string $pageTitle;
    protected string $directory;

    public function __construct(string $aPageTitle, string $aDirectory, string $aPage = '')
    {
        $this->pageTitle = $aPageTitle;
        $this->directory = $aDirectory;
    }

    public function showPage(): void
    {
        $this->docSetup();
        $this->showHeader();
        $this->showPageContent();
        $this->showFooter();
        $this->docClose();
    }

    protected function showPageContent(): void
    {
        echo "<p>You're not supposed to see this</p>";
    }

    // sets up the initial part of a html page
    protected function docSetup(): void
    {
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>' . $this->pageTitle . '</title>
            <link rel="stylesheet" href="/' . $this->directory . '/css/style.css">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            <script type="text/javascript" src="js/script.js"></script>
        </head>
        <body>';
    }

    // closes the tags that were opened in docSetup
    protected function docClose(): void
    {
        echo "</div></body></html>";
    }

    // makes page title and menu buttons for navigating pages
    protected function showHeader(): void
    {
        echo '<header>
        <h1>WEBSHOP</h1>
      </header>
    
      <div class="headerMenu headerMenuFont"><ul>
        <li><a href="/' . $this->directory . '/index.php?page=home">HOME</a></li>
        <li><a href="/' . $this->directory . '/index.php?page=webshop">SHOP</a></li>
        <li><a href="/' . $this->directory . '/index.php?page=about">ABOUT</a></li>
        <li><a href="/' . $this->directory . '/index.php?page=contact">CONTACT</a></li>
        ' . $this->showLoginButtons() . '
      </ul></div>';
    }

    // generates footer at the bottom of the page
    protected function showFooter(): void
    {
        echo "<footer>&copy;&nbsp;" . date("Y") . " - Peiwand Ismaiel" . "</footer>";
    }

    // shows either login and register buttons, or shows logout button and shopping cart.
    protected function showLoginButtons(): string
    {
        $str = '<div class="headerMenuRight"><ul>';

        if (isset($_SESSION['username'])) {
            $str = $str .
                '<form action="/' . $this->directory . '/index.php?page=home" method="POST">
                    <li><a href="/' . $this->directory . '/index.php?page=shopping_cart">CART</a></li>
                    <li><input class="headerMenuFont" type="submit" value="LOG OUT ' . strtoupper($_SESSION['username']) . '"></li>
                    <input type="hidden" name="page" value="logout">
                </form>';
        } else {
            $str = $str . '<li><a href="/' . $this->directory . '/index.php?page=login">LOGIN</a></li>
                           <li><a href="/' . $this->directory . '/index.php?page=register">REGISTER</a></li>';
        }
        return $str . '</ul></div>';
    }

    protected function generateForm(string $pageValue, FieldCollection $fields, string $action = '', string $submitCaption = 'Submit'): Form
    {
        return new Form(
            page: $pageValue,
            action: $action,
            method: 'POST',
            submit_caption: $submitCaption,
            field_collection: $fields
        );
    }
}
