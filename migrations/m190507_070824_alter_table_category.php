<?php

use app\core\entities\Shop\Category;
use yii\db\Migration;
use yii\helpers\Inflector;

/**
 * Class m190507_070824_alter_table_category
 */
class m190507_070824_alter_table_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-category-parent_id', 'category');
        $this->dropIndex('idx-category-parent_id', 'category');
        $this->dropColumn('category', 'parent_id');

        $this->renameColumn('{{%category}}', 'active', 'status');

        $this->addColumn('{{%category}}', 'title', $this->string());

        $this->addColumn('{{%category}}', 'lft', $this->integer()->notNull());
        $this->addColumn('{{%category}}', 'rgt', $this->integer()->notNull());
        $this->addColumn('{{%category}}', 'depth', $this->integer()->notNull());

       /* $this->insert('{{%shop_categories}}', [
            'id' => 1,
            'name' => '',
            'slug' => 'root',
            'title' => null,
            'description' => null,
            'lft' => 1,
            'rgt' => 36,
            'depth' => 0,
        ]);*/

/*        $categories = Category::find()->all();
        $first = 1;
        $last = 34;
        foreach ($categories as $category) {
            $category->detachBehaviors();
            $category->lft = $first++;
            $category->rgt = $last--;
            $category->depth = 1;
            $category->save();
        }*/

        $this->addColumn('{{%category}}', 'slug', $this->string()->notNull());

        /*$categories = Category::find()->all();

        foreach ($categories as $category) {
            if (empty($category->slug)) {
                $category->slug = Inflector::slug($category->name, '-');
                $category->save();
            }
        }

        $this->createIndex('{{%idx-category-slug}}', '{{%category}}', 'slug', true);*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('{{%idx-category-slug}}', '{{%category}}');

        $this->dropColumn('{{%category}}', 'slug');

        $this->dropColumn('{{%category}}', 'title');
        $this->dropColumn('{{%category}}', 'lft');
        $this->dropColumn('{{%category}}', 'rgt');
        $this->dropColumn('{{%category}}', 'depth');

        $this->renameColumn('{{%category}}', 'status', 'active');


    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190507_070824_alter_table_category cannot be reverted.\n";

        return false;
    }
    */
}
