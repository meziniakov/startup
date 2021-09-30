<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "keyword".
 *
 * @property int $id
 * @property string $keyword
 * @property string|null $domain_id
 *
 * @property KeywordDomain[] $keywordDomains
 */
class Keyword extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keyword';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keyword'], 'required'],
            [['keyword', 'domain_id'], 'string', 'max' => 255],
            [['keyword'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'keyword' => 'Keyword',
            'domain_id' => 'Domain ID',
        ];
    }

    /**
     * Gets query for [[KeywordDomains]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKeywordDomains()
    {
        return $this->hasMany(KeywordDomain::className(), ['keyword_id' => 'id']);
    }
}
