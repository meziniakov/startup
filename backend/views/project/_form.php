<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Project $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="project-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'total')->textInput(['maxlength' => true]) ?>
                <?php // $form->field($model, 'author_id')->textInput() ?>
                <?php // $form->field($model, 'created_at')->textInput() ?>
                
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
