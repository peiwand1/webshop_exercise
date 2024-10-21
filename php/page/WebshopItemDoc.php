<?php
require_once 'php/page/WebshopDoc.php';

class WebshopItemDoc extends WebshopDoc
{
    private int $productID;

    public function __construct(string $aPageTitle, string $aDirectory, int $aProductID)
    {
        parent::__construct($aPageTitle, $aDirectory);
        $this->productID = $aProductID;
    }

    protected function showPageContent(): void
    {

        $result = ModelManager::getShopModel()->getFullItemDescription($this->productID);
        if ($result) {
            echo '
                <div class="item-page">
                    <div class="item-page-img"><img src="images/products/' . $result['product_id'] . '/' . $result['image_path'] . '"></div>
                    <div class="item-page-description">
                        <p class="item-name">' . $result['name'] . '</p>
                        <p>' . (strcmp($result['description'], "") == 0 ? "Item has no description" : $result['description']) . '</p>
                    </div>
                </div>';

            $this->showAddToCartButton($result['product_id']); //TODO, put this button in prettier location on the page
        } else {
            echo '<div class="center"><p>Cannot find product</p></div>';
        }
    }
}
