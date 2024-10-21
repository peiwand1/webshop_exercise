<?php

require_once 'php/page/HtmlDoc.php';
require_once 'php/page/HomeDoc.php';
require_once 'php/page/AboutDoc.php';
require_once 'php/page/ContactDoc.php';
require_once 'php/page/LoginDoc.php';
require_once 'php/page/RegisterDoc.php';
require_once 'php/page/ShoppingCartDoc.php';
require_once 'php/page/WebshopDoc.php';
require_once 'php/page/WebshopItemDoc.php';

require_once 'php/models/ModelManager.php';

require_once 'php/ShoppingCart.php';

require_once 'php/forms/FieldCollection.php';
require_once 'php/forms/Form.php';
require_once 'php/forms/data.php';

class PageController
{
    private string $pageTitle;
    private string $baseDir;
    private string $curPageName;
    private array $request;
    private HtmlDoc $curPage;
    private FieldCollection $fieldCollection;

    public function __construct(string $aPageTitle, string $aBaseDir)
    {
        $this->pageTitle = $aPageTitle;
        $this->baseDir = $aBaseDir;

        // sets current page based on $_GET['page'], defaults to home if unavailable
        $this->curPageName = $this->getRequestVar(false, 'page', 'home');

        // prepare field collection that belongs to the last request
        $this->request = $this->getRequest();
        $this->fieldCollection = new FieldCollection(
            field_info: getExtendedFieldsByPage($this->request['page']),
            field_factory: new FieldFactory()
        );
    }

    // generates the page body based on GET page value
    public function showCurrentPage(): void
    {
        switch ($this->curPageName) {
            case "home":
                $this->curPage = new HomeDoc($this->pageTitle, $this->baseDir);
                break;
            case "webshop":
                $this->curPage = new WebshopDoc($this->pageTitle, $this->baseDir);
                break;
            case "about":
                $this->curPage = new AboutDoc($this->pageTitle, $this->baseDir);
                break;
            case "contact":
                $this->curPage = new ContactDoc($this->pageTitle, $this->baseDir);
                break;
            case "login":
                $this->curPage = new LoginDoc($this->pageTitle, $this->baseDir);
                break;
            case "register":
                $this->curPage = new RegisterDoc($this->pageTitle, $this->baseDir);
                break;
            case "shopping_cart":
                $this->curPage = new ShoppingCartDoc($this->pageTitle, $this->baseDir);
                break;
            case "item":
                // filter the GET value for productid
                $productID = $this->getRequestVar(false, 'productid', '1');
                $this->curPage = new WebshopItemDoc($this->pageTitle, $this->baseDir, $productID);
                break;
            default:
                $this->curPage = new HtmlDoc($this->pageTitle, $this->baseDir);
                break;
        }
        $this->curPage->showPage();
    }

    // validates POSTed fields and then handles them in handleRequestCase()
    public function handleRequest(): void
    {
        if ($this->request['posted']) {
            require_once 'php/forms/Validator.php';
            $validator = new Validator($this->fieldCollection);
            if ($validator->validate()) {
                $this->handleRequestCase($this->request['page']);
            } else {
                //for testing
                echo "field didn't validate<br>";
            }
        }
    }

    // handles POST requests
    private function handleRequestCase($case)
    {
        switch ($case) {
            case "register":
                if (!ModelManager::getUserModel()->handleRegistration(
                    strtolower($_POST['email']),
                    ucwords($_POST['name']),
                    $_POST['pass1'],
                    $_POST['pass2']
                )) {
                    echo "<p>Register failed</p>";
                }
                break;
            case "login":
                if (ModelManager::getUserModel()->handleLogin($_POST['email'], $_POST['password'])) {
                    // reset cart content on logging in
                    ShoppingCart::getInstance()->clearCart();
                } else {
                    echo "<p>Login failed</p>";
                }
                break;
            case "logout":
                ModelManager::getUserModel()->handleLogout();
                break;
            case "contact":
                // TODO handle contact form
                $formData = array($_POST['name'], $_POST['email'], $_POST['message']);
                echo $formData[0] . " " . $formData[1] . " " . $formData[2];
                break;
            case "clear_cart":
                ShoppingCart::getInstance()->clearCart();
                break;
            case "order_product":
                if (ModelManager::getCartModel()->purchaseItems(ShoppingCart::getInstance()->getCartContent(), $_SESSION["user_id"])) {
                    ShoppingCart::getInstance()->clearCart();
                }
                break;
        }
    }

    private function getRequest(): array
    {
        $posted = $_SERVER['REQUEST_METHOD'] === 'POST';
        return [
            'posted' => $posted,
            'page'   => strtolower($this->getRequestVar($posted, 'page', ''))
        ];
    }

    private function getRequestVar(bool $from_post, string $varname, string $default): string
    {
        $result = filter_input(
            $from_post ? INPUT_POST : INPUT_GET,
            $varname,
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
        // echo ($result);
        return (is_null($result) || $result === false) ? $default : $result;
    }
}
