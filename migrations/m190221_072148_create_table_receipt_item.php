<?php

use yii\db\Migration;

/**
 * Class m190221_072148_cteate_table_document_item
 */
class m190221_072148_create_table_receipt_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('receipt_item', [
            'id' => $this->primaryKey(),
            'receipt_id' => $this->integer()->notNull(),
            'good_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
            'price' => $this->float(2)->notNull(),
        ]);

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
        echo "m190221_072148_cteate_table_document_item cannot be reverted.\n";

        return false;
    }
    */
}
