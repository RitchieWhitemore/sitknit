<?php

use yii\db\Migration;

/**
 * Class m190810_083939_add_date_start_purchase_to_receipt_table
 */
class m190810_083939_create_purchase_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%purchase}}', [
            'id' => $this->primaryKey(),
            'date_start' => $this->date()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%purchase}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190523_083939_alter_order_item_table cannot be reverted.\n";

        return false;
    }
    */
}
