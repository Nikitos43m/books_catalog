<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url ;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Apartament */
/* @var $form yii\widgets\ActiveForm */
/* @var $form2 yii\widgets\ActiveForm */
/* @var $model2 frontend\models\UploadForm */
?>

<div class="apartament-form">
 <div class="row">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-4">
       
        <?= $form->field($model, 'type')->label('Тип объявления')->dropDownList([
            '0' => 'Продать квартиру',
            '1' => 'Сдать квартиру',
        ]); ?>
        
       <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
       <?= $form->field($model, 'price')->textInput()->label('Цена (руб.)') ?>
       <?= $form->field($model, 'telephone')->textInput(['maxlength' => true])->label('Телефон')->widget(\yii\widgets\MaskedInput::className(), [
           'mask' => '8(999)-999-9999',
       ]) ?>
      
    </div>
    <div class="col-md-2">
       <?= $form->field($model, 'house')->textInput(['maxlength' => true]) ?>
       <?= $form->field($model, 'floor')->textInput() ?>
       
       
    </div>
     
    <div class="col-md-3">
       <?= $form->field($model, 'rooms')->textInput() ?>
       <?= $form->field($model, 'area')->textInput() ?>

    </div> 

     
    <div class="col-md-2">
       <?= $form->field($model, 'lat')->label(false)->hiddenInput(); ?>
       <?= $form->field($model, 'lng')->label(false)->hiddenInput(); ?>
       <?= $form->field($model, 'user_id')->label(false)->hiddenInput(); ?>
    </div>
     
   </div>
    
    
        <h3 class="open-filter" id="place"  style="cursor: pointer;">Местопложение <i class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></i></h3>
        <div class="filter">
            <div class="col-md-10">
                <div id="map-canvas" style="height: 512px;"></div> 
            </div>
        </div>
   
     
    <div class="row" id="save" >
        <div class="col-md-10" style="margin-top:40px">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'in_but']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="row">
        <h3>Фотографии</h3>
    <div class="container">
        <?php
        //$path = "uploads/p.".Html::encode("{$model->user_id}")."/";
        $path = $model->image_path;
        $images = scandir($path); // сканируем папку
        $images = preg_grep("/\.(?:png|gif|jpe?g)$/i", $images);
        foreach($images as $image) { // делаем проход по массиву
          //  $fimg .= "<img  width='100px' src='".$path.htmlspecialchars(urlencode($image))."' alt='".$image."' />";
            $img_source .= "'".$path.htmlspecialchars(urlencode($image))."',";
        }
        
         foreach($images as $image){
             $initialPreview[] = $path.htmlspecialchars(urlencode($image));
         }

        if(empty($initialPreview)){
            $initialPreview = false;
        }

        foreach($images as $image) {
            $array[] = array(
                "key" => $image
            );
        }

        ?>
    </div>
    </div>
    
    <div class="row">
        
        <div class="col-md-8">
         <?php $form2 = ActiveForm::begin(); ?>
         <?= $form2->field($model2, 'image[]')->label(false)->widget(FileInput::classname(), [
             
                'language' => 'ru',
                'options' => [
                    'multiple' => true, 
                ],
                
                'pluginOptions' => [
                    'uploadUrl' => Url::to (['/apartament/upload_img', 'path' => $path]),
                    'deleteUrl' => Url::to (['/apartament/delete_img', 'path' => $path]),
                    'showCaption' => true,
                    'showRemove' => true,
                    'showUpload' => true,
                    'showPreview' => true,
                    
                    'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                    'browseLabel' =>  'Выбрать фотографии',
                    'allowedFileExtensions' => ['jpg','gif','png'],
                    'overwriteInitial' => false,
                    
                     'initialPreviewAsData'=>true,
                     'initialPreview'=> $initialPreview,
                    
                    'initialPreviewConfig' => $array,
                ],

            ]);?>

            <!-- Загрузка через модель, пока стоит через аякс -->
             <?//= Html::submitButton('Загрузить фотографии', ['class' => 'in_but']) ?>
             <?php ActiveForm::end(); ?>
        </div>
    </div>
    
</div>
<style>
    .apartament_user{

        padding-bottom: 100px;
    }
</style>

 <script>
function GoogleMap_init () {

    var mapCanvas = document.getElementById('map-canvas');

    window.Map = new google.maps.Map(mapCanvas, {
        zoom: 12,
        center: new google.maps.LatLng(47.231620, 39.695463)
    });

    var baseMarker = new google.maps.Marker({
      position: new google.maps.LatLng(<?php echo $model->lat;?>, <?php echo $model->lng;?>),
      animation: google.maps.Animation.DROP,
      map: window.Map,
      draggable: true,
      icon :'images/point.png'
    });
  
  google.maps.event.addListener(baseMarker, 'dragend', function (a,b,c,d) {
  
    var lat = baseMarker.getPosition().lat();
    var lng = baseMarker.getPosition().lng();
    $("#apartament-lat").val(lat)
    $("#apartament-lng").val(lng);
    
  });
  
}

// Google Maps loading
var script = document.createElement('script');
script.type = 'text/javascript';
script.async = true;
script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=GoogleMap_init';
document.body.appendChild(script);


 </script>  