<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "domain".
 *
 * @property int $id
 * @property string $domain
 * @property int|null $traffic
 * @property string|null $organic
 * @property string|null $direct
 * @property int|null $traffic_season
 * @property int|null $project_stage
 * @property int|null $profit_await
 * @property int|null $evaluate_min
 * @property int|null $evaluate_middle
 * @property int|null $evaluate_max
 * @property int|null $domain_age
 * @property int|null $IKS
 * @property string|null $effectiveness
 * @property int|null $articles_num
 * @property int|null $index_Y
 * @property int|null $index_G
 * @property string|null $CMS
 *
 * @property KeywordDomain[] $keywordDomains
 */
class Domain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain'], 'required'],
            [['traffic', 'traffic_season', 'project_stage', 'profit_await', 'evaluate_min', 'evaluate_middle', 'evaluate_max', 'domain_age', 'IKS', 'articles_num', 'index_Y', 'index_G'], 'integer'],
            [['domain', 'CMS'], 'string', 'max' => 255],
            [['organic', 'direct', 'effectiveness'], 'string', 'max' => 5],
            [['domain'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Domain',
            'traffic' => 'Traffic',
            'organic' => 'Organic',
            'direct' => 'Direct',
            'traffic_season' => 'Traffic Season',
            'project_stage' => 'Project Stage',
            'profit_await' => 'Profit Await',
            'evaluate_min' => 'Evaluate Min',
            'evaluate_middle' => 'Evaluate Middle',
            'evaluate_max' => 'Evaluate Max',
            'domain_age' => 'Domain Age',
            'IKS' => 'Iks',
            'effectiveness' => 'Effectiveness',
            'articles_num' => 'Articles Num',
            'index_Y' => 'Index  Y',
            'index_G' => 'Index  G',
            'CMS' => 'Cms',
        ];
    }

    /**
     * Gets query for [[KeywordDomains]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKeywordDomains()
    {
        return $this->hasMany(KeywordDomain::class, ['domain_id' => 'id']);
    }

    public function getProjects()
    {
        return $this->hasMany(Project::class, ['id' => 'project_id'])
            ->viaTable('{{%domain_project}}', ['domain_id' => 'id']);
    }

    // public function getReviews()
    // {
    //     return $this->hasMany(Review::className(), ['id' => 'review_id']);
    // }
}
