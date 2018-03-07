<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сохраненные объявления';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apartament-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(['id'=>'model-grid', 'enablePushState' => false]); ?>
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'options' => ['class' => 'table table-hover'],
        'tableOptions' => [
            'class' => 'table table-hover'
        ],

        //'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],
          //  ['format'=>'raw'],
         //   'id',
         //   'user_id',
         //   'type',
            'street',
            'house',
            'rooms',
            'floor',
            'area',
            'price',
            'telephone',
           // 'lat',
          //  'lng',


            ['class' => 'yii\grid\ActionColumn',
                'template' => '{open} {delete}',
                
                'buttons' => [
                    'format' => 'raw',
                    
                   'open' => function ($url,$model) {
                        return Html::a('Открыть', ["/apartament/view", "id"=>$model->id, "user_id"=> Yii::$app->user->getId()],
                 [   
                 // 'data-method' => 'post',
                  'data-pjax' => '#model-grid',
                 ]);
                    },
                    
                    'delete' => function ($url,$model) {
                        return Html::a('<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>', ['/site/deletead', "id"=>$model->id],
                 [   
                 // 'data-method' => 'post',
                  'data-pjax' => '#model-grid',
                 ]);
                    },
                            
                            
                         
                            
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
