<?php

use yii\db\Migration;

/**
 * Class m190215_100937_create_table_documents
 */
class m190215_100937_create_table_receipt extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('receipt', [
            'id' => $this->primaryKey(),
            'date' => $this->dateTime()->notNull(),
            'partner_id' => $this->integer(),
            'total' => $this->float(2),
        ]);

        $this->createIndex('idx-receipt-partner_id', 'receipt', 'partner_id');

        $this->addForeignKey('fk-receipt-partner_id', 'receipt', 'partner_id', 'partner', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-receipt-partner_id', 'receipt');

        $this->dropIndex('idx-receipt-partner_id', 'receipt');

        $this->dropTable('receipt');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190215_100937_create_table_documents cannot be reverted.\n";

        return false;
    }
    */
}
