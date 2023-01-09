<?php

namespace common\modules\publication\models;

use Yii;

/**
 * This is the model class for table "publication_tariff".
 *
 * @property int $id
 * @property int|null $quantity_days
 * @property float|null $price
 * @property int|null $start_date
 * @property int|null $end_date
 * @property float|null $is_free
 * @property int|null $is_active
 *
 * @property Publication[] $publications
 */
class PublicationTariff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'publication_tariff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantity_days', 'start_date', 'end_date', 'is_active'], 'integer'],
            [['price', 'is_free'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quantity_days' => 'Quantity Days',
            'price' => 'Price',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'is_free' => 'Is Free',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * Gets query for [[Publications]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\publication\models\scopes\PublicationQuery
     */
    public function getPublications()
    {
        return $this->hasMany(Publication::class, ['tariff_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\publication\models\scopes\PublicationTariffQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\publication\models\scopes\PublicationTariffQuery(get_called_class());
    }
}
