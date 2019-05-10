<?php

use yii\db\Migration;

/**
 * Class m190508_171745_alter_image_table
 */
class m190508_171745_alter_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%image}}', 'sort', $this->integer()->notNull());

        $this->addColumn('{{%good}}', 'main_image_id', $this->integer());

        $this->createIndex('{{%idx-good-main_image_id}}', '{{%good}}', 'main_image_id');

        $this->addForeignKey('{{%fk-good-main_image_id}}', '{{%good}}', 'main_image_id', '{{%image}}', 'id', 'SET NULL', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-good-main_image_id}}', '{{%good}}');
        $this->dropIndex('{{%idx-good-main_image_id}}', '{{%good}}');
        $this->dropColumn('{{%good}}', 'main_image_id');
        $this->dropColumn('{{%image}}', 'sort');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190508_171745_alter_image_table cannot be reverted.\n";

        return false;
    }
    */
}
