<?php

use yii\db\Migration;

/**
 * Class m190511_125632_alter_attribute_value_table
 */
class m190511_125632_alter_attribute_value_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-attribute_value-attribute}}', '{{%attribute_value}}');
        $this->dropIndex('{{%idx-attribute_value-attribute_id}}', '{{%attribute_value}}');

        $this->dropForeignKey('{{%fk-attribute_value-good_id}}', '{{%attribute_value}}');
        $this->dropIndex('{{%idx-attribute_value-good_id}}', '{{%attribute_value}}');

        $this->dropPrimaryKey('{{%pk_value}}', '{{%attribute_value}}');

        $this->renameColumn('{{%attribute_value}}', 'attribute_id', 'characteristic_id');
        $this->renameTable('{{%attribute_value}}', '{{%value}}');

        $this->addPrimaryKey('{{%pk-value}}', '{{%value}}', ['good_id', 'characteristic_id']);

        $this->createIndex('{{%idx-value-characteristic_id}}', '{{%value}}', 'characteristic_id');
        $this->addForeignKey('{{%fk-value-characteristic_id}}', '{{%value}}', 'characteristic_id', '{{%characteristic}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-value-good_id}}', '{{%value}}', 'good_id');
        $this->addForeignKey('{{%fk-value-good_id}}', '{{%value}}', 'good_id', '{{%good}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-value-good_id}}', '{{%value}}');
        $this->dropIndex('{{%idx-value-good_id}}', '{{%value}}');

        $this->dropForeignKey('{{%fk-value-characteristic_id}}', '{{%value}}');
        $this->dropIndex('{{%idx-value-characteristic_id}}', '{{%value}}');
        $this->dropPrimaryKey('{{%pk-value}}', '{{%value}}');

        $this->renameTable('{{%value}}', '{{%attribute_value}}');
        $this->renameColumn('{{%attribute_value}}', 'characteristic_id', 'attribute_id');

        $this->addPrimaryKey('{{%pk_value}}', '{{%attribute_value}}', ['good_id', 'attribute_id']);

        $this->createIndex('{{%idx-attribute_value-attribute_id}}', '{{%attribute_value}}', 'attribute_id');
        $this->addForeignKey('{{%fk-attribute_value-attribute}}', '{{%attribute_value}}', 'attribute_id', '{{%characteristic}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-attribute_value-good_id}}', '{{%attribute_value}}', 'good_id');
        $this->addForeignKey('{{%fk-attribute_value-good_id}}', '{{%attribute_value}}', 'good_id', '{{%good}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190511_125632_alter_attribute_value_table cannot be reverted.\n";

        return false;
    }
    */
}
