<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->bigPrimaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'member_id' => $this->bigInteger()->notNull()->defaultValue(0),
            'level' => $this->integer(2)->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->insert('user', [
            'username'=> 'admin',
            'auth_key'=> \Yii::$app->security->generateRandomString(),
            'password_hash'=> \Yii::$app->getSecurity()->generatePasswordHash('admin'),
            'password_reset_token'=> NULL,
            'created_at' => strtotime(date('Y-m-d H:i:s')),
            'updated_at' => strtotime(date('Y-m-d H:i:s')),
            'email'=> 'udamuri@gmail.com',
            'status'=> 10,
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
