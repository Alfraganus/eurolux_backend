<?php

namespace common\modules\publication\migrations;

use yii\db\Migration;

/**
 * Class m221114_093125_add_publication_table
 */
class m221114_093125_add_publication_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('publication', [
            'id' => $this->primaryKey(),
            'category_id'=> $this->integer()->notNull(),
            'sub_category_id'=> $this->integer()->notNull(),
            'link_video'=> $this->string()->null(),
            'title'=>$this->string(500)->notNull(),
            'description'=>$this->text()->notNull(),
            'price'=>$this->float()->notNull(),
            'location'=>$this->string(300)->notNull(),
            'latitude'=> $this->decimal(),
            'longitude'=>$this->decimal(),
            'tariff_id'=>$this->integer()->null(),
            'is_mutually_surcharged'=>$this->tinyInteger()->notNull(),
            'is_active'=>$this->tinyInteger()->null(),
        ]);

        $this->createTable('publication_images', [
            'id' => $this->primaryKey(),
            'publication_id'=> $this->integer()->notNull(),
            'is_main_image'=> $this->integer()->null(),
            'image'=> $this->string(500)->notNull(),
        ]);

        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'name'=> $this->string(500)->notNull(),
        ]);

        $this->createTable('publication_tag', [
            'id' => $this->primaryKey(),
            'publication_id'=> $this->integer()->notNull(),
            'tag_id'=> $this->integer()->notNull(),
        ]);

        $this->createTable('publication_tariff', [
            'id' => $this->primaryKey(),
            'quantity_days'=> $this->integer()->null(),
            'price'=> $this->float()->null(),
            'start_date'=>$this->integer()->null(),
            'end_date'=>$this->integer()->null(),
            'is_free'=> $this->float()->null(),
            'is_active'=>$this->tinyInteger()->null(),
        ]);

        $this->createTable('publication_reactions', [
            'id' => $this->primaryKey(),
            'publication_id'=> $this->integer()->notNull(),
            'user_id'=> $this->integer()->notNull(),
            'reaction_type'=> $this->integer()->notNull(),
        ]);

        $this->createTable('publication_exchange_category', [
            'id' => $this->primaryKey(),
            'publication_id'=> $this->integer()->notNull(),
            'reaction_type'=> $this->integer()->null(),
            'category_id'=> $this->integer()->null(),
            'sub_category_id'=> $this->integer()->null(),
        ]);

        $this->createIndex(
            'idx-publication-category_id',
            'publication',
            ['category_id','sub_category_id','tariff_id']
        );

        $this->addForeignKey(
            'fk-publication-category_id',
            'publication',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-publication-sub_category_id',
            'publication',
            'sub_category_id',
            'sub_category',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-publication-tariff_id',
            'publication',
            'tariff_id',
            'publication_tariff',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-publication-images',
            'publication_images',
            'publication_id',
            'publication',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-publication-publication_tag',
            'publication_tag',
            'publication_id',
            'publication',
            'id',
            'CASCADE'
        );


        $this->addForeignKey(
            'fk-publication-publication_exchange_category',
            'publication_exchange_category',
            'publication_id',
            'publication',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-publication-publication_reactions',
            'publication_reactions',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-publication-publication_reactions_add',
            'publication_reactions',
            'publication_id',
            'publication',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-publication-publication_exchange_category_category',
            'publication_exchange_category',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-publication-publication_exchange_sub_category',
            'publication_exchange_category',
            'sub_category_id',
            'sub_category',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-publication-publication_tag_id',
            'publication_tag',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-publication-category_id',
            'publication'
        );

        $this->dropForeignKey(
            'fk-publication-sub_category_id',
            'publication'
        );

        $this->dropForeignKey(
            'fk-publication-tariff_id',
            'publication'
        );

        $this->dropForeignKey(
            'fk-publication-images',
            'publication_images'
        );

        $this->dropForeignKey(
            'fk-publication-publication_tag',
            'publication_tag'
        );

        $this->dropForeignKey(
            'fk-publication-publication_exchange_category',
            'publication_exchange_category'

        );

        $this->dropForeignKey(
            'fk-publication-publication_reactions',
            'publication_reactions'
        );

        $this->dropForeignKey(
            'fk-publication-publication_reactions_add',
            'publication_reactions'
        );

        $this->dropForeignKey(
            'fk-publication-publication_exchange_category_category',
            'publication_exchange_category'
        );

        $this->dropForeignKey(
            'fk-publication-publication_exchange_sub_category',
            'publication_exchange_category'
        );

        $this->dropForeignKey(
            'fk-publication-publication_tag_id',
            'publication_tag'
        );

        $this->dropTable('publication');
        $this->dropTable('publication_images');
        $this->dropTable('publication_tag');
        $this->dropTable('tag');
        $this->dropTable('publication_tariff');
        $this->dropTable('publication_reactions');
        $this->dropTable('publication_exchange_category');
    }


}
