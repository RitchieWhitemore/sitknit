<?php

use yii\db\Migration;

/**
 * Class m200129_172608_add_fields_to_order_table
 */
class m200129_172608_add_fields_to_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order', 'delivery_cost', $this->float()->after('partner_id'));
        $this->addColumn('order', 'packaging_cost', $this->float()->after('delivery_cost'));
        $this->addColumn('order', 'comment', $this->string()->after('total'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('order', 'delivery_cost');
        $this->dropColumn('order', 'packaging_cost');
        $this->dropColumn('order', 'comment');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200129_172608_add_fields_to_order_table cannot be reverted.\n";

        return false;
    }
    */
}
