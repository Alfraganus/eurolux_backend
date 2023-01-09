<?php

namespace common\modules\users\migrations;

use yii\db\Migration;

/**
 * Class m221107_054650_add_additional_info_tu_users_tabe
 */
class m221107_054650_add_additional_info_tu_users_tabe extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'email', $this->string(50)->null());
        $this->addColumn('users', 'city_id', $this->integer()->null());
        $this->addColumn('users', 'region_id', $this->integer()->null());
        $this->addColumn('users', 'country_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'email');
        $this->dropColumn('users', 'city_id');
        $this->dropColumn('users', 'region_id');
        $this->dropColumn('users', 'country_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221107_054650_add_additional_info_tu_users_tabe cannot be reverted.\n";

        return false;
    }
    */
}
