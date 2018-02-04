<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
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


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
