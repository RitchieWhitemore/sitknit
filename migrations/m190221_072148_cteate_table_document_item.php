<?php

use yii\db\Migration;

/**
 * Class m190221_072148_cteate_table_document_item
 */
class m190221_072148_cteate_table_document_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('document_item', [
            'id' => $this->primaryKey(),
            'document_id' => $this->integer()->notNull(),
            'good_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
            'price' => $this->float(2)->notNull(),
        ]);

        $this->createIndex('idx-document_item-document_id', 'document_item', 'document_id');
        $this->createIndex('idx-document_item-good_id', 'document_item', 'good_id');

        $this->addForeignKey('idx-document_item-document_id', 'document_item', 'document_id', 'document', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('idx-document_item-good_id', 'document_item', 'good_id', 'good', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('idx-document_item-good_id', 'document_item');
        $this->dropForeignKey('idx-document_item-document_id', 'document_item');

        $this->dropIndex('idx-document_item-good_id', 'document_item');
        $this->dropIndex('idx-document_item-document_id', 'document_item');

        $this->dropTable('document_item');
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
