<?php

namespace backend\jobs;

use backend\models\Domain;
use backend\models\DomainAPI;

/**
 * Class MetricaJob.
 */
class MegaindexJob extends \yii\base\BaseObject implements \yii\queue\JobInterface
{
    // public $domain;
    public $id;
    // public $json;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        $model = Domain::findOne($this->id);
        $domain = parse_url($model->domain, PHP_URL_HOST);
        $domainAPI = new DomainAPI();
        $json = $domainAPI->get($domain);
        $model->traffic = $json[$domain]['traffic'];
        // $model->organic = $json[$domain]['organic'];
        // $model->direct = $json[$domain]['direct'];
        $model->traffic_season = $json[$domain]['traffic_season'];
        $model->project_stage = $json[$domain]['project_stage'];
        $model->profit_await = $json[$domain]['profit_await'];
        $model->evaluate_min = $json[$domain]['evaluate_min'];
        $model->evaluate_middle = $json[$domain]['evaluate_middle'];
        $model->evaluate_max = $json[$domain]['evaluate_max'];
        // $model->domain_age = $json[$domain]['domain_age'];
        $model->IKS = $json[$domain]['IKS'];
        // $model->index_Y = $json[$domain]['index_Y'];
        // $model->index_G = $json[$domain]['index_G'];
        $model->CMS = "Wordpress";
        $model->save();
    }
}
