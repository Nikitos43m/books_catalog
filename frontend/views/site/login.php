<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div style="text-align: center">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Войдите в личный кабинет для управления своими объявлениями</p>
    </div>
    <div class="i-am-centered">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label("Запомнить меня") ?>

                <div style="color:#999;margin:1em 0">
                    Забыли пароль? <?= Html::a('Восстановить', ['site/request-password-reset']) ?>.
                </div>

                <div class="form-group" style="text-align: center">
                    <?= Html::submitButton('Войти', ['class' => 'in_but', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
</div>

<style>
    .site-login{
        background-image: url("images/k.jpg");
        padding-bottom: 150px;
    }
</style>