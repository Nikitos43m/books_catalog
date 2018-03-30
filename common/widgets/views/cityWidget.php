<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<div id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title text-center">Выберите Ваш город</h4>
      </div>
      <!-- Основное содержимое модального окна -->
      <div class="modal-body">
          <div class="form">
              <div class="row">
                  <div class="col-md-6">
         <?php \frontend\assets\DepDropAsset::register($this); ?>     
        <?php $form = ActiveForm::begin(['id' => 'geo']); ?>   
        <?/*= $form->field($model, 'region')->dropDownList($model->country, [
            'prompt' => Yii::t('app', 'Укажите Вашу страну'),
            'data-trigger' => 'dep-drop',
            'data-target' => '#select-region',
            'data-url' => \yii\helpers\Url::to(['/data/regions']),
            'data-name' => 'cid',
            'id' => 'select-country',
        ]) */?>
 <!--   https://site-creator.pro/2016/11/07/%D0%B7%D0%B0%D0%B2%D0%B8%D1%81%D0%B8%D0%BC%D1%8B%D0%B5-%D0%B2%D1%8B%D0%BF%D0%B0%D0%B4%D0%B0%D1%8E%D1%89%D0%B8%D0%B5-%D1%81%D0%BF%D0%B8%D1%81%D0%BA%D0%B8-%D0%B2-yii2/                    -->
        <?php  $city_id = $location_arr['id'];
            $arr = ArrayHelper::map($regions_list,'id','name');
        ArrayHelper::multisort($arr, ['name'], [SORT_ASC]); ?>
        <?= $form->field($model, 'region')->label("Регион")->dropDownList(/*$regions_list*/ ArrayHelper::map($regions_list,'id','name'), [
            'prompt' => Yii::t('app', 'Укажите Ваш регион'),
            'disabled' => false,
            'id' => 'select-region',
            'data-trigger' => 'dep-drop',
            'data-target' => '#select-city',
            'data-url' => \yii\helpers\Url::to(['/data/cities']),
            'data-name' => 'rid',
            'city_id' => $location_arr['id'],
            'options' =>[ (int)$location_arr['region_id'] => ['Selected' => true]]
        ]) ?>
                  </div>
                  <div class="col-md-6">
        <?= $form->field($model, 'city')->label("Город")->dropDownList([], [
            'prompt' => Yii::t('app', 'Укажите Ваш город'),
            //'disabled' => true,
            'id' => 'select-city',
        ]) ?>
                   </div>
              </div>
          </div>
      </div>
      <!-- Футер модального окна -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <!-- <button type="button" class="btn btn-primary">Сохранить изменения</button> -->
          <?= Html::submitButton('Сохранить', ['class' => 'in_but']) ?>
          <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>
