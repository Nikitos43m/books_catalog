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
/* @var $type_account integer */

//формирование title
 switch($model->type){ 
             case 0: 
                 $ap = 'Продается'; break;
             case 1:  
                 $ap = 'Сдается'; break; 
             case 2:  
                 $ap = 'Сдается посуточно'; break; 
         }
         
 switch($model->realty_type){ 
             case 0: 
                 $rt = 'квартира'; break;
             case 1:  
                 $rt = 'дом'; break; 
             case 2:  
                 $rt = 'комната'; break; 
         }
         

$this->title = $ap.' '.$rt.' '.$model->street.' '.$model->house;
$this->registerMetaTag([
  'name' => 'description',
  'content' => $model->description                     
]);

$this->params['breadcrumbs'][] = ['label' => 'Объявление №'.$model->id];

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

    <?php $path = $model->image_path;
       $images = scandir($path); // сканируем папку
       $images = preg_grep("/\.(?:png|gif|jpe?g)$/i", $images);

       foreach($images as $image) {
           $fimg .= "<a href='".$path.htmlspecialchars(urlencode($image))."' rel='fancybox' ><img class='photo-view' src='".$path.htmlspecialchars(urlencode($image))."' height='100px' alt='".$image."'></a>";
       }
    ?>
      
    <div style="text-align: center; margin-bottom: 20px; padding: 12px; background: rgba(242, 242, 242, 0.3215686274509804)">
        <?php if (!empty($images)): ?>
          <?=$fimg ?>
         <?else: ?>
         <h3>Нет фотографий</h3>
        <? endif;?> 
    </div>

    
    <div class="view_main">   
   
    <?php if ($model->type == 0): ?>
        <?php if ($model->type_appart == 0): ?>
        <div class="row" style="clear: both">
            <div class="col-md-12 text-center" style="margin-bottom: 10px;">
                <span class="view-title">Вторичка  <?php if (isset($model->year)): ?> (г. п.: <?=$model->year;?>)<? endif;?></span> 
                <span class="view-title"> <?=$model->street;?> <?=$model->house;?></span>
            </div>
        </div>
        <? elseif ($model->type_appart == 1): ?>
        <div class="row">
            <div class="col-md-12 text-center" style="margin-bottom: 10px;">
                <span class="view-title">Новостройка </span> <span class="view-title"><?=$model->street;?> <?=$model->house;?></span> <span class="view-title">
                           <?php switch($model->term): 
                                case 0:?>дом сдан<? break; ?>
                               <?php case 1:?>срок сдачи: 2018<? break; ?>
                               <?php case 2:?>срок сдачи: 2019<? break; ?>
                               <?php case 3:?>срок сдачи: 2020<? break; ?>
                               <?php case 4:?>срок сдачи: позднее 2020-го<?break;?>
                            <?php endswitch?>
                             </span>
            </div>
        </div>
        <? endif;?>
        <? else: ?>
           <div class="col-md-12 text-center" style="margin-bottom: 10px;">
              <span class="view-title"> <?=$model->street;?> <?=$model->house;?></span>
           </div>   
    <? endif;?> 
    
    <div class="left-view">
       
        <div class="row kom" style="">
            
            <div class="col-sm-4 col-xs-12">
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
            <span class="area view-area" style="font-size: 20px;"> <?=$model->area;?>м<sup>2</sup></span>
            </div>
            
            <?php if ($model->realty_type != 2): ?>
                <div class="col-sm-2 col-xs-6">
                    <?=$model->rooms;?>-комн.
                </div>
            <? endif;?>
            <?php if ($model->realty_type != 1): ?>
                <div class="col-sm-2 col-xs-6">
                    <?=$model->floor;?> из <?=$model->floor_all;?> этаж
                </div>
            <? endif;?>
         
            <div class="col-sm-3 col-xs-6">
                <?php $created_date = date('d-m-Y', $model->created_at); ?>
                <div class="view-date"><i class="glyphicon glyphicon-pushpin" aria-hidden="true"></i> Размещено: <?=$created_date ?> <br>
                    </div>
            </div>
            
            <div class="col-sm-1 col-xs-6" style="font-size: 14px; text-align: left">
                <i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> <?=$model->count_views ?> 
            </div>
       
            
        </div>
        

    <div>
        
    </div>
</div>
       
        
        
    <div  class="info-view" style="width: 100%">
        <div class="left-info" >
            <div class="right-box">
              <div class="col-md-12 text-center" style="margin-bottom: 10px;"><span  class="price_view">
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
                         <br><div style="font-size: 14px; color: gray; margin-left: 10px;"> <?= $month ?> &#x584;/м² </div>
                      <? endif;?>
                      <br>
                      <?php if ($model->ipoteka == true): ?>
                            <span style="font-weight: bold; font-size: 14px;">Возможна ипотека</span>
                      <? endif;?>
              </div>
              <div class="col-md-12" style="margin-bottom:10px"><i class="glyphicon glyphicon-earphone t_ph" aria-hidden="true"></i>  Телефон: <?=$model->telephone;?></div>
              <div class="col-md-12 text-center"> <span style="font-size:14px; color: grey">тип аккаунта:</span> <?php if ($type_account == 1): ?>
                    <b style="color: black">Собственник</b>
                    <? else: ?>
                    <b style="color: black">Агент</b>
                    <? endif;?>
               </div>
              <div class="col-md-12 col-xs-12 text-center" style="margin-top: 10px">
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
    
    <div class="col-lg-8 col-md-7 col-sm-10 description_view"  >
        <div class="row" style="margin-bottom: 15px; font-weight: bold; padding: 10px; box-shadow: 1px 0px 5px 1px #e6e6e6;">
            
            <?php if (isset($model->material)): ?>
            <div class="col-md-3 col-sm-3 col-xs-6 text-center opt" ><i class="glyphicon glyphicon-wrench" aria-hidden="true" style="font-size: 14px"></i>
                <?php switch($model->material): 
                    case 0:?> Кирпичный<? break; ?>
                   <?php case 1: ?> Монолитный<? break; ?>
                   <?php case 2: ?> Монолитно-кирпичный<? break; ?>
                   <?php case 3: ?> Панельный<? break; ?>
                   <?php case 4: ?> Блочный<? break; ?>
                   <?php case 5: ?> Деревянный<? break; ?>
                <?php endswitch ?>
            </div>
            <?endif;?>
            
             <?php if( isset($model->san_uzel)): ?>
            <div class="col-md-3 col-sm-3 col-xs-6 text-center opt" >
            <?php if ($model->san_uzel == 0): ?>
                     <i class="glyphicon glyphicon-tint" aria-hidden="true" style="font-size: 14px"></i>  Совмещенный с/у 
                   <?else: ?>
                     <i class="glyphicon glyphicon-tint" aria-hidden="true" style="font-size: 14px"></i>  Раздельный с/у 
            <?endif;?>
            </div>
            <?endif;?>
            
            <?php if (isset($model->kitchen)): ?>
            <div class="col-md-3 col-sm-3 col-xs-6 text-center opt">
                <i class="glyphicon glyphicon-cutlery" aria-hidden="true" style="font-size: 14px"></i> кухня <span class="kitch"> <?=$model->kitchen;?>м<sup>2</sup></span>
            </div>
            <?endif;?>
            
            <?php if( isset($model->balkon)): ?>
            <div class="col-md-3 col-sm-3 col-xs-6 text-center opt">
                
                <?php switch($model->balkon): 
                    case 0:?> Есть балкон<? break; ?>
                   <?php case 1: ?>Есть лоджия<? break; ?>
                   <?php case 2: ?> Балкона/лоджии нет<? break; ?>
                <?php endswitch ?>
            </div>
            <?endif;?>
            
        </div>
        <?php if( !empty($model->description)): ?>
            <span style="font-size: 14px"> <? echo nl2br($model->description);?> </span>
        <? else: ?>
             <span style="color: dimgrey; font-size: 13px; margin-left: 15px;"> Описание отсутствует </span>
        <?endif;?>
    </div>
    </div>
    <style>
   @media(max-width:768px) {
        .kom{
            clear: both;
            background: white;
        }
    }
    
    @media (max-width: 1550px){
        .view_main{
           width: 80%;
           margin: 0 auto;
        }
        
        .left-info{
            padding: 10px;
        }
    }
    @media (max-width: 768px) {
    
        .view_main{
            width: 100%;
        }
        
        .opt{
            height: 40px;
        }
    }
    
    
/*    @media (min-width: 1200px){
       .col-lg-9 {
          width: 66,6%; 
        }
    }*/
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
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCFroM8VHflBLVxuJVlb2GPCFR_W8oVBbk&callback=GoogleMap_init';
        document.body.appendChild(script);


    </script>
    <div class="col-md-12">
        <div id="map-canvas" style="height: 512px; margin-top: 30px"></div>
    </div>

</div>

 <?= CityWidget::widget([]) ?>