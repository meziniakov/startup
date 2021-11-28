<?php

use yii\bootstrap4\ButtonDropdown;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\grid\CheckboxColumn;

/**
 * @var yii\web\View $this
 * @var backend\models\search\DomainSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->params['breadcrumbs'][] = $this->title;
?>
            <?php Pjax::begin()?>
<div class="domain-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a('Добавить домен', ['create'], ['class' => 'btn btn-success']) ?>
            <?php echo Html::a(Yii::t('backend', 'Парсинг'), null, ['class' => 'btn btn-warning', 'id' => 'parsing']) ?>
            <?php if(Yii::$app->controller->action->id === 'blacklist'):?>
                <?php echo Html::a(Yii::t('backend', 'Вернуть обратно'), null, ['class' => 'btn btn-primary', 'id' => 'unblacklist']) ?>
            <?php else:?>
                <?php echo Html::a(Yii::t('backend', 'В черный список'), null, ['class' => 'btn btn-danger', 'id' => 'blacklist']) ?>
            <?php endif; ?>
</div>
        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php echo GridView::widget([
                'id' => 'grid',
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
                    [
                        'headerOptions' => ['title'=>'Траффик с учетом сезонности'],
                        'attribute' => 'traffic_season',
                        'label' => 'Сезон'
                    ],
                    // 'project_stage',
                    'profit_await:currency',
                    'evaluate_min:currency',
                    'evaluate_middle:currency',
                    'evaluate_max:currency',
                    [
                        'headerOptions' => ['title'=>'Возраст домена'],
                        'attribute' => 'domain_age',
                        'label' => 'Возраст'
                    ],
                    [
                        'headerOptions' => ['title'=>'Показатель ИКС Яндекса'],
                        'attribute' => 'IKS'
                    ],
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
                    ['class' => \common\widgets\ActionColumn::class,
                    'template' => '{start} {delete}'],
                ],
            ]); ?>
    <?php
        $this->registerJs('
          $(document).ready(function(){
            $(\'#blacklist\').click(function(){
              var id = $(\'#grid\').yiiGridView(\'getSelectedRows\');
              $.ajax({
                  type: \'POST\',
                  url : \'/domain/multiple-blacklist\',
                  data : {id: id},
                  success : function() {
                    $(this).closest(\'tr\').remove(); //удаление строки
                  }
              });
            });
            $(\'#unblacklist\').click(function(){
              var id = $(\'#grid\').yiiGridView(\'getSelectedRows\');
              $.ajax({
                  type: \'POST\',
                  url : \'/domain/multiple-unblacklist\',
                  data : {id: id},
                  success : function() {
                    $(this).closest(\'tr\').remove(); //удаление строки
                  }
              });
            });
            $(\'#parsing\').click(function(){
              var id = $(\'#grid\').yiiGridView(\'getSelectedRows\');
              var count = $(\'#grid :checkbox:checked\').length;
              $.ajax({
                  type: \'POST\',
                  url : \'/domain/multiple-parsing\',
                  data : {id: id},
                  success : function() {
                    $(\'#grid :checkbox:checked\').css(\'color\', \'red\');
                    $(\'#grid input:checkbox\').prop(\'checked\', false);
                    f12notification.success(\' Доменов успешно отправлено на обработку: \'+count);
                  }
              });
            });
          });',
          \yii\web\View::POS_READY);
      ?>
<?php Pjax::end()?>
        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
