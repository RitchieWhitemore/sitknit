<?php

use yii\db\Migration;

/**
 * Class m190114_160521_add_parent_category
 */
class m190114_160521_add_parent_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('category', 'parent_id', $this->integer());
        $this->addColumn('category', 'content', $this->text());

        $this->createIndex('idx-category-parent_id', 'category', 'parent_id');

        $this->addForeignKey('fk-category-parent_id', 'category', 'parent_id', 'category', 'id', 'SET NULL','RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-category-parent_id', 'category');
        $this->dropIndex('idx-category-parent_id', 'category');
        $this->dropColumn('category', 'parent_id');
        $this->dropColumn('category', 'content');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190114_160521_add_parent_category cannot be reverted.\n";

        return false;
    }
    */
}
