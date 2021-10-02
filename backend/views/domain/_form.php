<?php

use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\JsExpression;

/**
 * @var yii\web\View $this
 * @var backend\models\Domain $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="domain-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'traffic')->textInput() ?>
                <?php echo $form->field($model, 'organic')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'direct')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'traffic_season')->textInput() ?>
                <?php echo $form->field($model, 'project_stage')->textInput() ?>
                <?php echo $form->field($model, 'profit_await')->textInput() ?>
                <?php echo $form->field($model, 'evaluate_min')->textInput() ?>
                <?php echo $form->field($model, 'evaluate_middle')->textInput() ?>
                <?php echo $form->field($model, 'evaluate_max')->textInput() ?>
                <?php echo $form->field($model, 'domain_age')->textInput() ?>
                <?php echo $form->field($model, 'IKS')->textInput() ?>
                <?php echo $form->field($model, 'effectiveness')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'articles_num')->textInput() ?>
                <?php echo $form->field($model, 'index_Y')->textInput() ?>
                <?php echo $form->field($model, 'index_G')->textInput() ?>
                <?php echo $form->field($model, 'CMS')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'screen')->widget(
                Upload::class,
                [
                    'url' => ['/source/screen/'],
                    'maxFileSize' => 5000000, // 5 MiB,
                    'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                ]
            ) ?>

            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
