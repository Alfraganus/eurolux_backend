<?php

namespace common\modules\users\migrations;

use yii\db\Migration;

class m221101_092408_rename_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('customer','users');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('users','customer');
    }
}
