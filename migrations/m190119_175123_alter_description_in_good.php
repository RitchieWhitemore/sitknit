<?php

use yii\db\Migration;

/**
 * Class m190119_175123_add_content_in_good
 */
class m190119_175123_alter_description_in_good extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('good', 'description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('good', 'description', $this->string(255));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190119_175123_add_content_in_good cannot be reverted.\n";

        return false;
    }
    */
}
