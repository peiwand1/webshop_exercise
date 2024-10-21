<?php

class StarRating
{
    public function __construct()
    {
    }

    public function showStarRatingNonInteractable($productID): void
    {
        $starStr = $this->getStars($productID);

        $rating = ModelManager::getShopModel()->getAvgRating($productID);
        $ratingWidth = ($rating / 5.0) * 100.0;

        $starStr = str_replace(
            'style="width:0%"',
            'style="width:' . $ratingWidth . '%"',
            $starStr
        );
        $starStr = str_replace(
            'class="star fa',
            'class="fa',
            $starStr
        );

        echo $starStr;
        echo '<div><p>Avg: ' . number_format($rating, 1, '.', '') . '</p></div>';
        echo '</span>';    }

    public function showStarRatingInteractable($productID): void
    {
        $starStr = $this->getStars($productID);

        // if get user rating exists, show that in blue stars
        $userRating = ModelManager::getShopModel()->getUserRating($productID, $_SESSION['user_id']);
        $rating = ModelManager::getShopModel()->getAvgRating($productID);
        $ratingWidth = 0;

        if ($userRating) {
            $ratingWidth = $userRating * 20;

            $starStr = str_replace(
                'class="star fa fa-star',
                'class="voted star fa fa-star',
                $starStr
            );
        } else {
            $ratingWidth = ($rating / 5.0) * 100.0;
        }

        $starStr = str_replace(
            'style="width:0%"',
            'style="width:' . $ratingWidth . '%"',
            $starStr
        );

        echo $starStr;
        echo '<div><p>Avg: ' . number_format($rating, 1, '.', '') . '</p></div>';
        echo '</span>';
    }

    private function getStars($productID): string
    {
        return '<span class="score" id="' . $productID . '">
            <div class="score-wrap">
                <span class="stars-active" style="width:0%">
                    <i class="star fa fa-star" value="1"></i>
                    <i class="star fa fa-star" value="2"></i>
                    <i class="star fa fa-star" value="3"></i>
                    <i class="star fa fa-star" value="4"></i>
                    <i class="star fa fa-star" value="5"></i>
                </span>
                <span class="stars-inactive">
                    <i class="star fa fa-star-o" value="1"></i>
                    <i class="star fa fa-star-o" value="2"></i>
                    <i class="star fa fa-star-o" value="3"></i>
                    <i class="star fa fa-star-o" value="4"></i>
                    <i class="star fa fa-star-o" value="5"></i>
                </span>
            </div>';
    }
}
