<?php

namespace common\modules\users\migrations;

use yii\db\Migration;

/**
 * Class m221107_122546_change_token_column_in_users_table
 */
class m221107_122546_change_token_column_in_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('user_token','token','auth_key');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->renameColumn('user_token','auth_key','token');
    }


}
