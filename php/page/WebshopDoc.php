<?php
require_once 'php/page/HtmlDoc.php';
require_once 'php/page/elements/StarRating.php';
require_once 'php/models/ModelManager.php';

class WebshopDoc extends HtmlDoc
{
    private FieldCollection $fieldCollection;
    private StarRating $starRating;

    public function __construct(string $aPageTitle, string $aDirectory)
    {
        parent::__construct($aPageTitle, $aDirectory);

        $fieldFactory = new FieldFactory();
        $this->fieldCollection = new FieldCollection(
            field_info: getExtendedFieldsByPage('add_to_cart'),
            field_factory: $fieldFactory
        );

        $this->starRating = new StarRating();
    }

    protected function showPageContent(): void
    {
        echo '<div class="shop-items">';

        // get 10 most recent available products and display them
        $result = ModelManager::getShopModel()->getShopItems();

        foreach ($result as $row) {
            $this->createShopItem($row);
        }

        // TODO, add pagination

        echo '</div>';
    }

    private function createShopItem($productData): void
    {
        echo '
            <div class="item border shadow">
                <img class="item-img" src="images/products/' . $productData['product_id'] . '/' . $productData['image_path'] . '" alt="' . $productData['image_alt_text'] . '">
                <div>
                    <a href="/' . $this->directory . '/index.php?page=item&productid=' . $productData['product_id'] . '"><p class="item-name">' . $productData['name'] . '</p></a>
                    <p class="item-price">€' . $productData['price'] . '</p>';

        if (isset($_SESSION['username'])) {
            $this->showAddToCartButton($productData['product_id']);
            echo '<br>';
            $this->starRating->showStarRatingInteractable($productData['product_id']);
        } else {
            $this->starRating->showStarRatingNonInteractable($productData['product_id']);
        }

        echo '</div></div>';
    }

    protected function showAddToCartButton($productID): void
    {
        $formStr = $this->generateForm('add_to_cart', $this->fieldCollection, '', 'Add to cart')->show();
        $formStr = str_replace(
            'name="product_id" value=""',
            'name="product_id" value="' . $productID . '"',
            $formStr
        );
        echo $formStr;
    }
}
