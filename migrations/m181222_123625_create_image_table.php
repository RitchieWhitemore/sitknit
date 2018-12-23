<?php

use yii\db\Migration;

/**
 * Handles the creation of table `image`.
 */
class m181222_123625_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'fileName' => $this->string()->notNull(),
            'goodId' => $this->integer()->notNull(),
            'main' => $this->integer(1),
        ]);

        $this->createIndex(
            'idx-image-goodId',
            'image',
            'goodId'
        );

        $this->addForeignKey(
            'fk-image-goodId',
            'image',
            'goodId',
            'good',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-image-goodId', 'image');
        $this->dropIndex('idx-image-goodId', 'image');
        $this->dropTable('image');
    }
}
