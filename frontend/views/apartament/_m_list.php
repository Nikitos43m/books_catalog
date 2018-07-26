<?php
use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
/* @var $provider yii\data\ActiveDataProvider */
/* @var pages integer */

?>
<?php foreach ($provider->models as $apart): ?>
<?//=$apart["image_path"] ?>

<?php
 $images = scandir($apart["image_path"]); // сканируем папку
 $images = preg_grep("/\.(?:png|gif|jpe?g)$/i", $images);
?>
<?php

//foreach ($images as $image){
//    $arr = 
//}

foreach ($images as $image){
 
 if($apart["rooms"] == 11){
    $price = 'Студия ';
 }else{
    $price = $apart["rooms"].'<span class="min_m_title">-комн</span> '; 
 }
$carousel[] = 
 [
 'content' => '<img src="'.$apart["image_path"].htmlspecialchars(urlencode($image)).'" height="100%" />',
 'caption' => '<div class="m_title">'.$price.$apart["area"].'<span class="min_m_title">м<sup>2</sup></span></div>'
     . '<p>'.$apart["street"].' '.$apart["house"].'</p>'
     . '<p style="font-size:20px">'.number_format($apart["price"], 0, "", " ").'<i class="glyphicon glyphicon-ruble" aria-hidden="true" style="font-size: 14px"></i></p>'
     .Html::a("Открыть", ["/apartament/viewguest", "id"=>$apart->id], ['class' => 'btn btn-primary']),
    
 'options' => ['data-interval' => 'false'],
 'controls' => [
 
 ]    
 ];

}
    echo Carousel::widget([
        'items' => $carousel
    ]); 
    
    unset($carousel);
?>
<?php endforeach; ?> 

<?php echo LinkPager::widget([
    'pagination' => $pages,
]); ?>
<style>
    .carousel {
       margin-bottom: 20px;
    }
    
    .carousel-caption{
       text-shadow: 0 1px 2px rgba(0, 0, 0, 0.82); 
    }
    
    .carousel-indicators{
        bottom: 0px;
    }
    .m_title{
        color: white;
        font-size: 30px;
    }
    
    .min_m_title{
        font-size: 18px;
    }
    .carousel-inner > .item{
        height: 400px;
    }
    
    .carousel-inner > .item.next.left, .carousel-inner > .item.prev.right, .carousel-inner > .item.active{
        
    }
    
    .carousel-caption .btn{
       text-shadow: none;
       width: 150px;
       background: #078288;
       border-color:#078288;
       border-radius: 30px;
    }
    
    .carousel-indicators .active{
        background-color: #078288;
    }
    
    .carousel-indicators li{
        border: 1px solid #078288;
        width: 13px;
        height: 13px;
    }
    
    .carousel-indicators .active{
        width: 13px;
        height: 13px;
        margin: 1px;
    }
    
    .carousel-control{
        font-size: 30px;
    }
</style>