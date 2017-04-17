<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AuthorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authors-index">

    <p>
        <?= Html::a('Добавить автора', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url,$model) {
                        return Html::a(
                            'Список книг ', ['/books/index', "id"=>$model->id],['class' => 'btn btn-default']);
                    },
                    'update' => function ($url,$model) {
                        return Html::a(
                            'Редактировать автора', ['update', "id"=>$model->id], ['class' => 'btn btn-default']);
                    },

                ],
            ],
        ],
    ]); ?>
</div>
