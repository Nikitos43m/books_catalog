<?php
use dosamigos\google\maps\overlays\Polyline;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Carousel;
use yii\helpers\Html;

use yii\grid\GridView;

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
/* @var $apartament array*/

/* @var $searchModel app\models\ApartamentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Yii Application';

$var = 123;
//начало многосточной строки, можно использовать любые кавычки
$script = <<< JS
    
    $(document).ready(function() {
    //alert( "ready!" );
    // $('a').fancybox();    
});
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>

<style>
    tbody{
        display: none;
    }

    .site-index{
        background-image: url("images/k.jpg");
        padding-bottom: 100px;
    }
    
    #apartamentsearch-rooms label{
        margin-left: 15px;
    }

</style>

<div class="site-index">

    <? //if (!Yii::$app->user->isGuest): ?>
    <? //echo Html::a('Добавить на карту', ['apartament'], ['class' => 'btn btn-success']); ?><p></p>
    <? //endif; ?>

    <?// if (Yii::$app->user->getId() == 9): ?>
    <? if(Yii::$app->user->identity->username == "admin"): ?>
        <?//= Html::a('Добавить на карту', ['apartament'], ['class' => 'btn btn-success']); ?><p></p>
        <?= Html::a('Все объявления', ['/apartament/index'], ['class' => 'btn btn-success']); ?><p></p>
    <? endif; ?>

    <div style="text-align: center">
       <!-- <a class="buy_but" href="#">Разместить объявление</a>-->
        <?= Html::a('Разместить объявление <i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i>', ['apartament_user'], ['class' => 'buy_but']); ?>
    </div>

    <!-- <div style="text-align: center; margin-bottom: 7px;">
        <//?= Html::a('Квартиры в аренду', ['rent'], ['class' => 'main_but', 'id'=>'rent']); ?>
        <//?= Html::a('Квартиры в продаже', ['sale'], ['class' => 'main_but']); ?>
    </div> -->
    <div style="text-align: center; margin-bottom: 10px;">
        <div  class="open-filter" style="margin: 0 auto;width: 210px; font-size: 16px; cursor: pointer">
            Поиск по фильтрам &nbsp  <i class="glyphicon glyphicon-align-justify" aria-hidden="true" style="top: 3px;"></i>
        </div>
    </div>
    <div class="filter">
        <?php  echo $this->render('/apartament/_search_index', ['model' => $searchModel]); ?>
    </div>
    <?php
    $coord = new LatLng(['lat' => 47.231620, 'lng' => 39.695463]);
    $map = new Map([
        'center' => $coord,
        'zoom' => 12,
        'scrollwheel' => true,
    ]);


    // lets use the directions renderer
    /* $home = new LatLng(['lat' => 39.720991014764536, 'lng' => 2.911801719665541]);
     $school = new LatLng(['lat' => 39.719456079114956, 'lng' => 2.8979293346405166]);*/



    $rostov = new LatLng(['lat' => 47.2340996, 'lng' => 39.695069]);

    // setup just one waypoint (Google allows a max of 8)
    $waypoints = [
        // new DirectionsWayPoint(['location' => $rostov]),
        //  new DirectionsWayPoint(['location' => $mark])
    ];

    /* $directionsRequest = new DirectionsRequest([
         'origin' => $home,
         'destination' => $school,
         'waypoints' => $waypoints,
         'travelMode' => TravelMode::DRIVING
     ]);*/

    // Lets configure the polyline that renders the direction
    $polylineOptions = new PolylineOptions([
        'strokeColor' => '#FFAA00',
        'draggable' => true
    ]);

    // Now the renderer
    $directionsRenderer = new DirectionsRenderer([
        'map' => $map->getName(),
        'polylineOptions' => $polylineOptions
    ]);

    // Finally the directions service
    /*    $directionsService = new DirectionsService([
            'directionsRenderer' => $directionsRenderer,
            'directionsRequest' => $directionsRequest
        ]);*/

    // Thats it, append the resulting script to the map
    //   $map->appendScript($directionsService->getJs());

    // Lets add a marker now
    /*$mark = new LatLng(['lat' => 47.231620, 'lng' => 39.695463]);
    $marker = new Marker([
        'position' => $mark,
        'title' => 'My Home Town',
    ]);

    $home = new LatLng(['lat' => 47.197279, 'lng' => 39.6275719]);
    $marker_home = new Marker([
        'position' => $home,
        'title' => 'Dom',
        
    ]);*/

    // Provide a shared InfoWindow to the marker
    /*
    $marker->attachInfoWindow(
        new InfoWindow([
            'content' => '<p>This is my super cool content</p>'
        ])
    );

    $marker_home->attachInfoWindow(
        new InfoWindow([
            'content' => '<p>This is my home</p>'
        ])
    );
*/
    // Add marker to the map
    //$map->addOverlay($marker);
    //$map->addOverlay($marker_home);


    //Автоматическое добавление маркеров------------------------------------
    foreach ($dataProvider->models as $apart){
        $fimg="";
        $mark = new Marker([
            'position' => new LatLng(['lat' => $apart["lat"], 'lng' => $apart["lng"]]),
            //'title' => Html::encode("{$apart["telephone"]}"),
            'title' => $apart["telephone"],
            'icon' =>'images/point.png'
        ]);

        // Для вывода картинок объявления

        //$path = "uploads/p.".Html::encode("{$apart["user_id"]}")."/";
        $path = $apart['image_path'];
        //$path = "uploads/p.".Html::encode("{$apart["user_id"]}")."/".Html::encode("{$apart["area"]}{$apart["floor"]}{$apart["rooms"]}");

        
        //FANCYBOX Для фотографий
       
        echo newerton\fancybox\FancyBox::widget([
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
            ]);
        
        $images = scandir($path); // сканируем папку
        $images = preg_grep("/\.(?:png|gif|jpe?g)$/i", $images);
        foreach($images as $image) { // делаем проход по массиву
          //  $fimg .= "<img  width='100px' src='".$path.htmlspecialchars(urlencode($image))."' alt='".$image."' rel='fancybox' />";
          //$fimg .= Html::a(Html::img('".$path.htmlspecialchars(urlencode($image))."', ['width'=>'300px']), '".$path.htmlspecialchars(urlencode($image))."', ['rel' => 'fancybox']);
          
          //$fimg .= "<a href='".$path.htmlspecialchars(urlencode($image))."' rel='fancybox' onclick='alert(\" AAA! \"); return false;'><img src='".$path.htmlspecialchars(urlencode($image))."' width='100px' alt='".$image."'></a>";
           $fimg .= "<a href='".$path.htmlspecialchars(urlencode($image))."' rel='fancybox' onclick='message(\"".$path.htmlspecialchars(urlencode($image))."\"); return false;'><img src='".$path.htmlspecialchars(urlencode($image))."' width='100px' alt='".$image."'></a>";
        }
        
        //$fimg .= "<p class='kl'>CLICK ME</p>";
        
        $mark->attachInfoWindow(
            new InfoWindow([
                'content' =>
                             '<p>Цена: '.Html::encode("{$apart["price"]}"). ' руб.</p>'.
                             '<p>Площадь: '.Html::encode("{$apart["area"]}"). ' м<sup>2</sup></p>'.
                             '<p>Комнат: '.Html::encode("{$apart["rooms"]}"). '</p>'.
                             '<p>Этаж: '.Html::encode("{$apart["floor"]}"). '</p>'.
                             '<p>Адрес: '.Html::encode("{$apart["street"]}")." ".Html::encode("{$apart["house"]}"). '</p>'.
                             '<p>Телефон: ' .Html::encode("{$apart["telephone"]}").'</p>'.
                             '<p>'.$fimg.'</p>'
                            //  Html::a(Html::img('uploads/mas.jpg', ['width'=>'300px']), 'uploads/mas.jpg', ['rel' => 'fancybox'])
                          // '<a href="uploads/sant.jpg" rel="fancybox"><img src="uploads/sant.jpg" width="300px"></a>'

            ])
        );
                
        $map->addOverlay($mark);
       
    }
     //$js = "gmap0infoWindow = new google.maps.InfoWindow(); google.maps.event.addListener(gmap0infoWindow,'domready',function(){alert('YES!');});";
     //$map->appendScript($js);
   
   //----------------------------------------------------------------------
    // Now lets write a polygon
    $coords = [
        new LatLng(['lat' => 25.774252, 'lng' => -80.190262]),
        new LatLng(['lat' => 18.466465, 'lng' => -66.118292]),
        new LatLng(['lat' => 32.321384, 'lng' => -64.75737]),
        new LatLng(['lat' => 25.774252, 'lng' => -80.190262])
    ];

    $polygon = new Polygon([
        'paths' => $coords
    ]);

    // Add a shared info window
    $polygon->attachInfoWindow(new InfoWindow([
        'content' => '<p>This is my super cool Polygon</p>'
    ]));

    // Add it now to the map
    $map->addOverlay($polygon);


    // Lets show the BicyclingLayer :)
    $bikeLayer = new BicyclingLayer(['map' => $map->getName()]);

    // Append its resulting script
    $map->appendScript($bikeLayer->getJs());
    

    // Display the map -finally :)
    echo $map->display();

    ?>
    
    </div>
<script>
 function message(url){  
          //$('a').fancybox();
        $.fancybox(
            //'<h2>Hi!</h2><p>Content of popup</p>',
            '<img src="'+url+'">',
            {
                'autoDimensions'    : false,
                'width'             : 350,
                'height'            : 'auto',
                'transitionIn'      : 'none',
                'transitionOut'     : 'none',
            }
        );

        }
</script>
        <div class="row">
            <div class="col-lg-4">
                
                    <? echo Html::a(Html::img('uploads/mas.jpg', ['width'=>'300px']), 'uploads/mas.jpg', ['rel' => 'fancybox']); ?>
                    <? echo Html::a(Html::img('uploads/sant.jpg',['width'=>'300px']), 'uploads/sant.jpg', ['rel' => 'fancybox']); ?>
                    <a href='uploads/sant.jpg' rel='fancybox' onclick='message(); return false;'><img src='uploads/sant.jpg' width='300px'></a>
                <h2>Heading</h2>
           
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
