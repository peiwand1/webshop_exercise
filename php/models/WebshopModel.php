<?php
require_once 'php/models/BaseModel.php';

class WebshopModel extends BaseModel
{
    public function getShopItems(): array|false
    {
        // get 10 latest available products
        $sql = "(SELECT product_id, name, price, image_path, image_alt_text FROM product 
                WHERE available != 0 
                ORDER BY product_id DESC 
                LIMIT 10) 
                ORDER BY product_id ASC";
        $rows = DatabaseCrud::getInstance()->selectMany($sql);

        return $rows;
    }

    public function getFullItemDescription(string $productID): array|false
    {
        $sql = "SELECT * FROM product WHERE product_id = :product";
        $param = ['product' => $productID];
        $item = DatabaseCrud::getInstance()->selectOne($sql, $param);

        return $item;
    }

    public function getAllItems(): array|false
    {
        $sql = "SELECT * FROM product";
        $rows = DatabaseCrud::getInstance()->selectMany($sql);

        return $rows;
    }


    // inserts new rating into table, or updates if the user already gave that product a rating
    public function giveRating(string $productID, string $userID, string $rating): bool
    {
        // if rating is out of valid range, don't process request
        if (!$this->checkValidRating($rating)) {
            return false;
        }

        // if rating is same as existing, remove rating
        $prevRating = $this->getUserRating($productID, $userID);
        $success = false;

        if ($prevRating == $rating) {
            $sql = "DELETE FROM product_rating
                    WHERE product_id = :product_id AND user_id = :user_id";
            $param = [
                'product_id' => $productID,
                'user_id' => $userID,
            ];
            $success = DatabaseCrud::getInstance()->doDelete($sql, $param);
        } else {
            $sql = "INSERT INTO product_rating(product_id, user_id, rating)
                    VALUES (:product_id, :user_id, :rating)
                    ON DUPLICATE KEY
                    UPDATE rating = :rating";
            $param = [
                'product_id' => $productID,
                'user_id' => $userID,
                'rating' => $rating
            ];
            $success = DatabaseCrud::getInstance()->doInsert($sql, $param);
        }
        return $success;
    }

    private function checkValidRating(string $rating): bool
    {
        return ($rating >= 1 && $rating <= 5);
    }

    public function getAvgRating(string $productID): float|false
    {
        $sql = "SELECT IFNULL(AVG(rating), 0) AS rating
                FROM product_rating
                WHERE product_id = :product_id";
        $param = ['product_id' => $productID];
        $item = DatabaseCrud::getInstance()->selectOne($sql, $param);

        return $item ? $item['rating'] : false;
    }

    public function getUserRating(string $productID, string $userID): int|false
    {
        $sql = "SELECT rating
                FROM product_rating
                WHERE product_id = :product_id AND user_id = :user_id";
        $param = [
            'product_id' => $productID,
            'user_id' => $userID
        ];
        $item = DatabaseCrud::getInstance()->selectOne($sql, $param);

        return $item ? $item['rating'] : false;
    }
}
