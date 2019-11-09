<?php

use yii\db\Migration;

/**
 * Class m191109_115710_add_partner_field_to_user_table
 */
class m191109_115710_add_partner_field_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'partner_id', $this->integer()->defaultValue(null)->after('username'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'partner_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191109_115710_add_partner_field_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
