<?php

use yii\db\Migration;

/**
 * Class m190508_094528_add_index_slug_in_category
 */
class m190508_094528_add_index_slug_in_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-category-slug}}', '{{%category}}', 'slug', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('{{%idx-category-slug}}', '{{%category}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190508_094528_add_index_slug_in_category cannot be reverted.\n";

        return false;
    }
    */
}
