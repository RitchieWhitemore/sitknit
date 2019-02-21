<?php

use yii\db\Migration;

/**
 * Class m190221_110109_create_table_order
 */
class m190221_110109_create_table_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'date' => $this->dateTime()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'payment' => $this->smallInteger()->notNull()->defaultValue(0),
            'partner_id' => $this->integer(),
            'total' => $this->float(2),
        ]);

        $this->createIndex('idx-order-partner_id', 'order', 'partner_id');

        $this->addForeignKey('fk-order-partner_id', 'order', 'partner_id', 'partner', 'id', 'SET NULL', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-order-partner_id', 'order');

        $this->dropIndex('idx-order-partner_id', 'order');

        $this->dropTable('order');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190221_110109_create_table_order cannot be reverted.\n";

        return false;
    }
    */
}
