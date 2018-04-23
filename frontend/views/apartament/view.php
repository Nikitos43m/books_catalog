<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use common\widgets\CityWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Apartament */
/* @var $model2 app\models\User */
/* @var $form ActiveForm */
/* @var $arr_ads array */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Apartaments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$session = Yii::$app->session;
$session->open();
?>

<div class="apartament-view">

    <h1><?//= Html::encode($this->title) ?></h1>

   <?=newerton\fancybox\FancyBox::widget([
       'target' => 'a[rel=fancybox]',
       'helpers' => true,
       'mouse' => true,
       'config' => [
           'maxWidth' => '90%',
           'maxHeight' => '90%',
           'playSpeed' => 7000,
           'padding' => 0,
           'fitToView' => false,
           'width' => '70%',
           'height' => '70%',
           'autoSize' => false,
           'closeClick' => false,
           'openEffect' => 'elastic',
           'closeEffect' => 'elastic',
           'prevEffect' => 'elastic',
           'nextEffect' => 'elastic',
           'closeBtn' => false,
           'openOpacity' => true,
           'helpers' => [
               'title' => ['type' => 'float'],
               'buttons' => [],
               'thumbs' => ['width' => 68, 'height' => 50],
               'overlay' => [
                   'css' => [
                       'background' => 'rgba(0, 0, 0, 0.8)'
                   ]
               ]
           ],
       ]
   ]); ?>

    <?/*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'street',
            'house',
            'rooms',
            'floor',
            'area',
            'price',
            'telephone',
            'lat',
            'lng',
            'user_id',
        ],
    ]) */?>

    <? $path = $model->image_path;
       $images = scandir($path); // сканируем папку
       $images = preg_grep("/\.(?:png|gif|jpe?g)$/i", $images);

       foreach($images as $image) {
           $fimg .= "<a href='".$path.htmlspecialchars(urlencode($image))."' rel='fancybox' ><img class='photo-view' src='".$path.htmlspecialchars(urlencode($image))."' height='100px' alt='".$image."'></a>";
       }
    ?>
      
    <div style="text-align: center; margin-bottom: 40px; padding: 12px; background: rgba(242, 242, 242, 0.3215686274509804)">
        <?=$fimg ?>
    </div>
    
    <?php if ($model->type == 0): ?>
        <?php if ($model->type_appart == 0): ?>
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 20px; font-size: 18px; color: gray">
                <span class="view-title">Вторичка</span> <span class="term"> <?php if (isset($model->year)): ?> (год постройки: <?=$model->year;?>)<? endif;?></span>
            </div>
        </div>
        <? elseif ($model->type_appart == 1): ?>
            <div class="row">
            <div class="col-md-12" style="margin-bottom: 20px; font-size: 18px; color: gray">
                <span class="view-title">Новостройка </span> <span class="term"> (
                                <?php switch($model->term): 
                                case 0:?>дом сдан <? break; ?>
                               <?php case 1: ?>срок сдачи:  2018<? break; ?>
                               <?php case 2: ?>срок сдачи:  2019<? break; ?>
                               <?php case 3: ?>срок сдачи:  2020<? break; ?>
                               <?php case 4: ?>срок сдачи:  позднее 2020-го <? break; ?>
                            <?php endswitch ?>
                               )
                             </span>
            </div>
        </div>
        <? endif;?>
    <? endif;?> 
    
    <div  style="text-align: center; font-size: 18px">
        <div style="float: left">
         <?php switch($model->type): 
             case 0:?> Продается <? break; ?>
            <?php case 1: ?> Сдается <? break; ?>
            <?php case 2: ?> Сдается посуточно <? break; ?>
         <?php endswitch ?>
            
           <?php switch($model->realty_type): 
             case 0:?> квартира <? break; ?>
            <?php case 1: ?> дом <? break; ?>
            <?php case 2: ?> комната <? break; ?>
         <?php endswitch ?> 
            <span class="area" style="font-size: 20px; font-weight: bold"> <?=$model->area;?>м<sup>2</sup></span>
         </div>
        <div class="row kom" style="margin-bottom: 30px">
            
            <?php if ($model->realty_type != 2): ?>
                <div class="col-sm-2">
                    <?=$model->rooms;?>-комн.
                </div>
            <? endif;?>
            <?php if ($model->realty_type != 1): ?>
                <div class="col-sm-2">
                    <?=$model->floor;?> из <?=$model->floor_all;?> этаж
                </div>
            <? endif;?>
            <div class="col-sm-2">
                <?=$model->street;?>
                <?=$model->house;?>
            </div>
            <div class="col-sm-2">
                <?php $created_date = date('d-m-Y', $model->created_at); ?>
                <div class="view-date"><i class="glyphicon glyphicon-pushpin" aria-hidden="true"></i> Размещено: <?=$created_date ?> </div> 
            </div>
            
            <div class="col-sm-2">
                <div class="view-date"> Просмотров: <?=$model->count_views ?> </div>
                 
            </div>
        </div>
        

    <div>
        
    </div>
</div>
    <div  class="info-view" style="width: 100%">
        <div style="float: right; font-size: 16px; border-bottom: 1px solid rgb(225, 225, 225);">
          <div style="width:270px; display: inline-block; padding: 10px;">
              <div class="col-md-12" style="margin-bottom: 10px"><span  class="price_view">
                       <?php
	                    $number = $model->price;
	                    $prise = number_format($number, 0, "", " ");
                             
                        ?>
                      <?=$prise?><i class="glyphicon glyphicon-ruble" aria-hidden="true" style="font-size: 14px"></i></span>
                       <?php if ($model->type == 2): ?>
                      <b>в сутки</b>
                       <? endif;?>
                      
                      <?php if ($model->type == 0): ?>
                          <?php $month = $model->price/$model->area; $month = number_format($month, 0, "", " ") ?>
                         <br><div style="font-size: 14px; color: gray; margin-left: 10px; margin-top: 20px"> <?= $month ?> &#x584;/м² </div>
                      <? endif;?>
              </div>
              <div class="col-md-12" style="margin-top: 20px"><i class="glyphicon glyphicon-earphone t_ph" aria-hidden="true"></i>  Телефон: <?=$model->telephone;?></div>

              <div class="col-md-12 col-xs-12" style="margin-top: 10px">
              <?php if ($model->getAuthorId() == Yii::$app->user->id): ?>
                  <span style="color: grey; font-size: 13px;">Ваше объявление</span>
              <? else: ?>
              
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?php if (in_array($model->id ,$arr_ads)): ?>
                        <span style="color: grey; font-size: 13px;">Вы сохранили данное объявление</span>
                    <? else: ?>
                        <?php $form = ActiveForm::begin();?>
                        <?= $form->field($model2, 'my_appart')->hiddenInput(['value'=> $model->id])->label(false) ?>
                        <?= Html::submitButton('<i class="glyphicon glyphicon-heart" aria-hidden="true"></i> Сохранить', ['class' => 'in_but']) ?>
                        <?php ActiveForm::end(); ?>

                    <? endif;?>
                <? endif;?>
                
              <? endif;?>
              </div>
          </div>
        </div>
    </div>
    <div>
        <div class="col-md-3" style="font-size: 16px"><b>Описание</b></div>

    </div>
    <div class="col-lg-9 col-md-8 col-sm-10 description_view"  >

        <span style="font-size: 14px"> <? echo nl2br($model->description);?> </span>

    </div>
    <style>
   @media(max-width:768px) {
        .kom{
            clear: both;
            background: white;
        }
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
                draggable: false,
                icon :'images/point.png'
            });

        }

        // Google Maps loading
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.async = true;
        script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=GoogleMap_init';
        document.body.appendChild(script);


    </script>
    <div class="col-md-12">
        <div id="map-canvas" style="height: 512px; margin-top: 30px"></div>
    </div>

</div>

 <?= CityWidget::widget([]) ?>