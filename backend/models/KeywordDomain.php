<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "keyword_domain".
 *
 * @property int|null $keyword_id
 * @property int|null $domain_id
 *
 * @property Domain $domain
 * @property Keyword $keyword
 */
class KeywordDomain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keyword_domain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keyword_id', 'domain_id'], 'integer'],
            [['domain_id'], 'exist', 'skipOnError' => true, 'targetClass' => Domain::className(), 'targetAttribute' => ['domain_id' => 'id']],
            [['keyword_id'], 'exist', 'skipOnError' => true, 'targetClass' => Keyword::className(), 'targetAttribute' => ['keyword_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'keyword_id' => 'Keyword ID',
            'domain_id' => 'Domain ID',
        ];
    }

    /**
     * Gets query for [[Domain]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDomain()
    {
        return $this->hasOne(Domain::className(), ['id' => 'domain_id']);
    }

    /**
     * Gets query for [[Keyword]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKeyword()
    {
        return $this->hasOne(Keyword::className(), ['id' => 'keyword_id']);
    }
}
