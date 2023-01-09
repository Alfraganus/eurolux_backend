<?php

namespace common\modules\publication\models\providers;

use common\modules\publication\models\PublicationExchangeCategory;

class PublicationExchangeCategoryProvider extends PublicationExchangeCategory
{
    public function fields()
    {
        return [
            'category' =>function() {
                return $this->category->title;
            },
            'sub_category' =>function() {
                return $this->subCategory->title;
            },
        ];
    }
}
