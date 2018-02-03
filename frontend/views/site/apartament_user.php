<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ApartamentForm */
/* @var $form ActiveForm */
?>
<div class="apartament_user">

        <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
        <?= $form->field($model, 'type')->label('Тип объявления')->dropDownList([
            '0' => 'Продать квартиру',
            '1' => 'Сдать квартиру',
        ]); ?>
            </div>
    </div>
    <div class="row">
        <div class="col-md-4">

            <?= $form->field($model, 'rooms')->label('Количество комнат') ?>
            <?= $form->field($model, 'area')->label('Площадь') ?>
            <?= $form->field($model, 'price')->label('Цена') ?>
            <?= $form->field($model, 'floor')->label('Этаж') ?>

            <?= $form->field($model, 'lat')->label('lat')->hiddenInput(['value'=> 0])->label(false) ?>
            <?= $form->field($model, 'lng')->label('lng')->hiddenInput(['value'=> 0])->label(false) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'street')->label('Улица') ?>
            <?= $form->field($model, 'house') ->label('Дом')?>
            <?= $form->field($model, 'telephone')->label('Телефон') ?>
            <?//= $form->field($model, 'user_id')->hiddenInput(['value'=> Yii::$app->user->getId()])->label(false) ?>
            <?= $form->field($model, 'user_id')->textInput(['value' => Yii::$app->user->getId()]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- apartament -->
