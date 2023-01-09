<?php

namespace common\modules\users\migrations;

use yii\db\Migration;

/**
 * Миграция токенов авторизации.
 * Требуется только при наличии требования к авторизации на нескольких устройствах.
 *
 * ./yii migrate/up --migrationPath='@common/modules/users/migrations'
 */
class m221101_135413_create_user_auth_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%user_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'token' => $this->string(64)->notNull(),
            'ip_address' => $this->string(16),
            'user_agent' => $this->string(),
            'expired_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex(
            'token-index',
            'user_token',
            'token'
        );

        $this->addForeignKey(
            'user_token-foreign-key',
            'user_token',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'user_token-foreign-key',
            'user_token'
        );
        $this->dropTable('{{%user_token}}');
    }
}
