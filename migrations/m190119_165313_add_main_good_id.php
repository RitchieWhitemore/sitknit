<?php

use yii\db\Migration;

/**
 * Class m190119_165313_add_main_good_id
 */
class m190119_165313_add_main_good_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('good', 'main_good_id', $this->integer());

        $this->createIndex('idx-main_good_id', 'good', 'main_good_id');

        $this->addForeignKey('fk-main_good_id-id', 'good', 'main_good_id', 'good', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-main_good_id-id', 'good');
        $this->dropIndex('idx-main_good_id', 'good');
        $this->dropColumn('good', 'main_good_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190119_165313_add_main_good_id cannot be reverted.\n";

        return false;
    }
    */
}
