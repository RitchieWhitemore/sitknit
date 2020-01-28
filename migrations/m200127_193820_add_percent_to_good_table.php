<?php

use yii\db\Migration;

/**
 * Class m200127_193820_add_percent_to_good_table
 */
class m200127_193820_add_percent_to_good_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('good', 'percent', $this->smallInteger(2)->null()->defaultValue(0)->after('description'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('good', 'percent');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200127_193820_add_percent_to_good_table cannot be reverted.\n";

        return false;
    }
    */
}
