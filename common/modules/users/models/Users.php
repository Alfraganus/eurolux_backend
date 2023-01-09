<?php

namespace common\modules\users\models;

use common\modules\users\models\scopes\CustomerQuery;
use common\modules\users\models\scopes\UsersQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Модель пользователей
 *
 * @property int $id
 * @property int $is_active Активность
 * @property string $name
 * @property string $phone
 * @property int|null $created_at Дата создания
 * @property int|null $updated_at Дата обновления
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $email
 * @property double|null $latitude
 * @property double|null $longitude
 * @property integer|null $search_radius
 * @property int|null $city_id
 * @property int|null $region_id
 * @property int|null $country_id
 */
class Users extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    const SCENARIO_UPDATE = 'update';
    const SCENARIO_REGISTRATION = 'registerUserFirstTime';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'created_at', 'updated_at', 'created_by', 'updated_by', 'city_id', 'region_id', 'country_id','search_radius'], 'integer'],
            ['phone', 'required','on' => self::SCENARIO_REGISTRATION],
            ['name', 'required','on' => self::SCENARIO_UPDATE],
            [['name', 'phone'], 'string', 'max' => 255],
            [[ 'latitude','longitude'], 'safe'],
            [[ 'email'], 'email'],
            [[ 'email'], 'unique'],
            [[ 'phone'], 'unique'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\users\models\scopes\CustomerQuery.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\users\models\scopes\CustomerQuery.
     */
    public static function findByPhone($phone)
    {
        return static::find()
            ->findByPhone($phone)
            ->one();
    }

    /**
     * Gets query for [[UserTokens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserTokens()
    {
        return $this->hasMany(UserToken::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserTokens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistanceRange($lat, $lon)
    {

        return $result;
    }

}
