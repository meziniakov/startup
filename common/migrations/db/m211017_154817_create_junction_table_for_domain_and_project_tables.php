<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%domain_project}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%domain}}`
 * - `{{%project}}`
 */
class m211017_154817_create_junction_table_for_domain_and_project_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%domain_project}}', [
            'domain_id' => $this->integer(),
            'project_id' => $this->integer(),
            'PRIMARY KEY(domain_id, project_id)',
        ]);

        // creates index for column `domain_id`
        $this->createIndex(
            '{{%idx-domain_project-domain_id}}',
            '{{%domain_project}}',
            'domain_id'
        );

        // add foreign key for table `{{%domain}}`
        $this->addForeignKey(
            '{{%fk-domain_project-domain_id}}',
            '{{%domain_project}}',
            'domain_id',
            '{{%domain}}',
            'id',
            'CASCADE'
        );

        // creates index for column `project_id`
        $this->createIndex(
            '{{%idx-domain_project-project_id}}',
            '{{%domain_project}}',
            'project_id'
        );

        // add foreign key for table `{{%project}}`
        $this->addForeignKey(
            '{{%fk-domain_project-project_id}}',
            '{{%domain_project}}',
            'project_id',
            '{{%project}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%domain}}`
        $this->dropForeignKey(
            '{{%fk-domain_project-domain_id}}',
            '{{%domain_project}}'
        );

        // drops index for column `domain_id`
        $this->dropIndex(
            '{{%idx-domain_project-domain_id}}',
            '{{%domain_project}}'
        );

        // drops foreign key for table `{{%project}}`
        $this->dropForeignKey(
            '{{%fk-domain_project-project_id}}',
            '{{%domain_project}}'
        );

        // drops index for column `project_id`
        $this->dropIndex(
            '{{%idx-domain_project-project_id}}',
            '{{%domain_project}}'
        );

        $this->dropTable('{{%domain_project}}');
    }
}
