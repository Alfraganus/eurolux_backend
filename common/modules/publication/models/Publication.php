<?php

namespace common\modules\publication\models;

use common\modules\category\models\Category;
use common\modules\category\models\SubCategory;
use common\modules\publication\models\scopes\PublicationQuery;
use common\modules\users\models\Users;
use Yii;

/**
 * This is the models class for table "publication".
 *
 * @property int $id
 * @property int $category_id
 * @property int $user_id
 * @property int $sub_category_id
 * @property string|null $link_video
 * @property string $title
 * @property string $description
 * @property float $price
 * @property string $location
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int|null $tariff_id
 * @property int $is_mutually_surcharged
 * @property int|null $is_active
 *
 * @property Category $category
// * @property Distance $distance
 * @property PublicationExchangeCategory[] $publicationExchangeCategories
 * @property PublicationImages[] $publicationImages
 * @property PublicationReactions[] $publicationReactions
 * @property PublicationTag[] $publicationTags
 * @property SubCategory $subCategory
 * @property PublicationTariff $tariff
 */
class Publication extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'publication';
    }

    public $images;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'sub_category_id', 'title',  'price'], 'required'],
            [['category_id', 'sub_category_id', 'tariff_id', 'is_mutually_surcharged', 'is_active','user_id'], 'integer'],
            [['description'], 'string'],
            [['distance'], 'safe'],
            [['price', 'latitude', 'longitude'], 'number'],
            [['link_video'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 500],
            [['images'], 'file',  'extensions' => 'png, jpg', 'maxFiles' => 4],
            [['location'], 'string', 'max' => 300],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['sub_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubCategory::class, 'targetAttribute' => ['sub_category_id' => 'id']],
            [['tariff_id'], 'exist', 'skipOnError' => true, 'targetClass' => PublicationTariff::class, 'targetAttribute' => ['tariff_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }


    public function upload($images)
    {
        foreach ($images as $file) {
            $file->saveAs('../../storage/web/upload/' . $file->baseName . '.' . $file->extension);
        }
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'sub_category_id' => 'Sub Category ID',
            'link_video' => 'Link Video',
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
            'location' => 'Location',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'tariff_id' => 'Tariff ID',
            'is_mutually_surcharged' => 'Is Mutually Surcharged',
            'is_active' => 'Is Active',
        ];
    }

    public function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km') {
        $theta = $longitude1 - $longitude2;
        $distance = sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta));

        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;

        switch($unit)
        {
            case 'Mi': break;
            case 'Km' : $distance = $distance * 1.609344;
        }

        return (round($distance,2));
    }



    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|CategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[PublicationExchangeCategories]].
     *
     * @return \yii\db\ActiveQuery|PublicationExchangeCategoryQuery
     */
    public function getPublicationExchangeCategories()
    {
        return $this->hasMany(PublicationExchangeCategory::class, ['publication_id' => 'id']);
    }

    /**
     * Gets query for [[PublicationImages]].
     *
     * @return \yii\db\ActiveQuery|PublicationImagesQuery
     */
    public function getPublicationImages()
    {
        return $this->hasMany(PublicationImages::class, ['publication_id' => 'id']);
    }

    /**
     * Gets query for [[PublicationReactions]].
     *
     * @return \yii\db\ActiveQuery|PublicationReactionsQuery
     */
    public function getPublicationReactions()
    {
        return $this->hasMany(PublicationReactions::class, ['publication_id' => 'id']);
    }

    /**
     * Gets query for [[PublicationTags]].
     *
     * @return \yii\db\ActiveQuery|PublicationTagQuery
     */
    public function getPublicationTags()
    {
        return $this->hasMany(PublicationTag::class, ['publication_id' => 'id']);
    }

    /**
     * Gets query for [[SubCategory]].
     *
     * @return \yii\db\ActiveQuery|SubCategoryQuery
     */
    public function getSubCategory()
    {
        return $this->hasOne(SubCategory::class, ['id' => 'sub_category_id']);
    }

    /**
     * Gets query for [[Tariff]].
     *
     * @return \yii\db\ActiveQuery|PublicationTariffQuery
     */
    public function getTariff()
    {
        return $this->hasOne(PublicationTariff::class, ['id' => 'tariff_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
    /**
     * {@inheritdoc}
     * @return PublicationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PublicationQuery(get_called_class());
    }
}
