<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Apartament */
/* @var $model2 frontend\models\UploadForm */

$this->title = 'Редактирование объявления: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Apartaments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

if((Yii::$app->user->getId() != $model->user_id) && (Yii::$app->user->identity->username != "admin")){
    return Yii::$app->response->redirect(['site/error']);
};
?>
<div class="apartament_user">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2
    ]) ?>
</div>
