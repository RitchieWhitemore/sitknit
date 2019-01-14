<?php

use yii\db\Migration;

/**
 * Handles the creation of table `attribute`.
 */
class m190114_162923_create_attribute_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('attribute', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->createTable('attribute_value', [
            'good_id' => $this->integer()->notNull(),
            'attribute_id' => $this->integer()->notNull(),
            'value' => $this->string()->notNull()
        ]);

        $this->addPrimaryKey('pk_value', 'attribute_value', ['good_id', 'attribute_id']);

        $this->createIndex('idx-attribute_value-good_id', 'attribute_value', 'good_id');
        $this->createIndex('idx-attribute_value-attribute_id', 'attribute_value', 'attribute_id');

        $this->addForeignKey('fk-attribute_value-good_id', 'attribute_value', 'good_id', 'good', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-attribute_value-attribute', 'attribute_value', 'attribute_id', 'attribute', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('attribute_value');
        $this->dropTable('attribute');
    }
}
