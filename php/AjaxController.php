<?php
require_once 'php/models/ModelManager.php';
require_once 'php/ShoppingCart.php';

class AjaxController
{
    public function __construct()
    {
    }

    public function handleRequest()
    {
        $this->handleAjaxRequest();
    }

    protected function getVar($name, $default = "NOP")
    {
        return isset($_GET[$name]) ? $_GET[$name] : $default;
    }

    protected function postVar($name, $default = "NOP")
    {
        return isset($_POST[$name]) ? $_POST[$name] : $default;
    }

    protected function handleAjaxRequest()
    {
        $case = $this->getVar('ajax');
        switch ($case) {
            case "give_rating":
                $success = ModelManager::getShopModel()->giveRating($this->getVar('product'), $_SESSION['user_id'], $this->getVar('rating'));
                if ($success) {
                    require_once 'php/page/elements/StarRating.php';

                    $starRating = new StarRating();
                    $starRating->showStarRatingInteractable($this->getVar('product'));
                } else {
                    echo 'Failed to give rating';
                }
                break;
            case "add_to_cart":
                ShoppingCart::getInstance()->addToCart($this->getVar('product_id'), $this->getVar('amount'));
                break;
            case "update_cart_amount":
                $success = ShoppingCart::getInstance()->updateCart($this->getVar('product_id'), $this->getVar('amount'));
                // recalculate the total price
                if ($success) {
                    $cart = ShoppingCart::getInstance()->getCartContent();
                    $result = ModelManager::getCartModel()->getCartItemInfo($cart);
                    $price_total = 0;
                    foreach ($result as $row) {
                        $price_total += $row['price'] * $_SESSION['cart_content'][$row['product_id']];
                    }
                    echo '<p>Subtotal: €' . number_format($price_total, 2, '.', '').'</p>';
                }
                break;
        }
    }
}
