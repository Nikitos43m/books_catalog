<?php

use yii\helpers\Html;
use yii\bootstrap\Carousel;
?>

<?php


$path = $model->image_path;
$images = scandir($path); // сканируем папку
$images = preg_grep("/\.(?:png|gif|jpe?g)$/i", $images);

foreach($images as $image) {
    $fimg .= "<a href='".$path.htmlspecialchars(urlencode($image))."' rel='fancybox' ><img class='photo-view' src='".$path.htmlspecialchars(urlencode($image))."' height='100px' alt='".$image."'></a>";
}

?>


<div class="appartament_view">
    <div class="left-item">
    фото
    </div>
</div>

    <div class="center-item">
        <span><?= Html::encode($model->street) ?></span>
        <span><?= Html::encode($model->area) ?> м<sup>2</sup></span>
    </div>


    
</div>