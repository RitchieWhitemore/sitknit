<?php

use yii\db\Migration;

/**
 * Class m190424_073120_alter_table_order_item
 */
class m190424_073120_alter_table_order_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('order_item');

        $this->createTable('order_item', [
            'order_id' => $this->integer()->notNull(),
            'good_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
            'price' => $this->float(2)->notNull(),
        ]);

        $this->addPrimaryKey('pk-order_id-good_id', 'order_item', ['order_id', 'good_id']);

        $this->createIndex('idx-order_item-order_id', 'order_item', 'order_id');
        $this->createIndex('idx-order_item-good_id', 'order_item', 'good_id');

        $this->addForeignKey('fk-order_item-order_id', 'order_item', 'order_id', 'order', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-order_item-good_id', 'order_item', 'good_id', 'good', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-order_item-good_id', 'order_item');
        $this->dropForeignKey('fk-order_item-order_id', 'order_item');

        $this->dropIndex('idx-order_item-good_id', 'order_item');
        $this->dropIndex('idx-order_item-order_id', 'order_item');

        $this->dropTable('order_item');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190424_073120_alter_table_order_item cannot be reverted.\n";

        return false;
    }
    */
}
