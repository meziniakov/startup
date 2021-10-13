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
        $model->traffic = 3000;
        // $model->save();
        $js_path = __DIR__.'/nodejs/metrica.js';
        $js_func = 'metrica.js ' . $model->domain;
        $node = '/snap/node/5322/bin/node';
        $out = null;
        // die("cd ".dirname($js_path)." && {$node} {$js_func} 2>&1");
        // $model->CMS = "cd ".dirname($js_path)." && {$node} {$js_func} 2>&1";
        $model->CMS = "Wordpress";
        shell_exec("cd " . dirname($js_path)." && {$node} {$js_func}");
        $model->save();
    }
}
