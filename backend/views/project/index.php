<?php

use backend\models\Domain;
use backend\models\Project;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var backend\models\search\ProjectSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]);?>
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
                    [
                        'attribute' => 'name',
                        'value' => function (Project $data) {
                            return Html::a(Html::encode($data->name), Url::to(['domain/index', 'id' => $data->id]));
                        },
                        'format' => 'raw',
                        'headerOptions' => ['width' => 400],
                    ],
                    'keywords',
                    'created_at:datetime',
                    'updated_at:datetime',
                    [
                        'class' => \common\widgets\ActionColumn::class,
                        'template' => '{update} {pusk} {delete}'
                    ],
                ],
            ]); ?>
        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>