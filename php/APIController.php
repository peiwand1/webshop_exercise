<?php
require_once 'php/models/ModelManager.php';

class APIController
{
    public function __construct()
    {
    }

    public function handleRequest(): void
    {
        if ($this->getRequestVar('action', '') !== 'api') return;
        
        $requestType = $this->getRequestVar('type', '');
        switch ($this->getRequestVar('case', '')) {
            case "get_all_items":
                $items = ModelManager::getShopModel()->getAllItems();
                $this->handleRequestType($requestType, $items);
                break;
            case "get_item":
                // set single product at index 0 so the array has the same structure as when getting multiple products
                $items[0] = ModelManager::getShopModel()->getFullItemDescription($this->getRequestVar('id', ''));
                $this->handleRequestType($requestType, $items);
                break;
        }
    }

    private function getRequestVar(string $varname, string $default): string
    {
        $result = filter_input(
            INPUT_GET,
            $varname,
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
        return (is_null($result) || $result === false) ? $default : $result;
    }

    // XML BUILD RECURSIVE FUNCTION, source: https://stackoverflow.com/questions/1397036/how-to-convert-array-to-simplexml
    function array_to_xml($data, &$xml_data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item'; //dealing with <0/>..<n/> issues
                }
                $subnode = $xml_data->addChild($key);
                $this->array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild($key, htmlspecialchars($value));
            }
        }
    }

    private function handleRequestType(string $requestType, array $item)
    {
        if ($requestType == 'json') {
            header('Content-Type: application/json');

            echo json_encode($item);
        } else if ($requestType == 'xml') {
            header('Content-Type: application/xml');

            $itemsAsXML = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
            $this->array_to_xml($item, $itemsAsXML);

            echo $itemsAsXML->asXML();
        } else if ($requestType == 'html') {
            header('Content-Type: text/html');

            foreach ($item as $productData) {
                print_r($productData);
                $this->productInfoAsHTML($productData);
            }
        }
    }

    private function productInfoAsHTML($productData)
    {
        echo '<div class="item">
                <img class="item-img" src="images/products/' . $productData['product_id'] . '/' . $productData['image_path'] . '" alt="' . $productData['image_alt_text'] . '">
                <div>
                    <p class="item-name">' . $productData['name'] . '</p>
                    <p class="item-price">€' . $productData['price'] . '</p>
                    <p class="availability">' . ($productData['available'] ? 'Available' : 'Unavailable') . '</p>
                </div>
            </div>';
    }
}
