<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%domain}}`.
 */
class m210930_102012_create_domain_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%domain}}', [
            'id' => $this->primaryKey(),
            'domain' => $this->string(255)->notNull()->unique(),
            'traffic' => $this->bigInteger()->null(),
            'organic' => $this->string(5)->null(),
            'direct' => $this->string(5)->null(),
            'traffic_season' => $this->bigInteger()->null(),
            'project_stage' =>$this->integer(3)->null(),
            'profit_await' => $this->integer(10)->null(),
            'evaluate_min' => $this->integer(10)->null(),
            'evaluate_middle' => $this->integer(10)->null(),
            'evaluate_max' => $this->integer(10)->null(),
            'domain_age' => $this->integer(4)->null(),
            'IKS' => $this->integer(4)->null(),
            'effectiveness' => $this->string(5)->null(),
            'articles_num' => $this->integer(5)->null(),
            'index_Y' => $this->integer(5)->null(),
            'index_G' => $this->integer(5)->null(),
            'CMS' => $this->string(255)->null(),
        ], $tableOptions);

        $this->createTable('{{%keyword}}', [
            'id' => $this->primaryKey(),
            'keyword' => $this->string(255)->notNull()->unique(),
            'domain_id' => $this->string()
        ], $tableOptions);

        $this->createTable('{{%keyword_domain}}', [
            'keyword_id' => $this->integer(11),
            'domain_id' => $this->integer(11)
        ], $tableOptions);

        $this->createIndex('FK_domain', '{{%keyword_domain}}', 'domain_id');
        $this->createIndex('FK_keyword', '{{%keyword_domain}}', 'keyword_id');

        $this->addForeignKey(
            'FK_keyword_domain', '{{%keyword_domain}}', 'keyword_id', '{{%keyword}}', 'id', 'SET NULL', 'CASCADE'
        );
 
        $this->addForeignKey(
            'FK_domain_keyword', '{{%keyword_domain}}', 'domain_id', '{{%domain}}', 'id', 'SET NULL', 'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'FK_domain',
            'keyword_domain'
        );
        $this->dropIndex(
            'FK_keyword',
            'keyword_domain'
        );
        $this->dropForeignKey(
            'FK_keyword_domain',
            'keyword_domain'
        );
        $this->dropForeignKey(
            'FK_domain_keyword',
            'keyword_domain'
        );

        $this->dropTable('{{%domain}}');
        $this->dropTable('{{%keyword_domain}}');
        $this->dropTable('{{%keyword}}');
    }
}
