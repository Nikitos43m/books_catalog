<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url ;
use common\widgets\CityWidget;

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
/* @var $city_id integer*/
$session = Yii::$app->session;
$session->open();

$script = <<< JS
    
    $(document).ready(function() {
        $('#field-apartamentform-otdelka').hide();
        $(".field-apartamentform-type_appart").hide();
        $(".field-apartamentform-otdelka").hide();
        $(".field-apartamentform-term").hide();
        
        var tip;
        
        
        $("#apartamentform-type").change(function () {
        tip = $('#apartamentform-type :checked').val();
             if( tip == 0){
                $(".tip").show();
                $(".ipt").show();
        
                $(".cost").css('display','inline-block');
                $(".sale").show();
                $(".arenda").hide(); 
                $(".sutki").hide(); 
             }
        
             if( tip == 1){
                $(".tip").hide();
                $(".ipt").hide();
                $('#apartamentform-ipoteka').prop('checked', false);
             
                $("cost").css('display','inline-block');
                $(".arenda").show();
                $(".sale").hide(); 
                $(".sutki").hide(); 
             }
        
             if( tip == 2){
                $(".tip").hide();
                $(".ipt").hide();
                $('#apartamentform-ipoteka').prop('checked', false);
        
                $(".cost").css('display','inline-block');
                $(".sutki").show();
                $(".sale").hide(); 
                $(".arenda").hide(); 
             }
        
         });  
        
        var realty;
        
        $('#apartamentform-realty_type').change(function () {
         realty = $('#apartamentform-realty_type :checked').val();
        
         if( realty == 0){
              $(".field-apartamentform-type_appart").show();
              $("#balkon").show();

         } else{
              $("#balkon").hide();
              $('.btn.btn-default.form-check-label.bl.active').removeClass("active");
        
              $(".field-apartamentform-type_appart").hide();
              $(".field-apartamentform-otdelka").hide();
              $(".field-apartamentform-term").hide();
        
              $('.btn.btn-default.form-check-label.tp.active').removeClass("active");
              $('.btn.btn-default.form-check-label.ot.active').removeClass("active");
              $('.btn.btn-default.form-check-label.ss.active').removeClass("active");
           }
        
        
          if( realty == 2){
        
              $(".field-apartamentform-rooms").hide();
              $(".field-apartamentform-kitchen").hide();
              $('#apartamentform-kitchen').val('');
            //  $('#apartamentform-rooms').append($("<option></option>", {value:0, text: 0}));
            //  $('#apartamentform-rooms').val(0);
              $('.btn.btn-default.form-check-label.rms.active').removeClass("active");

          }else{
             // $('#apartamentform-rooms :last').remove();
              $(".field-apartamentform-rooms").show();
              $(".field-apartamentform-kitchen").show();
          }
        
         if( realty == 1){
        
            $(".field-apartamentform-floor").hide();
            $(".field-apartamentform-floor_all").hide();
            $('#apartamentform-floor').val(0);
            $('#apartamentform-floor_all').val(0);
         }else{
            $(".field-apartamentform-floor").show(); 
            $(".field-apartamentform-floor_all").show();
            $('#apartamentform-floor').val('');
            $('#apartamentform-floor_all').val('');
         }
        
    });  
        
        
        
   $('#apartamentform-type_appart').change(function () {
         vtor = $('#apartamentform-type_appart :checked').val();
         if( vtor == 1){
              $(".year").hide();
              $(".field-apartamentform-otdelka").show();
              $(".field-apartamentform-term").show();
         }else{
             $(".year").show();
             $(".field-apartamentform-otdelka").hide();
             $(".field-apartamentform-term").hide();
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
 <!--   
<div class="btn-group" data-toggle="buttons">

    <label class="btn btn-default active form-check-label">
        <input class="form-check-input" type="radio" checked autocomplete="off"> radio 1 (pre-checked)
    </label>

    <label class="btn btn-default form-check-label">
        <input class="form-check-input" type="radio" autocomplete="off"> radio 2
    </label>

    <label class="btn btn-default form-check-label">
        <input class="form-check-input" type="radio" autocomplete="off"> radio 3
    </label>

</div>
    -->
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-5">
        <?/*= $form->field($model, 'type')->label('Тип объявления')->dropDownList([
            '0' => 'Продать',
            '1' => 'Сдать',
            '2' => 'Посуточно'
            ],[
               'prompt' => 'Выберите тип объявления...'
              ]); 
       */ ?>
            
        <?= $form->field($model, 'type')->label('Тип объявления')->radioList([
            '0' => 'Продать',
            '1' => 'Сдать',
            '2' => 'Посуточно'
            ],
           ['class'=>'btn-group form-check-input',
             
              "data-toggle"=>"buttons",  
               
             'itemOptions'=>
                 ['labelOptions'=>[ 'class'=>'btn btn-default form-check-label'],
                  
                      
                 ],
              
               ]
           );
           ?>    
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <?/*= $form->field($model, 'realty_type')->label('Тип недвижимости')->dropDownList([
            '0' => 'Квартира',
            '1' => 'Дом',
            '2' => 'Комната'
            ],[
               'prompt' => 'Выберите тип недвижимости...'
              ]); 
             */?>
            
            <?= $form->field($model, 'realty_type')->label('Тип недвижимости')->radioList([
            '0' => 'Квартира',
            '1' => 'Дом',
            '2' => 'Комната'
            ],
           ['class'=>'btn-group form-check-input',
             
              "data-toggle"=>"buttons",  
               
             'itemOptions'=>
                 ['labelOptions'=>[ 'class'=>'btn btn-default form-check-label'],
                  
                      
                 ],
              
               ]
           );
           ?> 
        </div>
    </div>
    
    <div class="row tip">
        <div class="col-md-5">
            <?/*= $form->field($model, 'type_appart')->label('Тип квартиры')->dropDownList([
            '0' => 'Вторичка',
            '1' => 'Новостройка'
        ]); */ ?>
            
            <?= $form->field($model, 'type_appart')->label('Тип квартиры')->radioList([
             '0' => 'Вторичка',
             '1' => 'Новостройка'
            ],
           ['class'=>'btn-group form-check-input',
             
              "data-toggle"=>"buttons",  
               
             'itemOptions'=>
                 ['labelOptions'=>[ 'class'=>'btn btn-default form-check-label tp'],
                  
                      
                 ],
              
               ]
           );
           ?> 
        </div>

        
    </div>
    <div class="row">
        <div class="col-md-5">
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
              <?/*= $form->field($model, 'material')->label('Тип дома')->radioList([
             '0' => 'Кирпичный',
             '1' => 'Монолитный',
             '2' => 'Монолитно-кирпичный',
             '3' => 'Панельный',
             '4' => 'Блочный',
             '5' => 'Деревянный',
             '6' => 'Хрущевка',
             '7' => 'Сталинка',
            ],
           ['class'=>'btn-group form-check-input',
             
              "data-toggle"=>"buttons",  
               
             'itemOptions'=>
                 ['labelOptions'=>[ 'class'=>'btn btn-default form-check-label tp'],
                  
                      
                 ],
              
               ]
           );
           */?>
            
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-5 year">
            <?= $form->field($model, 'year')->label('Год постройки')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '9999',
            ]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-5">
            <?/*= $form->field($model, 'otdelka')->label('Отделка')->dropDownList([
            '0' => 'Строй вариант',
            '1' => 'Чистовая',
            '2' => 'Под ключ'
             ], 
            ['prompt'=> 'Выберите отделку'
            ]); */?>
            
            <?= $form->field($model, 'otdelka')->label('Отделка')->radioList([
              '0' => 'Строй вариант',
              '1' => 'Чистовая',
              '2' => 'Под ключ'
            ],
           ['class'=>'btn-group form-check-input',
             
              "data-toggle"=>"buttons",  
               
             'itemOptions'=>
                 ['labelOptions'=>[ 'class'=>'btn btn-default form-check-label ot'],
                  
                      
                 ],
              
               ]
           );
           ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-5">
            <?/*= $form->field($model, 'term')->label('Срок сдачи')->dropDownList([
            '0' => 'Сдан',
            '1' => '2018',
            '2' => '2019',
            '3' => '2020',
            '4' => 'Позднее'   
             ], 
            ['prompt'=> 'Выберите срок сдачи'
            ]); */?>
            
            <?= $form->field($model, 'term')->label('Срок сдачи')->radioList([
              '0' => 'Сдан',
              '1' => '2018',
              '2' => '2019',
              '3' => '2020',
              '4' => 'Позднее'
            ],
           ['class'=>'btn-group form-check-input',
             
              "data-toggle"=>"buttons",  
               
             'itemOptions'=>
                 ['labelOptions'=>[ 'class'=>'btn btn-default form-check-label ss'],
                  
                      
                 ],
              
               ]
           );
           ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-5">
           <?/*= $form->field($model, 'rooms')->label('Количество комнат')->dropDownList([
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '11' => 'Студия'
            ],[
            'prompt' => 'Выберите количество комнат...'
    ]); */?>
            <?= $form->field($model, 'rooms')->label('Количество комнат')->radioList([
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '11' => 'Студия'
            ],
           ['class'=>'btn-group form-check-input',
             
              "data-toggle"=>"buttons",  
               
             'itemOptions'=>
                 ['labelOptions'=>[ 'class'=>'btn btn-default form-check-label rms'],
                  
                      
                 ],
              
               ]
           );
           ?> 
        </div>
    </div>
    

            
    <div class="row">
        <div class="col-md-4">

            <?//= $form->field($model, 'rooms')->label('Количество комнат') ?>
            
            <?= $form->field($model, 'area')->label('Площадь в м<sup>2</sup>') ?>
            <?= $form->field($model, 'street')->label('Улица') ?>
            <?= $form->field($model, 'floor')->label('Этаж') ?>
            <?/*= $form->field($model, 'san_uzel')->label('Сан-узел')->dropDownList([
            '0' => 'Совмещенный',
            '1' => 'Раздельный',
             ], 
            ['prompt'=> 'Выберите тип сан-узла'
            ]); */?>
            
            <?= $form->field($model, 'san_uzel')->label('Сан-узел')->radioList([
              '0' => 'Совмещенный',
              '1' => 'Раздельный',
            ],
           ['class'=>'btn-group form-check-input',
             
              "data-toggle"=>"buttons",  
               
             'itemOptions'=>
                 ['labelOptions'=>[ 'class'=>'btn btn-default form-check-label ot'],
                  
                      
                 ],
              
               ]
           );
           ?>
            
        </div>
        

        
        <div class="col-md-4">
            <?= $form->field($model, 'kitchen')->label('Площадь кухни в м<sup>2</sup>') ?>
            <?= $form->field($model, 'house') ->label('Дом')?>
            <?= $form->field($model, 'floor_all')->label('Этажей в доме') ?>
            


            <?= $form->field($model, 'user_id')->hiddenInput(['value'=> Yii::$app->user->getId()])->label(false) ?>
            <?= $form->field($model, 'active')->hiddenInput(['value'=> 1])->label(false) ?>
            
           
        </div>
        <div class="col-md-4">
            
            
        </div>
    </div>
    <div class="row" id="balkon">
        <div class="col-md-4">
            <?= $form->field($model, 'balkon')->label('Лоджия/балкон')->radioList([
              '0' => 'Балкон',
              '1' => 'Лоджия',
              '2' => 'Нет',  
            ],
           ['class'=>'btn-group form-check-input',
             
              "data-toggle"=>"buttons",  
               
             'itemOptions'=>
                 ['labelOptions'=>[ 'class'=>'btn btn-default form-check-label bl'],
                  
                      
                 ],
              
               ]
           );
           ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <?=  $form->field($model, 'description')->textarea(['rows' => 5, 'cols' => 30])->label('Описание'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
    
            <?= $form->field($model, 'telephone')->label('Контактный телефон')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '8(999)-999-9999',
            ]) ?>
            
        </div>
    </div>
    
    <div class="row">
        <div style="font-weight: bold;border-bottom: 1px solid gainsboro;margin-bottom: 20px; margin-top: 20px;">Условия сделки</div>
        <div class="col-md-4">
            <span class="cost sale">Цена</span>
            <span class="cost arenda">Цена в месяц</span>
            <span class="cost sutki">Цена в сутки</span>
            
            <?= $form->field($model, 'price')->label(false)->textInput(['placeholder' => "руб."]) ?>
        </div>
        
        <div class="col-md-4 ipt">
            <?= $form->field($model, 'ipoteka')->label(false)->checkbox(['label' => "Возможна ипотека", 'style'=>'transform: scale(1.4);margin-top: 10px; font-size:16px']) ?>
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
        <?= $form->field($model, 'city_id')->label(false)->hiddenInput(['value'=>$session['my_city']]); ?>
    <div id="map-canvas" style="height: 512px;"></div> 
    </div>
</div>
    
 <script>
function GoogleMap_init () {

    var mapCanvas = document.getElementById('map-canvas');

    window.Map = new google.maps.Map(mapCanvas, {
        zoom: 12,
        scrollwheel: true,
        //center: new google.maps.LatLng(47.231620, 39.695463)
        center: new google.maps.LatLng(<?=$session['lat'] ?>,<?=$session['lng'] ?>)
    });

    var baseMarker = new google.maps.Marker({
      //position: new google.maps.LatLng(47.228492, 39.715496),
      position: new google.maps.LatLng(<?=$session['lat'] ?>,<?=$session['lng'] ?>),
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
    

    
    .wrap > .container{
        background-image: url(images/k.jpg);
    }
    
    .btn-default:active, .btn-default:focus, .btn-default:focus-within, .btn-default:hover, .btn-default.active, .open > .dropdown-toggle.btn-default {
        color: #828282;
        background-color: #12afc569;
        border-color: rgba(218, 218, 218, 0.4117647058823529);
        
    }
    
    .btn:focus, .btn:active:focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn.active.focus{
        outline: none;
    }
    
    .btn-default:active:hover, .btn-default.active:hover, .open > .dropdown-toggle.btn-default:hover, 
    .btn-default:active:focus, .btn-default.active:focus, .open > .dropdown-toggle.btn-default:focus, 
    .btn-default:active.focus, .btn-default.active.focus, .open > .dropdown-toggle.btn-default.focus{
        
        color: #828282;
        background-color: #12afc569;
        border-color: rgba(218, 218, 218, 0.4117647058823529);
    }
    

</style>

 <?= CityWidget::widget([]) ?>