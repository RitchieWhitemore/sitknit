<?php

use yii\db\Migration;

/**
 * Class m190511_103506_alter_attribute_table
 */
class m190511_103506_alter_attribute_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('{{%attribute}}', '{{%characteristic}}');

        $this->addColumn('{{%characteristic}}', 'sort', $this->integer()->notNull());

        $this->dropForeignKey('{{%fk-attribute-unit_id}}', '{{%characteristic}}');
        $this->dropIndex('{{%idx-attribute-unit_id}}', '{{%characteristic}}');

        $this->addForeignKey('{{%fk-characteristic-unit_id}}', '{{%characteristic}}', 'unit_id', '{{%unit}}', 'id');
        $this->createIndex('{{%idx-characteristic-unit_id}}', '{{%characteristic}}', 'unit_id');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-characteristic-unit_id}}', '{{%characteristic}}');
        $this->dropIndex('{{%idx-characteristic-unit_id}}', '{{%characteristic}}');

        $this->addForeignKey('{{%fk-attribute-unit_id}}', '{{%characteristic}}', 'unit_id', '{{%unit}}', 'id');
        $this->createIndex('{{%idx-attribute-unit_id}}', '{{%characteristic}}', 'unit_id');

        $this->dropColumn('{{%characteristic}}', 'sort');
        $this->renameTable('{{%characteristic}}', '{{%attribute}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190511_103506_alter_attribute_table cannot be reverted.\n";

        return false;
    }
    */
}
