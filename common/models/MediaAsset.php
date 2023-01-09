<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "media_asset".
 *
 * @property int $id
 * @property string|null $model_class
 * @property string $source_table
 * @property int $object_id
 * @property string $asset_name
 * @property string|null $asset_extension
 * @property string|null $asset_path
 * @property string|null $asset_mime
 * @property float|null $asset_size
 */
class MediaAsset extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_asset';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source_table', 'object_id', 'asset_name'], 'required'],
            [['object_id'], 'integer'],
            [['asset_size'], 'number'],
            [['model_class'], 'string', 'max' => 100],
            [['source_table', 'asset_mime'], 'string', 'max' => 50],
            [['asset_name', 'asset_path'], 'string', 'max' => 255],
            [['asset_extension'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_class' => 'Model Class',
            'source_table' => 'Source Table',
            'object_id' => 'Object ID',
            'asset_name' => 'Asset Name',
            'asset_extension' => 'Asset Extension',
            'asset_path' => 'Asset Path',
            'asset_mime' => 'Asset Mime',
            'asset_size' => 'Asset Size',
        ];
    }
}
