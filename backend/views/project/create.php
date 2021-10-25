<?php

/**
 * @var yii\web\View $this
 * @var common\models\Project $model
 */

$this->title = 'Создать проект';
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
