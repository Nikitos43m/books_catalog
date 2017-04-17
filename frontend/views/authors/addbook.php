<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Books */
/* @var $author app\models\Authors */

$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
?>
<div class="authors-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_add_book', [
        'model' => $model,
        'author_id'=>$author->id
    ]) ?>

</div>