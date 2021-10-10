<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m211007_040819_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->unique()->notNull(),
            'keywords' => $this->string()->notNull(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%project}}');
    }
}
