<?php

use yii\bootstrap4\ButtonDropdown;
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
  <?= Html::a(Yii::t('backend', 'Black list'), ['blacklist'], ['class' => 'btn btn-danger']) ?>
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
                'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '-'],
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
                    'traffic:integer',
                    'organic:percent',
                    'direct:percent',
                    'traffic_season',
                    // 'project_stage',
                    'profit_await:currency',
                    'evaluate_min:currency',
                    'evaluate_middle:currency',
                    'evaluate_max:currency',
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
                          return Html::img(Yii::getAlias('@storageUrl').'/screen/' . $model['screen'], ['width' => '100px']);
                      }
                    ],
                    [
                      'attribute' => 'chart',
                      'label' => 'График',
                      'format' => 'image',
                      'format' => 'html',
                      'filter' => false,
                      'content' => function ($model) {
                          return Html::img(Yii::getAlias('@storageUrl').'/chart/' . $model['chart'], ['width' => '100px']);
                      }
                    ],
                    // [
                    //     'class' => 'yii\grid\ActionColumn',
                    //     'template' => '{link}, {view} {update} {delete}',
                    //     'buttons' => [
                    //         'update' => function ($url,$model) {
                    //             return Html::a(
                    //             '<span class="glyphicon glyphicon-screenshot"></span>', 
                    //             $url);
                    //         },
                    //         'link' => function ($url,$model,$key) {
                    //             return Html::a('Действие', $url);
                    //         },
                    //     ],
                    // ],
                    ['class' => \common\widgets\ActionColumn::class,
                    'template' => '{start} {delete}'],
                ],
            ]); ?>
    
        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
