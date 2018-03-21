<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url ;
/* ДЛЯ КАРТЫ */
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;

/* @var $this yii\web\View */
/* @var $model frontend\models\ApartamentForm */
/* @var $form ActiveForm */


$script = <<< JS
    
    $(document).ready(function() {
        $('#field-apartamentform-otdelka').hide();
        $(".field-apartamentform-type_appart").hide();
        $(".field-apartamentform-otdelka").hide();
        
        var tip;
        
        
        $("#apartamentform-type").change(function () {
        tip = $('#apartamentform-type').val();
             if( tip == 0){
                $(".tip").show();
        
                $(".cost").css('display','inline-block');
                $(".sale").show();
                $(".arenda").hide(); 
                $(".sutki").hide(); 
             }
        
             if( tip == 1){
                $(".tip").hide();
             
                $("cost").css('display','inline-block');
                $(".arenda").show();
                $(".sale").hide(); 
                $(".sutki").hide(); 
             }
        
             if( tip == 2){
                $(".tip").hide();
        
                $(".cost").css('display','inline-block');
                $(".sutki").show();
                $(".sale").hide(); 
                $(".arenda").hide(); 
             }
        
         });  
        
        var realty;
        
        $('#apartamentform-realty_type').change(function () {
         realty = $('#apartamentform-realty_type option:selected').val();
        
         if( realty == 0){
              $(".field-apartamentform-type_appart").show();

         } else{
              $(".field-apartamentform-type_appart").hide();
             
           }
        
        
          if( realty == 2){
        
              $(".field-apartamentform-rooms").hide();
              $('#apartamentform-rooms').append($("<option></option>", {value:0, text: 0}));
              $('#apartamentform-rooms').val(0);
          }else{
              $('#apartamentform-rooms :last').remove();
              $(".field-apartamentform-rooms").show();
          }
        
         if( realty == 1){
        
            $(".field-apartamentform-floor").hide();
            $('#apartamentform-floor').val(0);
         }else{
            $(".field-apartamentform-floor").show(); 
            $('#apartamentform-floor').val('');
         }
        
    });  
        
        
        
   $('#apartamentform-type_appart').change(function () {
         vtor = $('#apartamentform-type_appart option:selected').val();
         if( vtor == 1){
              $(".field-apartamentform-otdelka").show();
         }else{
             $(".field-apartamentform-otdelka").hide();
         }
   });     
        
});
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>


<div class="apartament_user">
    <div class="step">
        <h2 class="title-step">Шаг 1</h2>
    </div>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-5">
        <?= $form->field($model, 'type')->label('Тип объявления')->dropDownList([
            '0' => 'Продать',
            '1' => 'Сдать',
            '2' => 'Посуточно'
            ],[
               'prompt' => 'Выберите тип объявления...'
              ]); 
        ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'realty_type')->label('Тип недвижимости')->dropDownList([
            '0' => 'Квартира',
            '1' => 'Дом',
            '2' => 'Комната'
            ],[
               'prompt' => 'Выберите тип недвижимости...'
              ]); 
        ?>
        </div>
    </div>
    
    <div class="row tip">
        <div class="col-md-5">
            <?= $form->field($model, 'type_appart')->label('Тип квартиры')->dropDownList([
            '0' => 'Вторичка',
            '1' => 'Новостройка'
        ]); ?>
        </div>

        
    </div>
    
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'otdelka')->label('Отделка')->dropDownList([
            '0' => 'Строй вариант',
            '1' => 'Чистовая',
            '2' => 'Под ключ'
             ], 
            ['prompt'=> 'Выберите отделку'
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
                '5' => '5',
                '11' => 'Студия'
            ],[
            'prompt' => 'Выберите количество комнат...'
    ]); ?>

            <?= $form->field($model, 'area')->label('Площадь в кв.м.') ?>
            <?= $form->field($model, 'floor')->label('Этаж') ?>


            
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'street')->label('Улица') ?>
            <?= $form->field($model, 'house') ->label('Дом')?>
            <?//= $form->field($model, 'description')->textInput()->label('Описание') ?>


            <?= $form->field($model, 'telephone')->label('Телефон')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '8(999)-999-9999',
            ]) ?>
            <?= $form->field($model, 'user_id')->hiddenInput(['value'=> Yii::$app->user->getId()])->label(false) ?>
            <?= $form->field($model, 'active')->hiddenInput(['value'=> 1])->label(false) ?>
            
           
        </div>
        <div class="col-md-8">
            <?=  $form->field($model, 'description')->textarea(['rows' => 5, 'cols' => 30])->label('Описание'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <span class="cost sale">Цена</span>
            <span class="cost arenda">Цена в месяц</span>
            <span class="cost sutki">Цена в сутки</span>
            
            <?= $form->field($model, 'price')->label(false)->textInput(['placeholder' => "руб."]) ?>
        </div>
    </div>
    <br>
    <!--
    <div class="step">
        <h2 class="title-step">Шаг 2</h2>
    </div>
    <div class="row">
        
        <div class="col-md-8"><h4>Загрузите фотографии</h4>
          -->  
         <?/*= $form->field($model, 'image[]')->label(false)->widget(FileInput::classname(), [
             
                'language' => 'ru',
                'options' => [
                    'multiple' => true, 
                ],
                
                'pluginOptions' => [
                    'uploadUrl' => Url::to (['/uploads/']),  
                    'showCaption' => true,
                    'showRemove' => true,
                    'showUpload' => false,
                    'showPreview' => true,
                    
                    'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                    'browseLabel' =>  'Выбрать фотографии',
                    'allowedFileExtensions' => ['jpg','gif','png'],
                    'overwriteInitial' => false,
                    
                    'initialPreviewConfig' => [
                        'showDelete' => true
                     ],
                ],
            ]);*/?>
   <!--     </div>
    </div>

    <br>  -->
    <div class="step">
        <h2 class="title-step">Шаг 2</h2>
    </div>
<div class="row">
    
    <div class="col-md-10">
        <h4 >Переместите маркер на ваш объект недвижимости</h4>
        <?= $form->field($model, 'lat')->label(false)->hiddenInput(['value'=>NULL]); ?>
        <?= $form->field($model, 'lng')->label(false)->hiddenInput(['value'=>NULL]); ?>
    <div id="map-canvas" style="height: 512px;"></div> 
    </div>
</div>
    
 <script>
function GoogleMap_init () {

    var mapCanvas = document.getElementById('map-canvas');

    window.Map = new google.maps.Map(mapCanvas, {
        zoom: 12,
        scrollwheel: true,
        center: new google.maps.LatLng(47.231620, 39.695463)
    });

    var baseMarker = new google.maps.Marker({
      position: new google.maps.LatLng(47.228492, 39.715496),
      animation: google.maps.Animation.DROP,
      map: window.Map,
      draggable: true,
      icon :'images/point.png'
    });
  
  google.maps.event.addListener(baseMarker, 'dragend', function (a,b,c,d) {
  
    var lat = baseMarker.getPosition().lat();
    var lng = baseMarker.getPosition().lng();
    $("#apartamentform-lat").val(lat)
    $("#apartamentform-lng").val(lng);
    
  });
  
}

// Google Maps loading
var script = document.createElement('script');
script.type = 'text/javascript';
script.async = true;
script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=GoogleMap_init';
document.body.appendChild(script);


 </script>   
 <div class="row" style="padding-top: 25px;">
     <div class="col-md-10">
        <div class="form-group" style="text-align: center">
            <?= Html::submitButton('Отправить', ['class' => 'in_but']) ?>
        </div>
     </div>
 </div>
    <?php ActiveForm::end(); ?>
 
</div><!-- apartament -->

<style>
    .sale, .sutki, .arenda{
        display: none;
    }
    
    .apartament_user{
        margin-left: 20%;
    }
    
    .wrap > .container{
        background-image: url(images/k.jpg);
    }
</style>