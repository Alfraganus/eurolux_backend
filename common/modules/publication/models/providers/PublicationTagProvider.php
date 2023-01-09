<?php

namespace common\modules\publication\models\providers;

use common\modules\publication\models\PublicationTag;

class PublicationTagProvider extends PublicationTag
{
    public function fields()
    {
        return [
            'tag_id' =>function() {
                return $this->tag->name;
            },
        ];
    }
}
