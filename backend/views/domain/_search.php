<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\Domain $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="domain-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'domain') ?>
    <?php echo $form->field($model, 'traffic') ?>
    <?php echo $form->field($model, 'organic') ?>
    <?php echo $form->field($model, 'direct') ?>
    <?php // echo $form->field($model, 'traffic_season') ?>
    <?php // echo $form->field($model, 'project_stage') ?>
    <?php // echo $form->field($model, 'profit_await') ?>
    <?php // echo $form->field($model, 'evaluate_min') ?>
    <?php // echo $form->field($model, 'evaluate_middle') ?>
    <?php // echo $form->field($model, 'evaluate_max') ?>
    <?php // echo $form->field($model, 'domain_age') ?>
    <?php // echo $form->field($model, 'IKS') ?>
    <?php // echo $form->field($model, 'effectiveness') ?>
    <?php // echo $form->field($model, 'articles_num') ?>
    <?php // echo $form->field($model, 'index_Y') ?>
    <?php // echo $form->field($model, 'index_G') ?>
    <?php // echo $form->field($model, 'CMS') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
