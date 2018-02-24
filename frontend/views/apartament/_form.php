<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url ;

/* @var $this yii\web\View */
/* @var $model app\models\Apartament */
/* @var $form yii\widgets\ActiveForm */
/* @var $form2 yii\widgets\ActiveForm */
/* @var $model2 frontend\models\UploadForm */
?>

<div class="apartament-form">
 <div class="row">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-4">
       
        <?= $form->field($model, 'type')->label('Тип объявления')->dropDownList([
            '0' => 'Продать квартиру',
            '1' => 'Сдать квартиру',
        ]); ?>
        
       <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
       <?= $form->field($model, 'house')->textInput(['maxlength' => true]) ?>
       <?= $form->field($model, 'rooms')->textInput() ?>
    </div>
    <div class="col-md-2">
       <?= $form->field($model, 'floor')->textInput() ?>
       <?= $form->field($model, 'area')->textInput() ?>
       <?= $form->field($model, 'price')->textInput() ?>
       <?= $form->field($model, 'telephone')->textInput(['maxlength' => true])->label('Телефон')->widget(\yii\widgets\MaskedInput::className(), [
           'mask' => '8(999)-999-9999',
       ]) ?>
    </div>

     <? if(Yii::$app->user->identity->username == "admin"): ?>
    <div class="col-md-2">
       <?= $form->field($model, 'lat')->textInput() ?>
       <?= $form->field($model, 'lng')->textInput() ?>
       <?= $form->field($model, 'user_id')->textInput() ?>
    </div>
     <? endif; ?>
 </div>
    

    
    
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'in_but']) ?>
        </div>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="row">
        <h2>Фотографии</h2>
    <div class="container">
        <?php
        //$path = "uploads/p.".Html::encode("{$model->user_id}")."/";
        $path = $model->image_path;
        $images = scandir($path); // сканируем папку
        $images = preg_grep("/\.(?:png|gif|jpe?g)$/i", $images);
        foreach($images as $image) { // делаем проход по массиву
          //  $fimg .= "<img  width='100px' src='".$path.htmlspecialchars(urlencode($image))."' alt='".$image."' />";
            $img_source .= "'".$path.htmlspecialchars(urlencode($image))."',";
        }
        
         foreach($images as $image){
             $initialPreview[] = $path.htmlspecialchars(urlencode($image));
         }

        foreach($images as $image){
            $initialPreviewConfig[] = htmlspecialchars(urlencode($image));
        }
            print_r($initialPreviewConfig);
        ?>
    </div>
    </div>
    
    <div class="row">
        
        <div class="col-md-8"><h4>Загрузите фотографии</h4>
         <?php $form2 = ActiveForm::begin(); ?>
         <?= $form2->field($model2, 'image[]')->label(false)->widget(FileInput::classname(), [
             
                'language' => 'ru',
                'options' => [
                    'multiple' => true, 
                ],
                
                'pluginOptions' => [
                    'uploadUrl' => Url::to (['/apartament/upload_img']),
                    'deleteUrl' => Url::to (['/apartament/delete_img', 'path' => $path.$image]),
                    'showCaption' => true,
                    'showRemove' => true,
                    'showUpload' => false,
                    'showPreview' => true,
                    
                    'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                    'browseLabel' =>  'Выбрать фотографии',
                    'allowedFileExtensions' => ['jpg','gif','png'],
                    'overwriteInitial' => false,
                    
                     'initialPreviewAsData'=>true,
                     'initialPreview'=> $initialPreview,
                    
                    'initialPreviewConfig' => $initialPreviewConfig,


                ],

                'pluginEvents' => [
                      //  'filebeforedelete' => new \yii\web\JsExpression('function(){alert("erwerwer");}'),
                    'filebeforedelete' => new \yii\web\JsExpression('function(event, key, data){
                    
                    alert(key);
                    
                    }'),

                ],
            ]);?>
             <?= Html::submitButton('Обновить фотографии', ['class' => 'in_but']) ?>
             <?php ActiveForm::end(); ?>
        </div>
    </div>
    
</div>
<style>
    .apartament-form{
        background-image: url("images/k.jpg");
        padding-bottom: 100px;
    }
</style>