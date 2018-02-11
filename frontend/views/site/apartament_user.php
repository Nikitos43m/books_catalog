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
        <div class="col-md-6">
        <?= $form->field($model, 'type')->label('Тип объявления')->dropDownList([
            '0' => 'Продать квартиру',
            '1' => 'Сдать квартиру',
        ],[
        'prompt' => 'Выберите тип объявления...'
    ]); ?>
            </div>
    </div>
    <div class="row">
        <div class="col-md-4">

            <?//= $form->field($model, 'rooms')->label('Количество комнат') ?>
            <?= $form->field($model, 'rooms')->label('Количество комнат')->dropDownList([
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5'
            ],[
            'prompt' => 'Выберите количество комнат...'
    ]); ?>

            <?= $form->field($model, 'area')->label('Площадь в кв.м.') ?>
            <?= $form->field($model, 'floor')->label('Этаж') ?>

            <?= $form->field($model, 'lat')->label('lat')->hiddenInput(['value'=> 0])->label(false) ?>
            <?= $form->field($model, 'lng')->label('lng')->hiddenInput(['value'=> 0])->label(false) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'street')->label('Улица') ?>
            <?= $form->field($model, 'house') ->label('Дом')?>
            <?= $form->field($model, 'telephone')->label('Телефон')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '8(999)-999-9999',
            ]) ?>
            <?= $form->field($model, 'user_id')->hiddenInput(['value'=> Yii::$app->user->getId()])->label(false) ?>
            <?//= $form->field($model, 'image_path')->hiddenInput(['value'=> 'testpath'])->label(false) ?>

            <?= $form->field($model, 'image')->fileInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'price')->label('Цена / Цена в месяц для сдачи')->textInput(['placeholder' => "руб."]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- apartament -->
