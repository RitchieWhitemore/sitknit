<?php

use yii\db\Migration;

/**
 * Class m190304_064707_alter_table_composition
 */
class m190304_064707_alter_table_composition extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('composition', 'name', $this->string(50)->notNull());
        $this->alterColumn('composition', 'active', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190304_064707_alter_table_composition cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190304_064707_alter_table_composition cannot be reverted.\n";

        return false;
    }
    */
}
