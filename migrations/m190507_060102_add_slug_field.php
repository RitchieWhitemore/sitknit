<?php

use yii\db\Migration;
use yii\helpers\Inflector;

/**
 * Class m190507_060102_add_alias_field
 */
class m190507_060102_add_slug_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%country}}', 'slug', $this->string()->notNull());

        $countries = \app\core\entities\Shop\Country::find()->all();

        foreach ($countries as $country) {
            if (empty($country->alias)) {
                $country->slug = Inflector::slug($country->name, '-');
                $country->save();
            }
        }

        $this->createIndex('{{%idx-country-slug}}', '{{%country}}', 'slug', true);

        $this->addColumn('{{%brand}}', 'slug', $this->string()->notNull());

        $brands = \app\core\entities\Shop\Brand::find()->all();

        foreach ($brands as $brand) {
            if (empty($brand->alias)) {
                $brand->slug = Inflector::slug($brand->name, '-');
                $brand->save();
            }
        }


        $this->createIndex('{{%idx-brand-slug}}', '{{%brand}}', 'slug', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('{{%idx-brand-slug}}', '{{%brand}}');

        $this->dropColumn('{{%brand}}', 'slug');

        $this->dropIndex('{{%idx-country-slug}}', '{{%country}}');

        $this->dropColumn('{{%country}}', 'slug');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190507_060102_add_alias_field cannot be reverted.\n";

        return false;
    }
    */
}
