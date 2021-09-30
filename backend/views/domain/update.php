<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Domain $model
 */

$this->title = 'Update Domain: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Domains', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="domain-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
