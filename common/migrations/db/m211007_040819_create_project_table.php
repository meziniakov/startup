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
            'author_id' => $this->integer(3),
            'updater_id' => $this->integer(3),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
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
