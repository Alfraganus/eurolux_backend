<?php

namespace common\modules\control\actions\update;

class UpdateRelationActionWithParent extends UpdateRelationAction
{
    protected function createForm($parent, $model)
    {
        return new $this->formClass($parent, $model);
    }
}
