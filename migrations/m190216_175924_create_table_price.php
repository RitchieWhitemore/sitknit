<?php

use yii\db\Migration;

/**
 * Class m190216_175924_create_table_price
 */
class m190216_175924_create_table_price extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('price', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'type_price' => $this->smallInteger()->notNull(),
            'price' => $this->float(2)->notNull(),
            'good_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-price-good_id', 'price', 'good_id');

        $this->addForeignKey('fk-price-good_id', 'price', 'good_id', 'good', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-price-good_id', 'price');
        $this->dropIndex('idx-price-good_id', 'price');
        $this->dropTable('price');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190216_175924_create_table_price cannot be reverted.\n";

        return false;
    }
    */
}
