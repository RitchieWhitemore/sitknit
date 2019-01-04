<?php

use yii\db\Migration;

/**
 * Class m190104_122523_add_column_image_in_tables
 */
class m190104_122523_add_column_image_in_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('category', 'image', $this->string());
        $this->addColumn('brand', 'image', $this->string());
        $this->addColumn('country', 'image', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('category', 'image');
        $this->dropColumn('brand', 'image');
        $this->dropColumn('country', 'image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190104_122523_add_column_image_in_tables cannot be reverted.\n";

        return false;
    }
    */
}
