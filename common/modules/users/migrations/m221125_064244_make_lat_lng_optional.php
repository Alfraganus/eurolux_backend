<?php

namespace common\modules\users\migrations;

use yii\db\Migration;

/**
 * Class m221125_064244_make_lat_lng_optional
 */
class m221125_064244_make_lat_lng_optional extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('users', 'is_active', $this->integer()->null());
        $this->alterColumn('users', 'name', $this->string(255)->null());
        $this->alterColumn('users', 'latitude', $this->double()->null());
        $this->alterColumn('users', 'latitude', $this->double()->null());
        $this->alterColumn('users', 'longitude', $this->double()->null());
        $this->alterColumn('users', 'search_radius', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('users', 'latitude', $this->double()->null());
        $this->alterColumn('users', 'longitude', $this->double()->null());
        $this->alterColumn('users', 'search_radius', $this->integer()->null());
    }
}
