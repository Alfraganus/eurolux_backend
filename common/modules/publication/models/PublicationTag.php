<?php

namespace common\modules\publication\models;

use Yii;

/**
 * This is the model class for table "publication_tag".
 *
 * @property int $id
 * @property int $publication_id
 * @property int $tag_id
 *
 * @property Publication $publication
 * @property Tag $tag
 */
class PublicationTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'publication_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['publication_id', 'tag_id'], 'required'],
            [['publication_id', 'tag_id'], 'integer'],
            [['publication_id'], 'exist', 'skipOnError' => true, 'targetClass' => Publication::class, 'targetAttribute' => ['publication_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::class, 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'publication_id' => 'Publication ID',
            'tag_id' => 'Tag ID',
        ];
    }

    /**
     * Gets query for [[Publication]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\publication\models\scopes\PublicationQuery
     */
    public function getPublication()
    {
        return $this->hasOne(Publication::class, ['id' => 'publication_id']);
    }

    /**
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\publication\models\scopes\TagQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\publication\models\scopes\PublicationTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\publication\models\scopes\PublicationTagQuery(get_called_class());
    }
}
