<?php

use yii\db\Migration;

/**
 * Class m190430_080416_alter_phone_column
 */
class m190430_080416_alter_phone_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('partner', 'phone', $this->string(20));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190430_080416_alter_phone_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190430_080416_alter_phone_column cannot be reverted.\n";

        return false;
    }
    */
}
