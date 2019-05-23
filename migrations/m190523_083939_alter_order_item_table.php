<?php

use yii\db\Migration;

/**
 * Class m190523_083939_alter_order_item_table
 */
class m190523_083939_alter_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-order_item-order_id', '{{%order_item}}');
        $this->dropIndex('idx-order_item-order_id', '{{%order_item}}');
        $this->dropPrimaryKey('pk-order_id-good_id', '{{%order_item}}');

        $this->renameColumn('{{%order_item}}', 'order_id', 'document_id');

        $this->addPrimaryKey('pk-document_id-good_id', '{{%order_item}}', ['document_id', 'good_id']);
        $this->createIndex('idx-order_item-document_id', '{{%order_item}}', 'document_id');
        $this->addForeignKey('fk-order_item-document_id', '{{%order_item}}', 'document_id', 'order', 'id', 'CASCADE', 'RESTRICT');

        $this->addColumn('{{%order_item}}', 'sort', $this->integer()->notNull());
        $this->addColumn('{{%order_item}}', 'sum', $this->float(2)->notNull()->after('price'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order_item}}', 'sort');
        $this->dropColumn('{{%order_item}}', 'sum');

        $this->dropForeignKey('fk-order_item-document_id', '{{%order_item}}');
        $this->dropIndex('idx-order_item-document_id', '{{%order_item}}');
        $this->dropPrimaryKey('pk-document_id-good_id', '{{%order_item}}');

        $this->renameColumn('{{%order_item}}', 'document_id', 'order_id');

        $this->addPrimaryKey('pk-order_id-good_id', 'order_item', ['order_id', 'good_id']);
        $this->createIndex('idx-order_item-order_id', 'order_item', 'order_id');
        $this->addForeignKey('fk-order_item-order_id', 'order_item', 'order_id', 'order', 'id', 'CASCADE', 'RESTRICT');
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
