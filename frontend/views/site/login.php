<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\CityWidget;

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

                <?= $form->field($model, 'username')->textInput() ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label("Запомнить меня") ?>

                <div style="color:#999;margin:1em 0">
                    Забыли пароль? <?= Html::a('Восстановить', ['site/request-password-reset']) ?>.
                </div>

                <div class="form-group" style="text-align: center">
                    <?= Html::submitButton('Войти', ['class' => 'in_but', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
            <div class="form-group" style="text-align: center">
                <?= Html::a('<i class="glyphicon glyphicon-user" aria-hidden="true"></i> Зарегистрироваться', ['/site/signup'], ['class' => '']); ?>
            </div>
        </div>
    </div>
    </div>
</div>

<style>
    .site-login{

        padding-bottom: 150px;
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