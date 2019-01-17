<?php

use yii\db\Migration;

/**
 * Handles the creation of table `unit`.
 */
class m190117_052935_create_unit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%unit}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(10)->notNull(),
            'full_name' => $this->string(25),
        ]);

        $this->addColumn('{{%attribute}}', 'unit_id', $this->integer());

        $this->createIndex('idx-attribute-unit_id', '{{%attribute}}', 'unit_id');

        $this->addForeignKey('fk-attribute-unit_id', '{{%attribute}}', 'unit_id', 'unit', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-attribute-unit_id', '{{%attribute}}');
        $this->dropIndex('idx-attribute-unit_id', '{{%attribute}}');
        $this->dropColumn('{{%attribute}}', 'unit_id');
        $this->dropTable('{{%unit}}');
    }
}
