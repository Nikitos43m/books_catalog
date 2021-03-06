<?php
use dosamigos\google\maps\overlays\Polyline;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
//use yii\grid\GridView;
use kartik\grid\GridView;


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
/* @var $form yii\bootstrap\ActiveForm */
/* @var $this yii\web\View */
/* @var $apartament array*/

/* @var $searchModel app\models\ApartamentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $count integer*/
/* @var $location_arr array*/
/* @var $model \frontend\models\CityForm */
/* @var $regions_list array*/
/* @var $lat double*/
/* @var $lng double*/
/* @var $pages integer*/
$session = Yii::$app->session;
$session->open();

$this->title = 'Квартиры в Ростове-на-Дону';
$this->registerMetaTag([
  'name' => 'og:title',
  'content' => 'Квартиры в Ростове-на-Дону'                     
]);

$this->registerMetaTag([
  'name' => 'description',
  'content' => 'Размещение бесплатных объявлений о продаже и аренде квартир. Удобный интерфейс для поиска жилья по фильтрам и карте.'                     
]);

$this->registerMetaTag([
  'name' => 'og:description',
  'content' => 'Размещение бесплатных объявлений о продаже и аренде квартир. Удобный интерфейс для поиска жилья по фильтрам и карте.'                     
]);

$this->registerMetaTag([
  'name' => 'keywords',
  'content' => 'недвижимость, квартиры, купить квартиру, снять квартиру, новостройки, квартиры в новостройках'                     
]);

$this->registerMetaTag([
  'name' => 'og:keywords',
  'content' => 'недвижимость, квартиры, купить квартиру, снять квартиру, новостройки, квартиры в новостройках'                     
]);

$var = 123;
//начало многосточной строки, можно использовать любые кавычки
$script = <<< JS
    
    $(document).ready(function() {
    // $('a').fancybox();     
    // $('#myModal').modal('show');
    
    /*
            if ($.cookie("modal_shown") == null) {
              
                $('#myModal').modal('show');
              
              $.cookie('modal_shown', 'true', { expires: 365, path: '/' });
            }
    */    
               // else {alert($.cookie("modal_shown"));}

         $('#m1').click(function(){
            $('html,body').animate({scrollTop:$('#service').offset().top}, 500);
         });
        
         $('#m2').click(function(){
            $('html,body').animate({scrollTop:$('#contacts').offset().top}, 500);
         });
});


JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);



?>

<style>

    .site-index{
        background-image: url("images/k.jpg");
        padding-bottom: 10px;
        margin-left: -15px;
        margin-right: -15px;
    }
    
    #apartamentsearch-rooms label{
        margin-left: 15px;
    }

    #w1{
        box-shadow: 0px 0px 6px 5px rgba(0, 0, 0, 0.14);
    }
    
    .wrap {
      min-height: unset;
    }
    
    tbody {
/*        background: url(../images/34.jpg);*/
        background-size: cover;
    }

    tr{
        box-shadow: 0px 0px 1px rgba(62, 62, 62, 0.14);
    }
    
    .btn-default:hover, .btn-default:active, .btn-default:focus{
        background-color: white;
    }
    
    .table > tbody > tr > td{
        padding: 8px 6px;
    }
    
   
    
    @media (max-width: 1200px) {
       .table > tbody > tr > td{
          padding: 0;
       }
    }
    
     @media (max-width: 768px){
        .table > tbody > tr > td{
          padding: 8px 6px;
       }
    }
</style>

<div class="site-index">
    
<!-- <a href="#myModal" class="btn btn-primary" data-toggle="modal">Выбрать город</a> -->
    <? //if (!Yii::$app->user->isGuest): ?>
    <? //echo Html::a('Добавить на карту', ['apartament'], ['class' => 'btn btn-success']); ?><p></p>
    <? //endif; ?>

    <?// if (Yii::$app->user->getId() == 9): ?>
    <? if(Yii::$app->user->identity->username == "admin"): ?>
        <?//= Html::a('Добавить на карту', ['apartament'], ['class' => 'btn btn-success']); ?><p></p>
        <?= Html::a('Все объявления', ['/apartament/index'], ['class' => 'btn btn-success']); ?><p></p>
    <? endif; ?>

    <div class="for-mobile" style="text-align: center">
       <!-- <a class="buy_but" href="#">Разместить объявление</a>-->
        <?php if (Yii::$app->user->isGuest): ?>
            <?= Html::a('Разместить объявление', ['/site/login'], ['class' => 'buy_but']); ?>
        <?php endif; ?>

        <?php if ((!Yii::$app->user->isGuest) && ($count == 0)): ?>
                <?= Html::a('Разместить объявление', ['apartament_user'], ['class' => 'buy_but']); ?>

        <?php endif; ?>
    </div>
    
<section class="complex_v">
    <div class="container back" style="">
        <div class="text-center main-text" >
    
             <?php  echo $this->render('/apartament/_search_index', ['model' => $searchModel]); ?>
        </div>
        
        <div id='zk' style="">
            <div style="text-align: left">
                <img style="float: left" src="images/logo-ek.png" width="60px">
                <h3 style="color: white">ЖК Екатериниский</h3>
                <p style="color: white">Квартиры от 1,2 млн рублей</p>
                <div class="for-link">
                    <a href="https://xn--80ajbbnaaicbe8ab2btj.com/" target="_blank" class="link-c">Выбрать квартиру</a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container gr-table">
    <?= GridView::widget([
        'dataProvider' => $dataProviderTable,
       // 'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-hover main-table',
        ],
        
        'exportConfig' => [
            GridView::CSV => [],
            GridView::EXCEL => [],
            //GridView::TEXT => [],
        ],
        
        'export' =>[
            'label' => 'Экспорт',
            'header' => '<li role="presentation" class="dropdown-header">Экспортировать данные:</li>.',
            'showConfirmAlert' => false
        ],



        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            // 'id',
           // 'user_id',

            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'expandAllTitle' => 'Expand all',
                'collapseTitle' => 'Collapse all',
                'expandIcon'=>'<i class="glyphicon glyphicon-camera" aria-hidden="true" style="color: rgb(49, 47, 47)"></i>',
                'collapseIcon' =>'<i class="glyphicon glyphicon-chevron-up" aria-hidden="true" style="color: rgb(49, 47, 47)"></i>',
                'detailRowCssClass' => GridView::ICON_ACTIVE,
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail'=>function ($model, $key, $index, $column) {
                    //$val = "<div class='col-md-4'> <b>Телефон: </b>".$model->telephone."</div>";
                    return Yii::$app->controller->renderPartial('_view.php', ['model'=>$model]);

                   /* foreach ($model as $value){
                        echo "{$value} ";
                    }*/
                    
                   /* $fimg="";
                    $path = $model->image_path;

                    $images = scandir($path); // сканируем папку
                    $images = preg_grep("/\.(?:png|gif|jpe?g)$/i", $images);

                    foreach($images as $image) {
                        $fimg .= "<a href='".$path.htmlspecialchars(urlencode($image))."' rel='fancybox' ><img class='photo-view' src='".$path.htmlspecialchars(urlencode($image))."' height='100px' alt='".$image."'></a>";
                       // $fimg .= "<a href='".$path.htmlspecialchars(urlencode($image))."'  onclick='message(\"".$path.htmlspecialchars(urlencode($image))."\"); return false;'><img class='photo-view' height='130px' src='".$path.htmlspecialchars(urlencode($image))."' height='40px' alt='".$image."'></a>";
                    }


                    return $fimg;*/
                },

            ],

            [
                'attribute'=>'type',
                'contentOptions'=>['class'=>'table_first','style'=>'width: 10%'],
                'content'=>function($model){

                    switch ($model->type){
                        case 0: $text = 'Продается'; break;
                        case 1: $text = 'Сдается'; break;
                        case 2: $text = 'Сдается посуточно'; break;
                    }

                    switch ($model->realty_type){
                        case 0: $appart = 'квартира'; break;
                        case 1: $appart = 'дом'; break;
                        case 2: $appart = 'комната'; break;
                    }

                    return $text." ".$appart;
                }
            ],

            [
                'attribute'=>'rooms',
                'label' => 'Комнат',
                // 'contentOptions'=>['class'=>'table_class','style'=>'display:block;'],
                'content'=>function($model){

                    return "<div style='font-weight: bold'>".$model->rooms."-комн.</div>";
                }
            ],

            [
                'attribute'=>'area',
                 'contentOptions'=>['class'=>'table_area'],
                'content'=>function($model){
                    return "<div class='area'>".$model->area."м<sup>2</sup></div>";
                }
            ],

            [
                'attribute'=>'street',
                'label' => false,
                //'contentOptions'=>['class'=>'table_class','style'=>'display:block;'],
                'content'=>function($model){
                    return $model->street." ".$model->house;
                }
            ],

            //'street',
            //'house',
            //'rooms',
            //'floor',

            [
                'attribute'=>'floor',
                //'contentOptions'=>['class'=>'table_class','style'=>'display:block;'],
                'content'=>function($model){
                    if($model->realty_type != 1){
                        return '<span class="tel">'.$model->floor." из ".$model->floor_all." этаж</span>";
                    }else{ return '-';}
                }
            ],
            //'area',



            //'price',

            [   'attribute' => 'price',
                'label' => 'Цена',
                'contentOptions' =>['class' => 'table_price'],
                'content' => function($model){
                    $number = $model->price;
                    $prise = number_format($number, 0, "", " ");
                    return "<div class='price_format'>".$prise."<i class=\"glyphicon glyphicon-ruble\" aria-hidden=\"true\"></i> </div>";
                }
            ],

            //'telephone',
             
             [  'attribute' => 'telephone',
                'label' => 'Контактный телефон',
                'content' => function($model){
                    
                    return '<i class="glyphicon glyphicon-earphone t_ph" aria-hidden="true"></i> <span class="tel">'.$model->telephone.'</span>';
                }
            ],        
                    
             
          /*  [
                'attribute' => 'created_at',
                'label'=>'Размещено',
                'format' =>  ['date', 'd.MM.Y'],

            ], */
                    
            [   'attribute' => 'created_at',
                'label' => 'Размещено',
                'content' => function($model){
                    
                    return '<i class="glyphicon glyphicon-calendar" aria-hidden="true" ></i> '.date('d.m.Y', $model->created_at);
                }
            ],    


            //['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{open}',
                'buttons' => [
                    'open' => function ($url,$model) {
                        if(Yii::$app->user->isGuest){
                            return Html::a("открыть ", ["/apartament/viewguest", "id"=>$model->id], ['class' => 'open_but']);
                        }else{
                            return Html::a("открыть ", ["/apartament/view", "id"=>$model->id], ['class' => 'open_but']);
                        }
                    },
                ],
            ],        
                    
        ],

        
        'pjax' => true,
        'bordered' => false,
        'striped' => false,
        'responsive' => true,
        'panel' => [
            'type' => GridView::TYPE_ACTIVE,
        ],

        'toggleDataOptions' => [
            'all' => [
                 'icon' => 'resize-full' ,
                'label' => 'Показать все',
                'class' => 'btn btn-default' ,
                'title' => 'Показать все данные'
            ],
            
            'page' => [
                'icon' => 'resize-small',
                'label' => '1-ая страница',
                'class' => 'btn btn-default',
                'title' => 'Показать первую страницу'
            ],
            
        ]

    ]);?>
</div>    

   <!-- <div style="text-align: center; margin-bottom: 10px;">
        <div  class="open-filter clear">

            <span> Поиск по фильтрам &nbsp </span>
                        <div class="menu" style="float:right">
                            <span class="menu-global menu-top" style="top:6px; border-top: 1px solid rgb(24, 131, 208);"></span>
                            <span class="menu-global menu-middle" style="border-top: 1px solid rgb(24, 131, 208);"></span>
                            <span class="menu-global menu-bottom" style="top:18px; border-top: 1px solid rgb(24, 131, 208);"></span>
                        </div>
        </div>
    </div>
    <div class="filter">
        <?php // echo $this->render('/apartament/_search_index', ['model' => $searchModel]); ?>
    </div>
-->
    <?php
    //$coord = new LatLng(['lat' => 47.231620, 'lng' => 39.695463]);
    //$coord = new LatLng(['lat' => $location_arr['lat'], 'lng' => $location_arr['lng']]);
    $coord = new LatLng(['lat' => $lat, 'lng' => $lng]);
    
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



    //Автоматическое добавление маркеров------------------------------------
    foreach ($dataProvider->models as $apart){
        $fimg="";
        $mark = new Marker([
            'position' => new LatLng(['lat' => $apart["lat"], 'lng' => $apart["lng"]]),
            //'title' => Html::encode("{$apart["telephone"]}"),
            'title' => $apart["telephone"],
            'icon' =>'images/circle.png'
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
          
          //$fimg .= "<a href='".$path.htmlspecialchars(urlencode($image))."' rel='fancybox' ><img src='".$path.htmlspecialchars(urlencode($image))."' width='100px' alt='".$image."'></a>";
           $fimg .= "<a href='".$path.htmlspecialchars(urlencode($image))."' style='width:170px'  onclick='message(\"".$path.htmlspecialchars(urlencode($image))."\"); return false;'><img src='".$path.htmlspecialchars(urlencode($image))."' height='40px' alt='".$image."'></a>";
        }
        
        //$fimg .= "<p class='kl'>CLICK ME</p>";
        $price = number_format($apart['price'], 0, "", " ");
        
        $room = 'комн.';
        if($apart['rooms'] == 11 ){
            $apart['rooms'] = 'Студия';
            $room = '';
        }
        
        if(Yii::$app->user->isGuest){
            $button_info = Html::a("Открыть <i class='glyphicon glyphicon-share' aria-hidden='true'></i>", ["/apartament/viewguest", "id"=>$apart->id],  
                                    ['class' => 'open_but', 'style' => 'float:right']);
        }else{
            $button_info = Html::a("Открыть", ["/apartament/view", "id"=>$apart->id],  
                                    ['class' => 'open_but', 'style' => 'float:right']);
        }
        
        
        if ($apart['realty_type'] == 0){
               
            $mark->attachInfoWindow(
                new InfoWindow([
                    'content' => '<div style="max-width:350px; padding: 12px 0px;"> '.
                                     '<div class="attach-title">Квартира</div> 
                                    <div class="col-xs-6"> '.
                                        '<p><b>'.Html::encode("{$price}"). ' руб.</b></p>'.
                                        '<p><b>'.Html::encode("{$apart["area"]}"). ' м<sup>2</sup></b></p>'.
                                        '<p><b>'.Html::encode("{$apart["rooms"]}").' '.$room.'</b></p>'.
                                    '</div>'.
                                    '<div class="col-xs-6"> '.
                                        '<p>'.Html::encode("{$apart["floor"]}").' этаж </p>'.
                                        '<p>'.Html::encode("{$apart["street"]}")." ".Html::encode("{$apart["house"]}"). '</p>'.
                                        '<p><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i> ' .Html::encode("{$apart["telephone"]}").'</p>'.
                                    '</div>'.                   
                                 '<div class="col-md-12 info-wind">'.$fimg.'</div>'.
                                              $button_info  
                                 . '</div>'

                ])
            );
                                    
        }elseif ($apart['realty_type'] == 1) {
            $mark->attachInfoWindow(
                new InfoWindow([
                    'content' => '<div style="max-width:350px; padding: 12px 0px;"> '.
                                    '<div class="attach-title">Дом</div> 
                                    <div class="col-xs-6"> '.
                                        '<p><b>'.Html::encode("{$price}"). ' руб.</b></p>'.
                                        '<p><b>'.Html::encode("{$apart["area"]}"). ' м<sup>2</sup></b></p>'.
                                        '<p><b>'.Html::encode("{$apart["rooms"]}").' '.$room.'</b></p>'.
                                    '</div>'.
                                    '<div class="col-xs-6"> '.
                                        '<p>'.Html::encode("{$apart["street"]}")." ".Html::encode("{$apart["house"]}"). '</p>'.
                                        '<p><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i> ' .Html::encode("{$apart["telephone"]}").'</p>'.
                                    '</div>'.                   
                                 '<div class="col-md-12 info-wind">'.$fimg.'</div>'.
                                              $button_info  
                                 . '</div>'

                ])
            );
        
        } elseif ($apart['realty_type'] == 2) {
             $mark->attachInfoWindow(
                new InfoWindow([
                    'content' => '<div style="max-width:350px; padding: 12px 0px;"> '.
                                    '<div class="attach-title">Комната</div> 
                                    <div class="col-xs-6"> '.
                                        '<p><b>'.Html::encode("{$price}"). ' руб.</b></p>'.
                                        '<p><b>'.Html::encode("{$apart["area"]}"). ' м<sup>2</sup></b></p>'.
                                    '</div>'.
                                    '<div class="col-xs-6"> '.
                                        '<p>'.Html::encode("{$apart["floor"]}").' этаж </p>'.
                                        '<p>'.Html::encode("{$apart["street"]}")." ".Html::encode("{$apart["house"]}"). '</p>'.
                                        '<p><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i> ' .Html::encode("{$apart["telephone"]}").'</p>'.
                                    '</div>'.                   
                                 '<div class="col-md-12 info-wind">'.$fimg.'</div>'.
                                              $button_info  
                                 . '</div>'

                ])
            );
        
        } 
        
        
        
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

    

    ?>
    
    </div>
<section class="mobile_list">
    <div class="container">
       <?php  echo $this->render('/apartament/_m_list', ['model' => $searchModel, 'pages'=>$pages, 'provider'=>$dataProviderTable]); ?>
    </div>
</section>
<section>
    <div class="container"><? echo $map->display(); ?></div>
</section>
<script>
 function message(url){  
          //$('a').fancybox();
        $.fancybox(
            //'<h2>Hi!</h2><p>Content of popup</p>',
            '<img style="max-width:500px; height: auto;" src="'+url+'">',
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


    </div>
</div>




<section class="complex">
    <div class="container" >
        <div class="text-center">
            <h2 class="main-complex">Жилые комплексы Вашего города</h2>
            <?=Html::a("Открыть", ['site/complex'], ['class' => 'btn contact-modal complex-but'])?>
        </div>
       <?php /*echo Carousel::widget([
        'items' => [

            ['content' => '<img src="../web/images/1.jpg"/>'],
        ['content' => '<img src="../web/images/2.jpg"/>'],

        ]
        ]);
       */?>
    </div>
</section>

<div class="container steps" style="width: 100%">
    <div class="row ad" >
        <div class="text-center"><h2 class="main-title">Размещение объявления</h2></div>
    </div>
    <div class="steps-md">
    
        <div class="col-sm-6 col-md-5 col-xs-12">

            <?// echo Html::a(Html::img('uploads/mas.jpg', ['width'=>'300px']), 'uploads/mas.jpg', ['rel' => 'fancybox']); ?>
            <?// echo Html::a(Html::img('uploads/sant.jpg',['width'=>'300px']), 'uploads/sant.jpg', ['rel' => 'fancybox']); ?>
            <!-- <a href='uploads/ban1.jpg'  rel="fancybox"><img src='uploads/ban1.jpg' width='300px'></a> -->
            <div class="howto-label"><div>1</div></div><h3>Зарегистрируйтесь</h3>

            <p>Пройдите быструю регистрацию, чтобы размещать объявления и сохранять понравившееся при поиске</p>

        </div>
        <div class="col-sm-6 col-md-5 col-xs-12">
            <div class="howto-label"><div>2</div></div><h3> Заполните форму</h3>
            <p>Продать/сдать, кол-во комнат, площадь и т.д.</p>
        </div>
        
        <div class="col-sm-6 col-md-5 col-xs-12" style="clear: both">
            <div class="howto-label"><div>3</div></div> <h3> Укажите местоположение</h3>
            <p>Перетащите маркер на Ваш объект недвижимости.</p>
        </div>
        
        <div class="col-sm-6 col-md-5 col-xs-12" >
            <div class="howto-label"><div>4</div></div><h3> Загрузите фотографии Вашего объекта</h3>
            <p>Добавьте фотографии Вашего объекта недвижимости для привлечения большего числа посетителей</p>
        </div>

    </div>
</div>
<section class="service" id="service">
    <div class="container" >
        <div class="row" >
            <div class="col-sm-12 text-center" style="margin-bottom: 60px; margin-top: 30px">
                <div class="title-service" >Наши услуги</div>
            </div>
            <div class="col-sm-12 text-center">
                <div class="row" style="color: white">
                    <div class="ico-xs col-md-4 col-sm-6 col-xs-12">
                        <div class="img-ico one"></div>
                        <h3>Поиск недвижимости</h3>
                        <p class="sales">На нашем ресурсе реализован максимально удобный поиск недвижимости</p>
                    </div>

                    <div class="ico-xs col-md-4 col-sm-4 col-xs-12">
                        <div class="img-ico two"></div>
                        <h3>Размещение объявлений</h3>
                        <p class="sales">Простой и удобный интерфейс для публикации объявлений</p>
                    </div>

                    <div class="ico-xs col-md-4 col-sm-4 col-xs-12">
                        <div class="img-ico three"></div>
                        <h3>Сотрудничетво</h3>
                        <p class="sales">Предоставление услуг для агентов и застройщиков</p>
                    </div>


        

                </div>
            </div>



        </div>
    </div>

</section>


<!--<a href="#myModal" class="btn btn-primary" data-toggle="modal">Открыть модальное окно</a>  -->
<!-- HTML-код модального окна -->
<div id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content cart">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title text-center">Выберите Ваш город</h4>
      </div>
      <!-- Основное содержимое модального окна -->
      <div class="modal-body">
          <div class="form">
              <div class="row">
         <?php \frontend\assets\DepDropAsset::register($this); ?>  
                  <div class="col-md-6">
        <?php $form = ActiveForm::begin(['id' => 'geo']); ?>   
        <?/*= $form->field($model, 'region')->dropDownList($model->country, [
            'prompt' => Yii::t('app', 'Укажите Вашу страну'),
            'data-trigger' => 'dep-drop',
            'data-target' => '#select-region',
            'data-url' => \yii\helpers\Url::to(['/data/regions']),
            'data-name' => 'cid',
            'id' => 'select-country',
        ]) */?>
 <!--   https://site-creator.pro/2016/11/07/%D0%B7%D0%B0%D0%B2%D0%B8%D1%81%D0%B8%D0%BC%D1%8B%D0%B5-%D0%B2%D1%8B%D0%BF%D0%B0%D0%B4%D0%B0%D1%8E%D1%89%D0%B8%D0%B5-%D1%81%D0%BF%D0%B8%D1%81%D0%BA%D0%B8-%D0%B2-yii2/                    -->
        <?php  $city_id = $location_arr['id'];
            $arr = ArrayHelper::map($regions_list,'id','name');
        ArrayHelper::multisort($arr, ['name'], [SORT_ASC]); ?>
        <?= $form->field($model, 'region')->label('Регион')->dropDownList(/*$regions_list*/ ArrayHelper::map($regions_list,'id','name'), [
            'prompt' => Yii::t('app', 'Укажите Ваш регион'),
            'disabled' => false,
            'id' => 'select-region',
            'data-trigger' => 'dep-drop',
            'data-target' => '#select-city',
            'data-url' => \yii\helpers\Url::to(['/data/cities']),
            'data-name' => 'rid',
            'city_id' => $location_arr['id'],
            'options' =>[ (int)$location_arr['region_id'] => ['Selected' => true]]
        ]) ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'city')->label('Город')->dropDownList([], [
            'prompt' => Yii::t('app', 'Укажите Ваш город'),
            //'disabled' => true,
            'id' => 'select-city',
        ]) ?>
        </div>
        </div>
</div>
      </div>
      <!-- Футер модального окна -->
      <div class="modal-footer text-center">
         
        <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Закрыть</button>
        
          <?= Html::submitButton('Сохранить', ['class' => 'in_but']) ?>
          <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>