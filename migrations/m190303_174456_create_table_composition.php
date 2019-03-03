<?php

use yii\db\Migration;

/**
 * Class m190303_174456_create_table_composition
 */
class m190303_174456_create_table_composition extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('composition', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'description' => $this->string(),
            'active' => $this->boolean(),
            'image' => $this->string(),
            'content' => $this->text(),
        ]);

        $this->addColumn('good', 'composition_id', $this->integer());
        $this->createIndex('idx-good-composition_id', 'good', 'composition_id');
        $this->addForeignKey('fk-good-composition_id', 'good', 'composition_id', 'composition', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-good-composition_id', 'good');
        $this->dropIndex('idx-good-composition_id', 'good');
        $this->dropColumn('good', 'composition_id');

        $this->dropTable('composition');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190303_174456_create_table_composition cannot be reverted.\n";

        return false;
    }
    */
}
