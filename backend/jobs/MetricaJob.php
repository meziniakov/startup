<?php

namespace backend\jobs;

use backend\models\Domain;
use yii\web\NotFoundHttpException;

/**
 * Class MetricaJob.
 */
class MetricaJob extends \yii\base\BaseObject implements \yii\queue\JobInterface
{
    // public $domain;
    public $id;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        $model = Domain::findOne($this->id);
        $js_path = __DIR__.'/../../nodejs/be1.js';
        $js_func = 'be1.js ' . parse_url($model->domain, PHP_URL_HOST);
        // $node = '/snap/node/5322/bin/node';
        $node = 'node';
        $res = json_decode(exec("cd " . dirname($js_path)." && {$node} {$js_func}"));
        // $json = '{"domain":"blogstroykin.com","traffic":"","organic":"","direct":"","traffic_season":"","project_stage":10,"profit_await":"15","evaluate_min":"75","evaluate_middle":"113","evaluate_max":"150","domain_age":"2 года 57 дней","IKS":20,"index_Y":"2132","index_G":"2630","megaindexTrustRank":"5","megaindexDomainRank":"0"}';
        // $res = json_decode($json);
        $model->traffic = $res->traffic ? $res->traffic : '';
        $model->organic = $res->organic ? $res->organic : '';
        $model->direct = $res->direct ? $res->direct : '';
        $model->traffic_season = $res->traffic_season ? $res->traffic_season : '';
        $model->project_stage = $res->project_stage ? $res->project_stage : '';
        $model->profit_await = $res->profit_await ? $res->profit_await : '';
        $model->evaluate_min = $res->evaluate_min ? $res->evaluate_min : '';
        $model->evaluate_middle = $res->evaluate_middle ? $res->evaluate_middle : '';
        $model->evaluate_max = $res->evaluate_max ? $res->evaluate_max : '';
        $model->domain_age = $res->domain_age ? $res->domain_age : '';
        $model->IKS = $res->IKS ? $res->IKS : '';
        $model->index_Y = $res->index_Y ? $res->index_Y : '';
        $model->index_G = $res->index_G ? $res->index_G : '';
        $model->CMS = "";
        $model->save();
    }
}
