<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Apartament */

$this->title = 'Create Apartament';
$this->params['breadcrumbs'][] = ['label' => 'Apartaments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apartament-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
