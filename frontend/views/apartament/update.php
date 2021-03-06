<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Apartament */
/* @var $model2 frontend\models\UploadForm */

$this->title = 'Редактирование объявления';
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';

if((Yii::$app->user->getId() != $model->user_id) && (Yii::$app->user->identity->username != "admin")){
    return Yii::$app->response->redirect(['site/error']);
};
?>
<div class="">

    <h2 class="title-update">Объявление №<?= Html::encode($model->id)?></h2>
    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2
    ]) ?>
</div>
