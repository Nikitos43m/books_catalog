<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url ;
use yii\helpers\ArrayHelper;
use common\widgets\CityWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Apartament */
/* @var $form yii\widgets\ActiveForm */
/* @var $form2 yii\widgets\ActiveForm */
/* @var $model2 frontend\models\UploadForm */

$script = <<< JS
    
    $(document).ready(function() {
        
        tip = $('#apartament-type option:selected').val();
        if( tip == 0){
                $(".tip").show();
                $(".form-group.field-apartament-ipoteka").show();
        
                $(".cost").css('display','inline-block');
                $(".sale").show();
                $(".arenda").hide(); 
                $(".sutki").hide(); 
             }
        
             if( tip == 1){
                $(".tip").hide();
                $(".form-group.field-apartament-ipoteka").hide();
        
                $("cost").css('display','inline-block');
                $(".arenda").show();
                $(".sale").hide(); 
                $(".sutki").hide(); 
             }
        
             if( tip == 2){
                $(".tip").hide();
                $(".form-group.field-apartament-ipoteka").hide();
        
                $(".cost").css('display','inline-block');
                $(".sutki").show();
                $(".sale").hide(); 
                $(".arenda").hide(); 
             }

       
        var realty;
        
        realty = $('#apartament-realty_type option:selected').val();
        
          if( realty == 0){
              $(".field-apartament-type_appart").show();
        
          } else{
              $(".field-apartament-type_appart").hide();
             
           }
        
          if( realty == 2){
              $(".field-apartament-rooms").hide();
          }
        
          if( realty == 1){
              $(".field-apartament-floor").hide();  
          } 
        
          vtor = $('#apartament-type_appart option:selected').val();        
            if( vtor == 0){
                  $(".field-apartament-otdelka").hide();
                  $(".field-apartament-term").hide();
                  $(".field-apartament-year").show();
             }else{
                 $(".field-apartament-otdelka").show();
                 $(".field-apartament-term").show();
                 $(".field-apartament-year").hide();
             }

        
        $('#apartament-realty_type').change(function () {
         real = $('#apartament-realty_type option:selected').val();
        
          if( real == 2){
              $(".field-apartament-rooms").hide();
              $(".field-apartament-type_appart").show();
              $(".field-apartament-otdelka").hide();
              $(".field-apartament-term").hide();

          }else{
              $(".field-apartament-rooms").show();
          }
        
         if( real == 1){
            $(".field-apartament-otdelka").hide();
            $(".field-apartament-term").hide();
            $(".field-apartament-floor").hide();
            $(".field-apartament-type_appart").hide();
            
         }else{
            $(".field-apartament-floor").show(); 
         }
        
        if( real == 0){
              $(".field-apartament-type_appart").show();

          } else{
              $(".field-apartament-type_appart").hide();
             
           }
        
    });  
        
         $('#apartament-type_appart').change(function () {
         vtor = $('#apartament-type_appart option:selected').val();        
        if( vtor == 0){
              $(".field-apartament-otdelka").hide();
              $(".field-apartament-term").hide();
         }else{
             $(".field-apartament-otdelka").show();
             $(".field-apartament-term").show();
         }
   });     
        
       
        
});
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>

    
       <div class="row text-center">
        <h3>Загрузите фотографии</h3>
 
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

    
    <div class="row">
        
        <div class="col-md-12">
         <?php $form2 = ActiveForm::begin(); ?>
         <?= $form2->field($model2, 'image[]')->label(false)->widget(FileInput::classname(), [
             
                'language' => 'ru',
                'options' => [
                    'multiple' => true, 
                ],
                
                'resizeImages' => true,
              
                'pluginOptions' => [
                    'uploadUrl' => Url::to (['/apartament/upload_img', 'path' => $path]),
                    'deleteUrl' => Url::to (['/apartament/delete_img', 'path' => $path]),
                    'maxImageWidth' => 1400,
                    'showCaption' => true,
                    'showUpload' => true,
                    'showRemove' => false,
                    'showPreview' => true,
                    'uploadClass' => 'btn btn-success upl',
                    'browseClass' => 'browse',
                    
                    'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                    'browseLabel' =>  'Выбрать фотографии',
                    'allowedFileExtensions' => ['jpg','gif','png','jpeg'],
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


<div class="apartament-form">
 <div>
     <h3 class="update-info">Информация</h3>
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-4">
       
        <?= $form->field($model, 'type')->label('Тип объявления')->dropDownList([
            '0' => 'Продать',
            '1' => 'Сдать',
            '2' => 'Посуточно'
        ],['disabled' => true]); ?>
        
        <?= $form->field($model, 'realty_type')->label('Тип недвижимости')->dropDownList([
            '0' => 'Квартиру',
            '1' => 'Дом',
            '2' => 'Комнату'
        ],['disabled' => true]); ?>
        
        <?= $form->field($model, 'type_appart')->label('Тип квартиры')->dropDownList([
            '0' => 'Вторичка',
            '1' => 'Новостройка'
        ], ['disabled' => true]); ?>
        
        <?= $form->field($model, 'material')->label('Тип дома')->dropDownList([
             '0' => 'Кирпичный',
             '1' => 'Монолитный',
             '2' => 'Монолитно-кирпичный',
             '3' => 'Панельный',
             '4' => 'Блочный',
             '5' => 'Деревянный'
            ],[
               'prompt' => 'Выберите тип дома...'
              ]); 
             ?>
        
        <?= $form->field($model, 'year')->label('Год постройки')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9999',
            ]) ?>
        
        <?= $form->field($model, 'otdelka')->label('Отделка')->dropDownList([
            '0' => 'Строй вариант',
            '1' => 'Чистовая',
            '2' => 'Под ключ'
        ]); ?>
        
        <?= $form->field($model, 'term')->label('Срок сдачи')->dropDownList([
            '0' => 'Сдан',
            '1' => '2018',
            '2' => '2019',
            '3' => '2020',
            '4' => 'Позднее'   
             ], 
            ['prompt'=> 'Выберите срок сдачи'
            ]); ?>
    </div>
    
         
    <div class="col-md-2">
        <?= $form->field($model, 'rooms')->dropDownList([
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '11' => 'Студия'
            ]); ?>
        
       <?= $form->field($model, 'area')->textInput() ?>
       <?= $form->field($model, 'kitchen')->textInput() ?>
       <?= $form->field($model, 'floor')->textInput() ?> 
       <?= $form->field($model, 'floor_all')->textInput() ?>
      
    </div>
    
    <div class="col-md-2">
       <?//= $form->field($model, 'rooms')->textInput() ?>
       <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
       <?= $form->field($model, 'house')->textInput(['maxlength' => true]) ?>
       <?= $form->field($model, 'telephone')->textInput(['maxlength' => true])->label('Телефон')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '8(999)-999-9999',
        ]) ?>
         <?= $form->field($model, 'san_uzel')->label('Сан-узел')->dropDownList([
            '0' => 'Совмещенный',
            '1' => 'Раздельный',
             ], 
            ['prompt'=> 'Выберите тип сан-узла'
            ]); ?>
       
       <?= $form->field($model, 'balkon')->label('Лоджия/балкон')->dropDownList([
              '0' => 'Балкон',
              '1' => 'Лоджия',
              '2' => 'Нет', 
             ], 
            ['prompt'=> 'Выберите лоджию/балкон'
            ]); 
        ?>
    </div> 
  </div>
   <div class="row">   
       <div class="col-sm-2">
           <span class="cost sale">Цена (руб.)</span>
           <span class="cost arenda">Цена в месяц (руб.)</span>
           <span class="cost sutki">Цена в сутки (руб.)</span>
            <?= $form->field($model, 'price')->label(false)->textInput(['placeholder' => "руб."]) ?>
            <?= $form->field($model, 'ipoteka')->label(false)->checkbox(['label' => "Возможна ипотека", 'style'=>'transform: scale(1.4);margin-top: 10px; font-size:16px']) ?>
       </div>
   </div>
    
   <div class="row">   
       <div class="col-sm-9">
            <?= $form->field($model, 'description')->textarea(['rows' => 10, 'cols' => 50])->label('Описание'); ?>
       </div>
   </div>
    

    
    <div class="col-md-12">
       <?= $form->field($model, 'lat')->label(false)->hiddenInput(); ?>
       <?= $form->field($model, 'lng')->label(false)->hiddenInput(); ?>
       <?= $form->field($model, 'user_id')->label(false)->hiddenInput(); ?>
    </div>
     

    
    
        <div class="open-filter" id="place"  style="cursor: pointer; clear: both">Местопложение <i class="glyphicon glyphicon-chevron-down" aria-hidden="true"></i></div>
        <div class="filter">
            <div class="col-md-12" style="margin-top: 10px">
                <div id="map-canvas" style="height: 512px;"></div> 
            </div>
        </div>
   
     
    <div class="text-center" id="save" >
        <div class="col-md-12" style="margin-top:40px">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'in_but']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    
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
        center: new google.maps.LatLng(<?php echo $model->lat;?>, <?php echo $model->lng;?>)
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
script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCFroM8VHflBLVxuJVlb2GPCFR_W8oVBbk&callback=GoogleMap_init';
document.body.appendChild(script);


 </script>  
 
 <?= CityWidget::widget([]) ?>