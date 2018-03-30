<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\CityWidget;


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
        'responsive' => true,
        'bordered' => false,
        'striped' => false,
        'panel' => [
            'type' => GridView::TYPE_ACTIVE,
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>


<style>
    #w0-togdata-page{
        display: none;
    }
</style>


 <?= CityWidget::widget([]) ?>