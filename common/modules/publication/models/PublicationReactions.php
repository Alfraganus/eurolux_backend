<?php

namespace common\modules\publication\models;

use Yii;

/**
 * This is the model class for table "publication_reactions".
 *
 * @property int $id
 * @property int $publication_id
 * @property int $user_id
 * @property int $reaction_type
 *
 * @property Publication $publication
 * @property Users $user
 */
class PublicationReactions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'publication_reactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['publication_id', 'user_id', 'reaction_type'], 'required'],
            [['publication_id', 'user_id', 'reaction_type'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'reaction_type' => 'Reaction Type',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\publication\models\scopes\UsersQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\publication\models\scopes\PublicationReactionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\publication\models\scopes\PublicationReactionsQuery(get_called_class());
    }
}
