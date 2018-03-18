<?php

use yii\helpers\Html;
use yii\bootstrap\Carousel;
?>

<?php
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
    $fimg .= "<a href='".$path.htmlspecialchars(urlencode($image))."' rel='fancybox".$model->id."' ><img class='photo-view' src='".$path.htmlspecialchars(urlencode($image))."' height='100px' alt='".$image."'></a>";
   // $fimg .= "<a href='".$path.htmlspecialchars(urlencode($image))."'  onclick='message(\"".$path.htmlspecialchars(urlencode($image))."\"); return false;'><img class='photo-view' height='130px' src='".$path.htmlspecialchars(urlencode($image))."' height='40px' alt='".$image."'></a>";

}

?>


<div class="appartament_view">
    <div class="left-item">
        <?php if (empty($images)): ?>
            Без фото
        <? endif;?>
    <?=$fimg ?>
    </div>
</div>

    <div class="center-item">
        <span><?//= Html::encode($model->street) ?></span>
        <span><?//= Html::encode($model->area) ?> </span>
    </div>


    
</div>