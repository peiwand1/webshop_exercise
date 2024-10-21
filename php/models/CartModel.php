<?php
require_once 'php/models/BaseModel.php';

class CartModel extends BaseModel
{
    public function getCartItemInfo(array $products): array|false
    {
        if (empty($products)) return array();

        $items = array_keys($products);
        $sql = "SELECT product_id, name, price, image_path, image_alt_text 
                FROM product 
                WHERE product_id IN (";

        // for each product in cart, add a placeholder '?'
        for ($i = 0; $i < count($items) - 1; $i++) {
            $sql .= '?,';
        }
        $sql .= '?)';

        $rows = DatabaseCrud::getInstance()->selectMany($sql, $items);

        return $rows;
    }


    // handles the creation of records for ordering products
    public function purchaseItems($currentCart, $userID): int|bool
    {
        // check for empty cart
        if (count($currentCart) == 0) {
            return false;
        }

        DatabaseCrud::getInstance()->beginTransaction();
        $sql = "INSERT INTO sales_order (user_id) 
                VALUES (:userID)";
        $params = ['userID' => $userID];
        $result = DatabaseCrud::getInstance()->doInsert($sql, $params);

        if ($result) {
            foreach ($currentCart as $productID => $itemAmount) {
                $sql = "INSERT INTO sales_order_item (order_id, product_id, amount) 
                VALUES (:order_id, :product_id, :amount);";
                $params = [
                    'order_id' => $result,
                    'product_id' => $productID,
                    'amount' => $itemAmount
                ];

                $success = DatabaseCrud::getInstance()->doInsert($sql, $params);

                if (!$success) {
                    DatabaseCrud::getInstance()->rollback();
                    return false;
                }
            }
        }

        DatabaseCrud::getInstance()->commit();

        return $result;
    }
}
