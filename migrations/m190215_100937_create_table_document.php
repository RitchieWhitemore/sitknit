<?php

use yii\db\Migration;

/**
 * Class m190215_100937_create_table_documents
 */
class m190215_100937_create_table_document extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('document', [
            'id' => $this->primaryKey(),
            'date' => $this->dateTime()->notNull(),
            'type_id' => $this->smallInteger()->notNull(),
            'total' => $this->float(2),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('document');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190215_100937_create_table_documents cannot be reverted.\n";

        return false;
    }
    */
}
