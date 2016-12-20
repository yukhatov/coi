<?php

use yii\db\Migration;
use app\models\User;
/**
 * Handles the creation of table `user`.
 */
class m161220_123531_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'userId' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'name' => $this->string(),
            'surname' => $this->string(),
            'birthday' => $this->date(),
            'ip' => $this->string(),
            'agent' => $this->string(),
            'group' => $this->string()->notNull(),
        ]);

        $this->insert('user', [
            'username' => 'admin@admin.admin',
            'password' => md5('adminadmin' . User::SALT),
            'name' => 'Eddard',
            'surname' => 'Stark',
            'birthday' => '2016-12-23',
            'group' => User::GROUP_ADMIN,
        ]);

        $this->insert('user', [
            'username' => 'user@user.user',
            'password' => md5('useruser' . User::SALT),
            'name' => 'Tirion',
            'surname' => 'Lanister',
            'birthday' => '2016-12-23',
            'group' => User::GROUP_USER,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
