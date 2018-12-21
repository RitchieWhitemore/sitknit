<?php

use yii\db\Migration;

/**
 * Handles the creation of table `good`.
 */
class m181221_113129_create_good_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('good', [
            'id'             => $this->primaryKey(),
            'article'        => $this->string(50),
            'title'          => $this->string(255)->notNull(),
            'description'    => $this->string(255),
            'characteristic' => $this->string(255),
            'categoryId'     => $this->integer(),
            'brandId'        => $this->integer(),
            'countryId'      => $this->integer(),
            'packaged'       => $this->integer(),
        ]);

        $this->createIndex(
            'idx-good-categoryId',
            'good',
            'categoryId'
        );

        $this->addForeignKey(
            'fk-good-categoryId',
            'good',
            'categoryId',
            'category',
            'id'
        );

        $this->createIndex(
            'idx-good-brandId',
            'good',
            'brandId'
        );

        $this->addForeignKey(
            'fk-good-brandId',
            'good',
            'brandId',
            'brand',
            'id'
        );

        $this->createIndex(
            'idx-good-countryId',
            'good',
            'countryId'
        );

        $this->addForeignKey(
            'fk-good-countryId',
            'good',
            'countryId',
            'country',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-good-countryId', 'good');
        $this->dropIndex('idx-good-countryId', 'good');

        $this->dropForeignKey('fk-good-brandId', 'good');
        $this->dropIndex('idx-good-brandId', 'good');

        $this->dropForeignKey('fk-good-categoryId', 'good');
        $this->dropIndex('idx-good-categoryId', 'good');

        $this->dropTable('good');
    }
}
