<?php

use yii\db\Migration;

/**
 * Class m190103_101659_add_column_in_good_table
 */
class m190103_101659_add_column_active_in_good_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('good', 'active', $this->tinyInteger(1)->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('good', 'active');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190103_101659_add_column_in_good_table cannot be reverted.\n";

        return false;
    }
    */
}
