<?php

namespace common\modules\publication\models\scopes;

/**
 * This is the ActiveQuery class for [[\common\modules\publication\models\PublicationTag]].
 *
 * @see \common\modules\publication\models\PublicationTag
 */
class PublicationTagQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\modules\publication\models\PublicationTag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\publication\models\PublicationTag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
