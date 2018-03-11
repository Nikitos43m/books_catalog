<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ApartamentSearch */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
/*
 $('form').on('beforeSubmit', function(){
var data = $(this).serialize();
var action = $(this).attr("action");

    $.ajax({
        url: action,
        type: 'get',
        data: data,
        success: function(data){
            $("#gmap0-map-canvas").html(data); 
        },
        error: function(){
        alert('Error!');
        }
    });
 
 
 return false;
 });*/

JS;

$this->registerJs($js);

?>
<style>

    .col-md-1, .col-md-2{
        padding-right: 0px;
    }
</style>


<div class="apartament-search">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'search-form'
        ],
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


<div>
    <div class="col-md-2 ">

        <?= $form->field($model, 'type')->label(false)->dropDownList([
            '0' => 'Купить',
            '1' => 'Снять',
        ]); ?>

    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'street')->label(false)->textInput(['placeholder' => "Улица"]) ?>
    </div>
    <div class="col-md-1">
        <?= $form->field($model, 'house')->label(false)->textInput(['placeholder' => "Дом"]) ?>
    </div>
    <div class="col-md-2">
       

       <?=  $form->field($model, 'rooms')
    ->checkboxList([
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        11 => 'Студия'
    ]); ?>
       

    </div>
    <div class="col-md-2 col-xs-12 fl flex">
        <?php  echo $form->field($model, 'floor_from')->label(false)->textInput(['placeholder' => "Этаж от"]) ?>
        <?php  echo $form->field($model, 'floor_to')->label(false)->textInput(['placeholder' => "до", 'style'=>'']) ?>
    </div>

    <div class="col-md-2 col-xs-12 sq flex">
        <?php  echo $form->field($model, 'area_from')->label(false)->textInput(['placeholder' => "Площадь от", 'style'=>'']) ?>
        <?php  echo $form->field($model, 'area_to')->label(false)->textInput(['placeholder' => "до", 'style'=>'']) ?>
        <span class='m2'> м<sup>2</sup> </span>  
    </div>

    <div class="col-md-2 col-xs-12 price flex">
        
        <?php  echo $form->field($model, 'cost_from')->label(false)->textInput(['placeholder' => "Цена от", ]) ?>
        <?php  echo $form->field($model, 'cost_to')->label(false)->textInput(['placeholder' => "до", 'style'=>'']) ?>
        <span class='m2'> руб. </span>
    </div>


    <?php // echo $form->field($model, 'telephone') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'lng') ?>

    <?php // echo $form->field($model, 'user_id') ?>


    <div class="form-group" style="text-align: center; clear: both">
        <?= Html::submitButton('Показать', ['class' => 'main_but']) ?>
        <?//= Html::resetButton('Очистить', ['class' => 'btn btn-default']) ?>
    </div>

</div>

    <?php ActiveForm::end(); ?>

</div>
