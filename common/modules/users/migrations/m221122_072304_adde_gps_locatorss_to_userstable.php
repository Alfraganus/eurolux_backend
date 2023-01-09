<?php

namespace common\modules\users\migrations;

use yii\db\Migration;

/**
 * Class m221122_072304_adde_gps_locatorss_to_userstable
 */
class m221122_072304_adde_gps_locatorss_to_userstable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'latitude', $this->double()->notNull());
        $this->addColumn('users', 'longitude', $this->double()->notNull());
        $this->addColumn('users', 'search_radius', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'latitude');
        $this->dropColumn('users', 'longitude');
        $this->dropColumn('users', 'search_radius');
    }
}
