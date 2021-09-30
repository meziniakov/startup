<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%domain}}`.
 */
class m210930_182742_add_screen_column_to_domain_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('domain', 'screen', $this->string(255));
        $this->addColumn('domain', 'chart', $this->string(255));
        $this->addColumn('domain', 'new', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('domain', 'screen');
        $this->dropColumn('domain', 'chart');
        $this->dropColumn('domain', 'new');
    }
}
