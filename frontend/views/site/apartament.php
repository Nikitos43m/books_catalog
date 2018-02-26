<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ApartamentForm */
/* @var $form ActiveForm */
?>
<div class="apartament">
    <div class="row">
    <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-4">
            <?= $form->field($model, 'type')->label('Тип объявления') ?>
            

            <?= $form->field($model, 'user_id')->textInput(['value' => Yii::$app->user->getId()]) ?>
            <?//= $form->field($model, 'user_id')->hiddenInput(['value'=> Yii::$app->user->getId()])->label(false) ?>

            <?= $form->field($model, 'rooms')->label('Тип объявления') ?>
            <?= $form->field($model, 'area')->label('Площадь') ?>
            <?= $form->field($model, 'price')->label('Цена') ?>
            <?= $form->field($model, 'floor')->label('Этаж') ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'lat')->label('lat') ?>
            <?= $form->field($model, 'lng')->label('lng') ?>
            <?= $form->field($model, 'street')->label('Улица') ?>
            <?= $form->field($model, 'house') ->label('Дом')?>
            <?= $form->field($model, 'description')->textInput()->label('Описание') ?>
            <?= $form->field($model, 'telephone')->label('Телефон') ?>
        </div>
    </div>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- apartament -->
