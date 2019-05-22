<?php

use yii\db\Migration;

/**
 * Class m190521_065305_alter_receipt_item_table
 */
class m190521_065305_alter_receipt_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-receipt_item-receipt_id', '{{%receipt_item}}');
        $this->dropIndex('idx-receipt_item-receipt_id', '{{%receipt_item}}');
        $this->dropPrimaryKey('pk-receipt_id-good_id', '{{%receipt_item}}');

        $this->renameColumn('{{%receipt_item}}', 'receipt_id', 'document_id');

        $this->addPrimaryKey('pk-document_id-good_id', '{{%receipt_item}}', ['document_id', 'good_id']);
        $this->createIndex('idx-receipt_item-document_id', '{{%receipt_item}}', 'document_id');
        $this->addForeignKey('fk-receipt_item-document_id', '{{%receipt_item}}', 'document_id', 'receipt', 'id', 'CASCADE', 'RESTRICT');

        $this->addColumn('{{%receipt_item}}', 'sort', $this->integer()->notNull());
        $this->addColumn('{{%receipt_item}}', 'sum', $this->float(2)->notNull()->after('price'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%receipt_item}}', 'sort');
        $this->dropColumn('{{%receipt_item}}', 'sum');

        $this->dropForeignKey('fk-receipt_item-document_id', '{{%receipt_item}}');
        $this->dropIndex('idx-receipt_item-document_id', '{{%receipt_item}}');
        $this->dropPrimaryKey('pk-document_id-good_id', '{{%receipt_item}}');

        $this->renameColumn('{{%receipt_item}}', 'document_id', 'receipt_id');

        $this->addPrimaryKey('pk-receipt_id-good_id', 'receipt_item', ['receipt_id', 'good_id']);
        $this->createIndex('idx-receipt_item-receipt_id', 'receipt_item', 'receipt_id');
        $this->addForeignKey('fk-receipt_item-receipt_id', 'receipt_item', 'receipt_id', 'receipt', 'id', 'CASCADE', 'RESTRICT');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190521_065305_alter_receipt_item_table cannot be reverted.\n";

        return false;
    }
    */
}
