<?php

use yii\db\Migration;

/**
 * Class m180518_075259_transactions
 */
class m180518_075259_transactions extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%transactions}}', [
            'id' => $this->bigPrimaryKey(),
            'code' => $this->string(150)->notNull()->unique(),
            'price' => $this->integer(15)->notNull(),
            'qty' => $this->integer(15)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'user_id' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%transactions}}');
    }
}
