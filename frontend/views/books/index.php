<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BooksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $id int */

$this->title = 'Книги';

?>
<div class="books-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить книгу', ['create', "id"=>$searchModel->author_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Вернуться', ['/authors/index'], ['class' => 'btn btn-default']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}{link}',
                'buttons' => [
                    'update' => function ($url,$model) {
                        return Html::a(
                            'Редактировать   ', ['update', "id"=>$model->id]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
