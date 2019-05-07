<?php

use yii\db\Migration;

/**
 * Class m190506_115508_rename_active_field_in_brand_table
 */
class m190506_115508_rename_active_field_in_brand_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%brand}}', 'active', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%brand}}', 'status', 'active');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190506_115508_rename_active_field_in_brand_table cannot be reverted.\n";

        return false;
    }
    */
}
