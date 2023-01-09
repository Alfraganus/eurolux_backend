<?php

namespace common\modules\users\migrations;

use yii\db\Migration;

class m221012_134658_create_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->notNull()->defaultValue(1)->comment('Активность'),
            'name' => $this->string()->notNull()->comment('Имя пользователя'),
            'phone' => $this->string()->notNull()->comment('Номер телефона'),
            'created_at' => $this->integer()->comment('Дата создания'),
            'updated_at' => $this->integer()->comment('Дата обновления'),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer}}');
    }
}
