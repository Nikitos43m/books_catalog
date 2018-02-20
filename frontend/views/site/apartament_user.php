<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

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
            <?/*= $form->field($model, 'avatar')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            ]);*/?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'price')->label('Цена / Цена в месяц для сдачи')->textInput(['placeholder' => "руб."]) ?>
        </div>
    </div>
        
    
<div class="row">
    <div class="col-md-10">
    <div id="map-canvas" style="height: 512px;"></div> 
    </div>
</div>
    
 <script>
function GoogleMap_init () {

    var mapCanvas = document.getElementById('map-canvas');

    window.Map = new google.maps.Map(mapCanvas, {
        zoom: 15,
        center: new google.maps.LatLng(47.231620, 39.695463)
    });

    var baseMarker = new google.maps.Marker({
      position: new google.maps.LatLng(47.228492, 39.715496),
      animation: google.maps.Animation.DROP,
      map: window.Map,
      draggable: true
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
    
    
 <div class="row">
        <div class="col-md-4">   
           <?= $form->field($model, 'lat')->label('lat')->textInput() ?>
           <?= $form->field($model, 'lng')->label('lng')->textInput() ?>
        </div>
 </div>
 
    <div class="form-group" style="text-align: center">
        <?= Html::submitButton('Отправить', ['class' => 'in_but']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- apartament -->

