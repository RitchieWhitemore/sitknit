<?php

use yii\db\Migration;

/**
 * Class m190221_102212_create_table_partner
 */
class m190214_102212_create_table_partner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('partner', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'full_name' => $this->string(),
            'address' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('partner');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190221_102212_create_table_partner cannot be reverted.\n";

        return false;
    }
    */
}
