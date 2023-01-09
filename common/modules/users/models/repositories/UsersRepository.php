<?php
namespace common\modules\users\models\repositories;

use chulakov\model\exceptions\NotFoundModelException;
use chulakov\model\repositories\Repository;
use common\modules\users\models\Users;

class UsersRepository extends Repository
{
    public function query()
    {
        return Users::find();
    }

    /**
     * Поиск модели по заданному идентификатору
     *
     * @param $id
     *
     * @return array|Users|null|\yii\db\ActiveRecord
     * @throws NotFoundModelException
     */
    public function get($id)
    {
        if ($model = Users::find()->findById($id)->one())
            return $model;
        throw new NotFoundModelException("Запрашиваемый  пользователь не найден");
    }

//    /**
//     * Поиск модели по заданному идентификатору
//     *
//     * @param $id
//     * @return array|\common\modules\users\models\scopes\CustomerQuery|\yii\db\ActiveRecord
//     */
//    public function findOne($id)
//    {
//        return Users::find()->findById($id)->one();
//    }

    /**
     * Создание модели
     *
     * @return Users
     */
    public function create() {
        return new Users();
    }

//    /**
//     * Сохранение модели
//     *
//     * @param $model
//     * @return mixed
//     */
//    public function save($model) {
//        return $model->save();
//    }

//    /**
//     * Удаление модели
//     *
//     * @param $model
//     * @return mixed
//     */
//    public function delete($model) {
//        return $model->delete();
//    }
}