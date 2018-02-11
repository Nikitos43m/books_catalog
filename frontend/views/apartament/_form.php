<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Apartament */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apartament-form">
 <div class="row">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-4">
       <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>
       <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
       <?= $form->field($model, 'house')->textInput(['maxlength' => true]) ?>
       <?= $form->field($model, 'rooms')->textInput() ?>
    </div>
    <div class="col-md-2">
       <?= $form->field($model, 'floor')->textInput() ?>
       <?= $form->field($model, 'area')->textInput() ?>
       <?= $form->field($model, 'price')->textInput() ?>
       <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
    </div>

     <? if(Yii::$app->user->identity->username == "admin"): ?>
    <div class="col-md-2">
       <?= $form->field($model, 'lat')->textInput() ?>
       <?= $form->field($model, 'lng')->textInput() ?>
       <?= $form->field($model, 'user_id')->textInput() ?>
    </div>
     <? endif; ?>
 </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
      </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
