<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$session = Yii::$app->session;
$session->open();

/* @var $this yii\web\View */
/* @var $model app\models\ApartamentSearch */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
 $(document).ready(function() {
     $('#apartamentsearch-rooms').multiselect({
         nonSelectedText: 'Комнат'   
     });
        
     $('#apartamentsearch-term').multiselect({
         nonSelectedText: 'Срок сдачи'   
     });   
        
     var realty = $('#apartamentsearch-realty_type option:selected').val();
        
        if( realty == 2){
              $(".room").hide();
              $(".tip").hide();
              $("#apartamentsearch-type_appart").val('');
              $('#apartamentsearch-otdelka').val('');
              $('#apartamentsearch-term').val('');
              $("#apartamentsearch-rooms").val('');    
         }
        
        if( realty == 0){
            $(".tip").show();
        }
        
        if( realty == 1){
            $(".tip").hide();
        }
        
        
        
    var kv = $('#apartamentsearch-type_appart option:selected').val();
        if (kv == 0){
            $(".otd").hide();
            $(".term").hide();
        }else{
            $(".otd").show();
            $(".term").show();
        }
        
        
        
     $('#apartamentsearch-type_appart').change(function () {
     var kv = $('#apartamentsearch-type_appart option:selected').val();   
        if (kv == 1){
            $(".otd").show();
            $(".term").show();
        }else{
            $(".otd").hide();
            $(".term").hide();
            $('#apartamentsearch-otdelka').val('');
            $('#apartamentsearch-term').val('');
        }
         
     }); 
        
        
        var type = $('#apartamentsearch-type option:selected').val();   
        if (type == 0){
            $(".tip").show();
        }else{
            $(".tip").hide();            
        }
        
        if(type == 1){
           $(".otd").hide();
           $(".term").hide();
           $('#apartamentsearch-type_appart').val('');
           $('#apartamentsearch-otdelka').val('');
           $('#apartamentsearch-term').val('');
        }
        
        if(type == 2){
           $(".otd").hide();
           $(".term").hide();
           $('#apartamentsearch-type_appart').val('');
           $('#apartamentsearch-otdelka').val('');
           $('#apartamentsearch-term').val('');
        }
        
        
    $('#apartamentsearch-type').change(function () {
     var type = $('#apartamentsearch-type option:selected').val();   
        if (type == 0){
            $(".tip").show();
        }else{
            $(".tip").hide();            
        }
        
        if(type == 1){
           $('#apartamentsearch-type_appart').val('');
           $('#apartamentsearch-otdelka').val('');
           $('#apartamentsearch-term').val('');
           $(".otd").hide();
           $(".term").hide();
        }
        
        if(type == 2){
           $('#apartamentsearch-type_appart').val('');
           $('#apartamentsearch-otdelka').val('');
           $('#apartamentsearch-term').val('');
           $(".otd").hide();
           $(".term").hide();
        }
         
     });      
        
        
    var realty;
    $('#apartamentsearch-realty_type').change(function () {
        realty = $('#apartamentsearch-realty_type option:selected').val();
        
        if( realty == 0){
            $(".tip").show();
        }
        
        if( realty == 2){
              $(".room").hide();
              $(".tip").hide();
              $("#apartamentsearch-type_appart").val('');
              $('#apartamentsearch-otdelka').val('');
              $('#apartamentsearch-term').val('');
              $("#apartamentsearch-rooms").val('');

          }else{
              $(".room").show();
          }
        
        if( realty == 1){
              $(".tip").hide();
              $(".otd").hide();
              $(".fl").hide();
              $("#apartamentsearch-type_appart").val('');
              $('#apartamentsearch-otdelka').val('');
          

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
    
    @media (max-width: 768px){
       .col-md-1, .col-md-2{
        padding-right: 20px;
    } 
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
    
    <div class="col-lg-2 col-md-2 col-sm-4 tip">
         <?= $form->field($model, 'type_appart')->label(false)->dropDownList([
            '0' => 'Вторичка',
            '1' => 'Новостройка'
         ]); ?>
    </div>
    
     <div class="col-lg-2 col-md-2 col-sm-4 otd">
         <?= $form->field($model, 'otdelka')->label(false)->dropDownList([
            '0' => 'Строй вариант',
            '1' => 'Чистовая',
            '2' => 'Под ключ'
             ], 
            ['prompt'=> 'Отделка...'
            ]); ?>
     </div>    
     
    <div class="col-lg-2 col-md-2 col-sm-4 room">
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
    <div class="col-lg-2 col-md-2 col-sm-4 term">
        <?= $form->field($model, 'term')->label(false)->dropDownList([
             0 => 'Сдан',
             1 => '2018',
             2 => '2019',
             3 => '2020',
             4 => 'Позднее' 
        ],
            [
               'multiple' => 'true'
              ]
            
            ); ?>
    </div>
    
    <div class="col-md-2 col-sm-6 col-xs-12 col-lg-3 sq flex">
        <?php  echo $form->field($model, 'area_from')->label(false)->textInput(['placeholder' => "Площадь от", 'style'=>'border-radius:  10px 0 0 10px;']) ?>
        <?php  echo $form->field($model, 'area_to')->label(false)->textInput(['placeholder' => "до", 'style'=>'border-left: none; border-radius: 0 10px 10px 0;']) ?>
        <span class='m2'> м<sup>2</sup> </span>  
    </div>
    <div class="col-md-2 col-sm-3 col-xs-12 fl flex">
        <?php  echo $form->field($model, 'floor_from')->label(false)->textInput(['placeholder' => "Этаж от", 'style'=>'border-radius:  10px 0 0 10px;']) ?>
        <?php  echo $form->field($model, 'floor_to')->label(false)->textInput(['placeholder' => "до", 'style'=>'border-left: none; border-radius: 0 10px 10px 0;']) ?>
    </div>
    
    <div class="col-md-3 col-sm-4 col-xs-12 flex">
        <?= $form->field($model, 'street')->label(false)->textInput(['placeholder' => "Улица", 'style'=>'border-radius:  10px 0 0 10px;']) ?>
        <?= $form->field($model, 'house')->label(false)->textInput(['placeholder' => "Дом", 'style'=>'border-left: none; border-radius: 0 10px 10px 0;']) ?>
    </div>





    <div class="col-md-2 col-sm-6 col-xs-12 price flex">
        
        <?php  echo $form->field($model, 'cost_from')->label(false)->textInput(['placeholder' => "Цена от", 'style'=>'border-radius:  10px 0 0 10px;']) ?>
        <?php  echo $form->field($model, 'cost_to')->label(false)->textInput(['placeholder' => "до", 'style'=>'border-left: none; border-radius: 0 10px 10px 0;']) ?>
        <span class='m2'> руб. </span>
    </div>

    <?=$form->field($model, 'city_id')->label(false)->hiddenInput(['value'=>$session['my_city']]); ?>
    

    <div class="form-group" style="text-align: center; clear: both">
        <?= Html::submitButton('Показать', ['class' => 'main_but show-filter']) ?>
        <?//= Html::resetButton('Очистить', ['class' => 'btn btn-default']) ?>
    </div>

</div>

    <?php ActiveForm::end(); ?>

</div>
