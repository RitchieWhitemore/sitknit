<?php

use yii\db\Migration;

/**
 * Class m190124_124511_rename_column
 */
class m190124_124511_rename_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-good-countryId', 'good');
        $this->dropForeignKey('fk-good-brandId', 'good');
        $this->dropForeignKey('fk-good-categoryId', 'good');
        $this->dropForeignKey('fk-image-goodId', 'image');

        $this->dropIndex('idx-good-brandId', 'good');
        $this->dropIndex('idx-good-categoryId', 'good');
        $this->dropIndex('idx-good-countryId', 'good');
        $this->dropIndex('idx-image-goodId', 'image');


        $this->renameColumn('brand', 'title', 'name');

        $this->renameColumn('category', 'title', 'name');

        $this->renameColumn('country', 'title', 'name');

        $this->renameColumn('good', 'title', 'name');
        $this->renameColumn('good', 'categoryId', 'category_id');
        $this->renameColumn('good', 'brandId', 'brand_id');
        $this->renameColumn('good', 'countryId', 'country_id');



        $this->createIndex('idx-good-brand_id', 'good', 'category_id');
        $this->createIndex('idx-good-category_id', 'good', 'brand_id');
        $this->createIndex('idx-good-country_id', 'good', 'country_id');



        $this->addForeignKey(
            'fk-good-country_id',
            'good',
            'country_id',
            'country',
            'id'
        );

        $this->addForeignKey(
            'fk-good-brand_id',
            'good',
            'brand_id',
            'brand',
            'id'
        );

        $this->addForeignKey(
            'fk-good-category_id',
            'good',
            'category_id',
            'category',
            'id'
        );

        $this->renameColumn('image', 'fileName', 'file_name');
        $this->renameColumn('image', 'goodId', 'good_id');


        $this->createIndex('idx-image-good_id', 'image', 'good_id');

        $this->addForeignKey(
            'fk-image-good_id',
            'image',
            'good_id',
            'good',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190124_124511_rename_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190124_124511_rename_column cannot be reverted.\n";

        return false;
    }
    */
}
