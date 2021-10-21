<?php
namespace backend\models;

use creocoder\taggable\TaggableQueryBehavior;

class ProjectQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::class,
        ];
    }
}