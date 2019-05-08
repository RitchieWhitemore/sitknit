<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category_assignment}}`.
 */
class m190508_101110_create_category_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%category_assignment}}', [
            'good_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-category_assignment}}', '{{%category_assignment}}', ['good_id', 'category_id']);

        $this->createIndex('{{%idx-category_assignment-good_id}}', '{{%category_assignment}}', 'good_id');
        $this->createIndex('{{%idx-category_assignment-category_id}}', '{{%category_assignment}}', 'category_id');

        $this->addForeignKey('{{%fk-category_assignment-good_id}}', '{{%category_assignment}}', 'good_id', '{{%good}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-category_assignment-category_id}}', '{{%category_assignment}}', 'category_id', '{{%category}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category_assignment}}');
    }
}
