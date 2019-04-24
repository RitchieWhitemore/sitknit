<?php

use yii\db\Migration;

/**
 * Class m190424_062228_alter_table_receipt_item
 */
class m190424_062228_alter_table_receipt_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('receipt_item');

        $this->createTable('receipt_item', [
            'receipt_id' => $this->integer()->notNull(),
            'good_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
            'price' => $this->float(2)->notNull(),
        ]);

        $this->addPrimaryKey('pk-receipt_id-good_id', 'receipt_item', ['receipt_id', 'good_id']);

        $this->createIndex('idx-receipt_item-receipt_id', 'receipt_item', 'receipt_id');
        $this->createIndex('idx-receipt_item-good_id', 'receipt_item', 'good_id');

        $this->addForeignKey('fk-receipt_item-receipt_id', 'receipt_item', 'receipt_id', 'receipt', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-receipt_item-good_id', 'receipt_item', 'good_id', 'good', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-receipt_item-good_id', 'receipt_item');
        $this->dropForeignKey('fk-receipt_item-receipt_id', 'receipt_item');

        $this->dropIndex('idx-receipt_item-good_id', 'receipt_item');
        $this->dropIndex('idx-receipt_item-receipt_id', 'receipt_item');

        $this->dropTable('receipt_item');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190424_062228_alter_table_receipt_item cannot be reverted.\n";

        return false;
    }
    */
}
