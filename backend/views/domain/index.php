<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\models\search\DomainSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Domains';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domain-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a('Create Domain', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?php echo GridView::widget([
                'layout' => "{items}\n{pager}",
                'options' => [
                    'class' => ['gridview', 'table-responsive'],
                ],
                'tableOptions' => [
                    'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                      'class' => 'yii\grid\CheckboxColumn',
                      'checkboxOptions' => function () {
                          return [
                              'onchange' => 'var keys = $("#grid").yiiGridView("getSelectedRows");
                                          $(this).parent().parent().toggleClass("danger");'
                          ];
                      }
                    ],
                    // 'id',
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
                    [
                      'attribute' => 'screen',
                      'label' => 'Фото',
                      'format' => 'image',
                      'format' => 'html',
                      'filter' => false,
                      'content' => function ($model) {
                          return Html::img(Yii::getAlias('@storageUrl').'/source/screen/' . $model['screen'], ['width' => '100px']);
                      }
                    ],
                    [
                      'attribute' => 'chart',
                      'label' => 'График',
                      'format' => 'image',
                      'format' => 'html',
                      'filter' => false,
                      'content' => function ($model) {
                          return Html::img(Yii::getAlias('@storageUrl').'/source/screen/' . $model['chart'], ['width' => '100px']);
                      }
                    ],          
                    ['class' => \common\widgets\ActionColumn::class],
                ],
            ]); ?>
    
        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
