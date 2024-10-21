<?php
require_once 'php/page/HtmlDoc.php';
require_once 'php/ShoppingCart.php';

class ShoppingCartDoc extends HtmlDoc
{
    private FieldCollection $updateAmountFields;
    private FieldCollection $clearCartFields;
    private FieldCollection $orderFields;

    public function __construct(string $aPageTitle, string $aDirectory)
    {
        parent::__construct($aPageTitle, $aDirectory);

        $fieldFactory = new FieldFactory();
        $this->updateAmountFields = new FieldCollection(
            field_info: getExtendedFieldsByPage('update_cart_amount'),
            field_factory: $fieldFactory
        );
        $this->clearCartFields = new FieldCollection(
            field_info: getExtendedFieldsByPage('order_product'),
            field_factory: $fieldFactory
        );
        $this->orderFields = new FieldCollection(
            field_info: getExtendedFieldsByPage('clear_cart'),
            field_factory: $fieldFactory
        );
    }

    protected function showPageContent(): void
    {
        $currentCart = ShoppingCart::getInstance()->getCartContent();
        if (!empty($currentCart)) { // if cart is not empty
            $result = ModelManager::getCartModel()->getCartItemInfo($currentCart);
            $price_total = 0;

            echo '<div class="cart-overview"><div class="shop-items">';
            foreach ($result as $row) {
                echo '
                <div class="item item-cart border shadow">
                    <img class="item-img" src="images/products/' . $row['product_id'] . '/' . $row['image_path'] . '" alt="' . $row['image_alt_text'] . '">
                    <div>
                        <a href="/' . $this->directory . '/index.php?page=item&productid=' . $row['product_id'] . '"><p class="item-name">' . $row['name'] . '</p></a>
                        <p class="item-price">€' . $row['price'] . '</p>';

                // get the generic form and set the product_id and amount
                $formStr = $this->generateForm('update_cart_amount', $this->updateAmountFields, '', 'Update')->show();
                $formStr = str_replace(
                    'name="amount" value=""',
                    'name="amount" value="' . $currentCart[$row['product_id']] . '"',
                    $formStr
                );
                $formStr = str_replace(
                    'name="product_id" value=""',
                    'name="product_id" value="' . $row['product_id'] . '"',
                    $formStr
                );

                echo $formStr;
                echo '</div>
                </div>';
                
                $price_total += $row['price'] * $currentCart[$row['product_id']];
            }
            echo '</div>';

            $this->showCartSubMenu($price_total);
            echo '</div>';
        } else {
            echo '<div class="center"><p>Cart Empty</p></div>';
        }
    }

    // creates menu that shows total price of products along with buttons to clear cart/order products
    private function showCartSubMenu($price_total): void
    {
        echo '<div class="cart-summary border shadow"><p>Subtotal: €' . number_format($price_total, 2, '.', '').'</p>';
        echo $this->generateForm('clear_cart', $this->clearCartFields, '', 'Clear Cart')->show();
        echo $this->generateForm('order_product', $this->orderFields, '', 'Order')->show();

        echo '</div>';
    }
}
