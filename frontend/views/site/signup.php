<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\CityWidget;


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

        padding-bottom: 100px;
    }

    .wrap{
        background: url(../web/images/54.jpg);
    }

    .col-lg-5{
        background: #ffffff9c;
        border-radius: 30px;
        padding: 20px 50px;
    }

    .breadcrumb{
        background-color: rgba(255, 255, 255, 0.5882352941176471);
    }
</style>

<?= CityWidget::widget([]) ?>