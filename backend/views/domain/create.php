<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Domain $model
 */

$this->title = 'Create Domain';
$this->params['breadcrumbs'][] = ['label' => 'Domains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domain-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
