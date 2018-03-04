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

    <div class="row" style="text-align: center; margin-bottom: 40px; padding: 12px; background: rgba(242, 242, 242, 0.3215686274509804)">
        <?=$fimg ?>
    </div>
    <div style="text-align: center; font-size: 18px">
        <div class="row" style="margin-bottom: 30px">
            <div class="col-sm-4">
               Площадь: <?=$model->area;?> м<sup>2</sup>
            </div>
            <div class="col-sm-4">
               Комнат: <?=$model->rooms;?>
            </div>
            <div class="col-sm-4">
                Этаж: <?=$model->floor;?>
            </div>
        </div>

        <div class="row" >
            <div class="col-sm-4"><b>Описание</b></div>

        </div>
        <div class="row">
            <div class="col-sm-8">
            <span style="font-size: 14px"> <?=$model->description;?> </span>
            </div>
        </div>
    <div>
        
    </div>
</div>

</div>

