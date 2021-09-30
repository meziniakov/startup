<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var backend\models\Domain $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Domains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domain-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php echo Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <div class="card-body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'domain',
                    'traffic',
                    'organic',
                    'direct',
                    'traffic_season',
                    'project_stage',
                    'profit_await',
                    'evaluate_min',
                    'evaluate_middle',
                    'evaluate_max',
                    'domain_age',
                    'IKS',
                    'effectiveness',
                    'articles_num',
                    'index_Y',
                    'index_G',
                    'CMS',
                    
                ],
            ]) ?>
        </div>
    </div>
</div>
