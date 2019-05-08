<?php

use yii\db\Migration;

/**
 * Class m190506_085417_alter_active_field_in_good_table
 */
class m190506_085417_alter_active_field_in_good_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%good}}', 'active', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%good}}', 'status', 'active');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190506_085417_alter_active_field_in_good_table cannot be reverted.\n";

        return false;
    }
    */
}
