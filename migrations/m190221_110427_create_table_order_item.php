<?php

use yii\db\Migration;

/**
 * Class m190221_110427_create_table_order_item
 */
class m190221_110427_create_table_order_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order_item', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'good_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
            'price' => $this->float(2)->notNull(),
        ]);

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
        echo "m190221_110427_create_table_order_item cannot be reverted.\n";

        return false;
    }
    */
}
