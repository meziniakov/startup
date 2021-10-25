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
            [['traffic', 'traffic_season', 'project_stage', 'profit_await', 'evaluate_min', 'evaluate_middle', 'evaluate_max', 'IKS', 'articles_num', 'index_Y', 'index_G'], 'integer'],
            [['domain', 'CMS'], 'string', 'max' => 255],
            [['effectiveness', 'domain_age'], 'string', 'max' => 15],
            [['organic', 'direct'], 'number'],
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
            'domain' => 'Домен',
            'traffic' => 'Траффик',
            'organic' => 'Поиск',
            'direct' => 'Прямые',
            'traffic_season' => 'Сезонный траффик',
            'project_stage' => 'Стадия проекта',
            'profit_await' => 'Ожидаемая доходность',
            'evaluate_min' => 'Мин стоимость',
            'evaluate_middle' => 'Ср стоимость',
            'evaluate_max' => 'Макс стоимость',
            'domain_age' => 'Возраст домена',
            'IKS' => 'ИКС',
            'effectiveness' => 'Эффективность',
            'articles_num' => 'Количество статей',
            'index_Y' => 'Индекс Я',
            'index_G' => 'Индекс Г',
            'CMS' => 'CMS',
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
