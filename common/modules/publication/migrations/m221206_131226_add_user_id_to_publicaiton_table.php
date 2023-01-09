<?php

namespace common\modules\publication\migrations;

use yii\db\Migration;

/**
 * Class m221206_131226_add_user_id_to_publicaiton_table
 */
class m221206_131226_add_user_id_to_publicaiton_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('publication', 'user_id', $this->integer());
        $this->addForeignKey(
            'user_id_to_publication-foreign-key',
            'publication',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('publication', 'user_id');
    }

}
