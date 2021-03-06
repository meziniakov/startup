<?php

namespace backend\models;

use floor12\notification\Notification;
use Yii;
use yii\web\View;

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
    const DOMAIN_PARSED = 'domain_parsed';

    public function init()
    {
        $this->on(Domain::DOMAIN_PARSED, function(){
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-danger'],
                'body' => "Text"
            ]);
        });
        parent::init();
    }

    public function domainParsed()
    {
        $this->trigger(Domain::DOMAIN_PARSED);
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domain';
    }

    public function notification()
    {
        return Notification::info('The form is loading...');
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
            'domain' => '??????????',
            'traffic' => '??????????????',
            'organic' => '??????????',
            'direct' => '????????????',
            'traffic_season' => '???????????????? ??????????????',
            'project_stage' => '???????????? ??????????????',
            'profit_await' => '?????????????????? ????????????????????',
            'evaluate_min' => '?????? ??????????????????',
            'evaluate_middle' => '???? ??????????????????',
            'evaluate_max' => '???????? ??????????????????',
            'domain_age' => '?????????????? ????????????',
            'IKS' => '??????',
            'effectiveness' => '??????????????????????????',
            'articles_num' => '???????????????????? ????????????',
            'index_Y' => '???????????? ??',
            'index_G' => '???????????? ??',
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

    // static public function flash()
    // {
    //     Yii::$app->session->setFlash('alert', [
    //         'options' => ['class' => 'alert-success'],
    //         'body' => '???????????? ??????????????????. '
    //     ]);
    // }

    // public function getReviews()
    // {
    //     return $this->hasMany(Review::className(), ['id' => 'review_id']);
    // }
}
