<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%composition}}`.
 */
class m190512_121449_create_composition_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%composition}}', [
            'good_id'     => $this->integer()->notNull(),
            'material_id' => $this->integer()->notNull(),
            'value'       => $this->string(),
        ]);

        $this->addPrimaryKey('{{%pk-composition}}', '{{%composition}}', ['good_id', 'material_id']);

        $this->createIndex('{{%idx-composition-good_id}}', '{{%composition}}', 'good_id');
        $this->createIndex('{{%idx-composition-material_id}}', '{{%composition}}', 'material_id');

        $this->addForeignKey('{{%fk-composition-good_id}}', '{{%composition}}', 'good_id', '{{%good}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-composition-material_id}}', '{{%composition}}', 'material_id', '{{%material}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%composition}}');
    }
}
