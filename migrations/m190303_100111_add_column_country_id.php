<?php

use yii\db\Migration;

/**
 * Class m190303_100111_add_column_country_id
 */
class m190303_100111_add_column_country_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('brand', 'country_id', $this->integer());

        $this->createIndex('idx-brand-country_id', 'brand', 'country_id');

        $this->addForeignKey(
            'fk-brand-country_id',
            'brand',
            'country_id',
            'country',
            'id'
        );

        $this->dropForeignKey('fk-good-country_id', 'good');
        $this->dropIndex('idx-good-country_id', 'good');
        $this->dropColumn('good', 'country_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190303_100111_add_column_country_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190303_100111_add_column_country_id cannot be reverted.\n";

        return false;
    }
    */
}
