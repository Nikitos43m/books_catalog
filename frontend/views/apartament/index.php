<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
/* @var $searchModel app\models\ApartamentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apartaments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apartament-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Apartament', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'user_id',
            'type',
            'street',
            'house',
            'rooms',
             'floor',
             'area',
             'price',
             'telephone',
            'active',
            // 'lat',
           //  'lng',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <div class="row">

        <?php

        $coord = new LatLng(['lat' => 47.231620, 'lng' => 39.695463]);
        $map = new Map([
            'center' => $coord,
            'zoom' => 12,
        ]);

        foreach ($dataProvider->models as $apart) {
           // $fimg = "";
            $mark = new Marker([
                'position' => new LatLng(['lat' => $apart["lat"], 'lng' => $apart["lng"]]),
                //'title' => Html::encode("{$apart["telephone"]}"),
                'title' => $apart["telephone"],
            ]);
            $map->addOverlay($mark);
        }

        echo $map->display();
        ?>
        
</div>
