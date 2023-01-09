<?php

namespace common\modules\control\actions\create;

class CreateRelationActionWithParent extends CreateRelationAction
{
    protected function createForm($parent)
    {
        return new $this->formClass($parent);
    }
}
