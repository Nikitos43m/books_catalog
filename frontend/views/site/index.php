<?php
use dosamigos\google\maps\overlays\Polyline;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Carousel;
use yii\helpers\Html;


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

$this->title = 'My Yii Application';

$var = 123;
//начало многосточной строки, можно использовать любые кавычки
$script = <<< JS
    $(document).ready(function() {
    //alert( "ready!" );
    google.maps.event.addListener(marker, 'click', function() {

    alert('Спасибо, за правильный выбор');

});
});
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>

<div class="site-index">

    <? //if (!Yii::$app->user->isGuest): ?>
    <? //echo Html::a('Добавить на карту', ['apartament'], ['class' => 'btn btn-success']); ?><p></p>
    <? //endif; ?>

    <? if (Yii::$app->user->getId() == 9): ?>
        <?= Html::a('Добавить на карту', ['apartament'], ['class' => 'btn btn-success']); ?><p></p>
    <? endif; ?>

    <div style="text-align: center">
       <!-- <a class="buy_but" href="#">Разместить объявление</a>-->
        <?= Html::a('Разместить объявление', ['apartament_user'], ['class' => 'buy_but']); ?>
    </div>

    <?php

    $coord = new LatLng(['lat' => 47.231620, 'lng' => 39.695463]);
    $map = new Map([
        'center' => $coord,
        'zoom' => 12,
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
    foreach ($apartament as $apart){

        $mark = new Marker([
            'position' => new LatLng(['lat' => $apart["lat"], 'lng' => $apart["lng"]]),
            //'title' => Html::encode("{$apart["telephone"]}"),
            'title' => $apart["telephone"],
        ]);

        $mark->attachInfoWindow(
            new InfoWindow([
                'content' => Html::encode("{$apart["telephone"]}")
            ])
        );

        $map->addOverlay($mark);
    }
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
        <div class="row">
            <div class="col-lg-4">
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
