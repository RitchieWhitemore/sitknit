<?php

use yii\db\Migration;

/**
 * Class m190814_114918_add_type_field_to_order_table
 */
class m190814_114918_add_type_field_to_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'type', $this->smallInteger()->notNull()->defaultValue(0)->after('date'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190814_114918_add_type_field_to_order_table cannot be reverted.\n";

        return false;
    }
    */
}
