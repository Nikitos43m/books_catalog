<?php

use yii\helpers\Html;
use yii\bootstrap\Carousel;

echo newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=fancybox'.$model->id.']',
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


$fimg="";
$path = $model->image_path;

$images = scandir($path); // сканируем папку
$images = preg_grep("/\.(?:png|gif|jpe?g)$/i", $images);

foreach($images as $image) {
   // $fimg .= "<a href='https://yourooms.ru/".$path.htmlspecialchars(urlencode($image))."' rel='fancybox".$model->id."' ><img class='photo-view' src='https://yourooms.ru/".$path.htmlspecialchars(urlencode($image))."' height='100px' alt='".$image."'></a>";
   // $fimg .= "<a href='".$path.htmlspecialchars(urlencode($image))."' rel='fancybox' ><img class='photo-view' height='130px' src='".$path.htmlspecialchars(urlencode($image))."' height='40px' alt='".$image."'></a>";
$fimg .= "<a href='".$path.htmlspecialchars(urlencode($image))."' rel='fancybox".$model->id."' onclick='message(\"".$path.htmlspecialchars(urlencode($image))."\"); return false;'><img class='photo-view' height='130px' src='".$path.htmlspecialchars(urlencode($image))."' height='40px' alt='".$image."'></a>";
}
?>


<div class="row">
    
  <?php if (empty($images)): ?>
    <div style="margin-left: 20px"><b> Без фото </b></div>
  <? endif;?>
  <div class="col-md-12 grid-photo">
    <?=$fimg ?>
  </div>
</div>

    <div class="center-item">
        <span><?//= Html::encode($model->street) ?></span>
        <span><?//= Html::encode($model->area) ?> </span>
    </div>

<style>
    .grid-view td {
        white-space: normal; 
     }
     
     .row {
        margin-right: 0px;
        margin-left: 0px;
      }
</style>

    
