<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Apartament */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Apartaments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
    <div style="text-align: center; font-size: 18px">
        <div class="row" style="margin-bottom: 30px">
            <div class="col-sm-2">
               Площадь:<span style="font-weight: bold"> <?=$model->area;?> м<sup>2</sup></span>
            </div>
            <div class="col-sm-2">
               Комнат: <?=$model->rooms;?>
            </div>
            <div class="col-sm-2">
                Этаж: <?=$model->floor;?>
            </div>
            <div class="col-sm-2">
                <?=$model->street;?>
                <?=$model->house;?>
            </div>
        </div>



    <div>
        
    </div>
</div>
    <div  class="info-view" style="width: 100%">
        <div style="float: right; font-size: 16px; border-bottom: 1px solid rgb(225, 225, 225);">
          <div style="width:300px; display: inline-block">
              <div class="col-md-12" style="margin-bottom: 10px"><span style="font-size: 20px;font-weight: 700;">
                       <?php
	                        $number = $model->price;
	                        $prise = number_format($number, 0, "", " ");
                        ?>
                      <?=$prise?></span><i class="glyphicon glyphicon-ruble" aria-hidden="true"></i>
                      <?php if ($model->type == 0): ?>
                          <? $month = $model->price/$model->area?>
                         <span style="font-size: 14px; color: gray; margin-left: 10px"> <?= floor($month) ?> &#x584;/м² </span>
                      <? endif;?>
              </div>
              <div class="col-md-12"><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>  Телефон: <?=$model->telephone;?></div>
          </div>
        </div>
    </div>
    <div>
        <div class="col-lg-3"><b>Описание</b></div>

    </div>
    <div class="col-md-9" style=" background: rgb(250, 250, 250); margin-top: 10px">

        <span style="font-size: 14px"> <? echo nl2br($model->description);?> </span>

    </div>


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

