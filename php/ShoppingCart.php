<?php

// class for interacting with session variable cart_content
class ShoppingCart
{
    private static $_instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): object
    {
        $class = get_called_class();
        if (self::$_instance === null) {
            self::$_instance = new $class;
        }
        return self::$_instance;
    }

    public function addToCart($productID, $amount)
    {
        if (!is_numeric($amount)) return;

        // check if key already exists
        if (array_key_exists($productID, $_SESSION['cart_content'])) {
            // add amount to existing amount
            $_SESSION['cart_content'][$productID] += $amount;

            // check if new total is still over 0, in case $amount was somehow negative
            if ($_SESSION['cart_content'][$productID] <= 0) {
                $this->removeFromCart($productID);
            }
        } else {
            // add key with amount
            $_SESSION['cart_content'][$productID] = $amount;
        }
    }

    public function updateCart($productID, $amount): bool
    {
        if (!is_numeric($amount)) return false;

        // check if key already exists
        if (array_key_exists($productID, $_SESSION['cart_content'])) {
            // add amount to existing amount
            $_SESSION['cart_content'][$productID] = $amount;

            // check if new total is still over 0, in case $amount was set to 0
            if ($_SESSION['cart_content'][$productID] <= 0) {
                $this->removeFromCart($productID);
            }
        } else {
            return false;
        }

        return true;
    }

    public function removeFromCart($productID): void
    {
        if (array_key_exists($productID, $_SESSION['cart_content'])) {
            unset($_SESSION['cart_content'][$productID]);
        }
    }

    public function getCartContent(): array
    {
        return $_SESSION['cart_content'];
    }

    public function clearCart()
    {
        $_SESSION['cart_content'] = array();
    }

    public function isCartEmpty(): bool
    {
        return empty($_SESSION['cart_content']);
    }
}
