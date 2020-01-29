<?php

use yii\db\Migration;

/**
 * Class m191102_171909_add_role_field_to_user_table
 */
class m191102_171909_add_role_field_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'role', $this->smallInteger()->notNull()->defaultValue(0)->after('status'));
        $this->createIndex('idx-role', 'user', 'role');

        /*$admins = User::find()->andWhere([
            'OR',
            ['email' => 'richib@yandex.ru'],
            ['email' => 'alexis0505@mail.ru']
        ])->all();

        if ($admins) {
            foreach ($admins as $admin) {
                $admin->role = User::ROLE_ADMIN;
                $admin->save();
            }
        } else {
            $admin = new User();
            $admin->email = 'richib@yandex.ru';
            $admin->role = User::ROLE_ADMIN;
            $admin->status = User::STATUS_ACTIVE;
            $admin->save();
        }*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'role');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191102_171909_add_role_field_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
