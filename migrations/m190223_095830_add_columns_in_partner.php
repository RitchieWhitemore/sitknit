<?php

use yii\db\Migration;

/**
 * Class m190223_095830_add_columns_in_partner
 */
class m190223_095830_add_columns_in_partner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('partner', 'phone', $this->integer(11));
        $this->addColumn('partner', 'email', $this->string());
        $this->addColumn('partner', 'profile', $this->string());
        $this->addColumn('partner', 'post_index', $this->string(10));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('partner', 'phone');
        $this->dropColumn('partner', 'email');
        $this->dropColumn('partner', 'profile');
        $this->dropColumn('partner', 'post_index');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190223_095830_add_columns_in_partner cannot be reverted.\n";

        return false;
    }
    */
}
