<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup">
  <div style="text-align: center">
      <h1><?= Html::encode($this->title) ?></h1>
      <p>Зарегистрируйтесь, чтобы разместить свои объявления</p>
  </div>


    <div class="i-am-centered">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
            <?//= $form->field($model, 'address') ?>

                <div class="form-group" style="text-align: center">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'in_but', 'name' => 'signup-button', 'style'=>'margin-bottom:15px'
                    ]) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
        </div>
</div>

<style>
    .site-signup{
        background-image: url("images/k.jpg");
        padding-bottom: 100px;
    }
</style>