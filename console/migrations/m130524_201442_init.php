<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%user}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'status' => $this->smallInteger()->notNull()->defaultValue(10),
                'role' => $this->smallInteger()->notNull()->defaultValue(10),
                'username' => $this->string()->notNull()->defaultValue(''),
                'email' => $this->string()->notNull()->defaultValue(''),
                'auth_key' => $this->string(32)->notNull()->defaultValue(''),
                'password_hash' => $this->string()->notNull()->defaultValue(''),
                'password_reset_token' => $this->string()->defaultValue(''),

                'created_at' => $this->integer()->notNull()->defaultValue(0),
                'updated_at' => $this->integer()->notNull()->defaultValue(0),
            ],
            $tableOptions
        );

        $this->createIndex('status', '{{%user}}', 'status');
        $this->createIndex('role', '{{%user}}', 'role');
        $this->createIndex('username', '{{%user}}', 'username', true);
        $this->createIndex('email', '{{%user}}', 'email', true);
        $this->createIndex('password_reset_token', '{{%user}}', 'password_reset_token', true);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
