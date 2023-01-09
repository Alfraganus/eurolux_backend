<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%media_assets}}`.
 */
class m221204_114855_create_media_assets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%media_asset}}', [
            'id' => $this->primaryKey(),
            'model_class'=>$this->string('100')->null(),
            'source_table'=>$this->string('50')->notNull(),
            'object_id'=>$this->integer()->notNull(),
            'asset_name'=>$this->string(255)->notNull(),
            'asset_extension'=>$this->string('20')->null(),
            'asset_path'=>$this->string(255)->null(),
            'asset_mime'=>$this->string(50)->null(),
            'asset_size'=>$this->double()->null()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%media_asset}}');
    }
}
