<?php

use yii\db\Migration;

/**
 * Class m190508_120932_remove_composition_table
 */
class m190508_120932_remove_composition_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-good-composition_id', 'good');
        $this->dropIndex('idx-good-composition_id', 'good');
        $this->dropColumn('good', 'composition_id');

        $this->dropTable('composition');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190508_120932_remove_composition_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190508_120932_remove_composition_table cannot be reverted.\n";

        return false;
    }
    */
}
