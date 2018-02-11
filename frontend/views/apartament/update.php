<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Apartament */

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
    ]) ?>

    <h2>Фотографии</h2>
    <div class="container">
        <?php
        $path = "uploads/p.".Html::encode("{$model->user_id}")."/";
        $images = scandir($path); // сканируем папку
        $images = preg_grep("/\.(?:png|gif|jpe?g)$/i", $images);
        foreach($images as $image) { // делаем проход по массиву
            $fimg .= "<img  width='100px' src='".$path.htmlspecialchars(urlencode($image))."' alt='".$image."' />";
        }
        print_r($fimg);
        ?>
    </div>

</div>
