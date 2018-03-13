<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ApartamentSearch */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
 $(document).ready(function() {
     $('#apartamentsearch-rooms').multiselect({
         nonSelectedText: 'Комнат'   
     });    
        
    var realty;
    $('#apartamentsearch-realty_type').change(function () {
        realty = $('#apartamentsearch-realty_type option:selected').val();
        
        if( realty == 2){
              $(".room").hide();

          }else{
              $(".room").show();
          }
        
        if( realty == 1){
              $(".fl").hide();

          }else{
              $(".fl").show();
          }
    });    
        
 });

JS;

$this->registerJs($js);

?>
<style>

    .col-md-1, .col-md-2{
        padding-right: 0px;
    }
    
    .form-group{
       margin-bottom: unset;
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
    <div class="col-lg-2 col-md-2 col-sm-4 ">

        <?= $form->field($model, 'type')->label(false)->dropDownList([
            '0' => 'Купить',
            '1' => 'Снять',
            '2' => 'Посуточно'
        ]); ?>

    </div>
    
    <div class="col-lg-2 col-md-2 col-sm-4">
        <?= $form->field($model, 'realty_type')->label(false)->dropDownList([
            '0' => 'Квартиру',
            '1' => 'Дом',
            '2' => 'Комнату'
        ]); ?>
    </div>
     
    <div class="col-lg-2 col-md-2 col-sm-4 room">
       <?/*=  $form->field($model, 'rooms')
    ->checkboxList([
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        11 => 'Студия'
    ]); */?>
    <?= $form->field($model, 'rooms')->label(false)->dropDownList([
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
            11 => 'Студия'
        ],
            [
               'multiple' => 'true'
              ]
            
            ); ?>
    </div>
    
    
    <div class="col-md-2 col-sm-6 col-xs-12 col-lg-3 sq flex">
        <?php  echo $form->field($model, 'area_from')->label(false)->textInput(['placeholder' => "Площадь от", 'style'=>'']) ?>
        <?php  echo $form->field($model, 'area_to')->label(false)->textInput(['placeholder' => "до", 'style'=>'']) ?>
        <span class='m2'> м<sup>2</sup> </span>  
    </div>
    
    <div class="col-md-2 col-sm-6">
        <?= $form->field($model, 'street')->label(false)->textInput(['placeholder' => "Улица"]) ?>
    </div>
    
    <div class="col-md-1 col-sm-3">
        <?= $form->field($model, 'house')->label(false)->textInput(['placeholder' => "Дом"]) ?>
    </div>

    <div class="col-md-2 col-sm-3 col-xs-12 fl flex">
        <?php  echo $form->field($model, 'floor_from')->label(false)->textInput(['placeholder' => "Этаж от"]) ?>
        <?php  echo $form->field($model, 'floor_to')->label(false)->textInput(['placeholder' => "до", 'style'=>'']) ?>
    </div>



    <div class="col-md-2 col-sm-6 col-xs-12 price flex">
        
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
