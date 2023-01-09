<?php

namespace common\modules\category\migrations;

use common\solutions\controllers\Migration;

class m221102_140450_create_category_and_sub_category_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull()->unique()->comment('Символьный код'),
            'is_active' => $this->boolean()->notNull()->defaultValue(1)->comment('Активность'),
            'title' => $this->string()->notNull()->comment('Название категории'),
            'description' => $this->string()->notNull()->comment('Описание'),
            'created_at' => $this->integer()->comment('Дата создания'),
            'updated_at' => $this->integer()->comment('Дата обновления'),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createTable('{{%sub_category}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'slug' => $this->string()->notNull()->unique()->comment('Символьный код'),
            'is_active' => $this->boolean()->notNull()->defaultValue(1)->comment('Активность'),
            'title' => $this->string()->notNull()->comment('Название подкатегории'),
            'description' => $this->string()->notNull()->comment('Описание'),
            'created_at' => $this->integer()->comment('Дата создания'),
            'updated_at' => $this->integer()->comment('Дата обновления'),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->addForeignKey('fk-sub_category-category', '{{%sub_category}}', 'category_id', '{{%category}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-sub_category-category', '{{%sub_category}}');
        $this->dropTable('{{%sub_category}}');
        $this->dropTable('{{%category}}');
    }
}