<?php

namespace common\modules\publication\models;

use Yii;

/**
 * This is the model class for table "publication_images".
 *
 * @property int $id
 * @property int $publication_id
 * @property int|null $is_main_image
 * @property string $image
 *
 * @property Publication $publication
 */
class PublicationImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'publication_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['publication_id', 'image'], 'required'],
            [['publication_id', 'is_main_image'], 'integer'],
            [['image'], 'string', 'max' => 500],
            [['publication_id'], 'exist', 'skipOnError' => true, 'targetClass' => Publication::class, 'targetAttribute' => ['publication_id' => 'id']],
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
            'is_main_image' => 'Is Main Image',
            'image' => 'Image',
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
     * {@inheritdoc}
     * @return \common\modules\publication\models\scopes\PublicationImagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\publication\models\scopes\PublicationImagesQuery(get_called_class());
    }
}
