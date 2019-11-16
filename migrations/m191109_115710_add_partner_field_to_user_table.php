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
        $this->renameColumn('user', 'username', 'last_name');

        $this->addColumn('user', 'first_name', $this->string()->notNull()->after('last_name'));

        $this->addColumn('user', 'middle_name', $this->string()->notNull()->after('first_name'));

        $this->addColumn('user', 'partner_id', $this->integer()->defaultValue(null)->after('middle_name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('user', 'last_name', 'username');
        $this->dropColumn('user', 'first_name');
        $this->dropColumn('user', 'middle_name');
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
