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
      <p><strong>Собственник</strong> может разместить максимум <strong>2</strong> объявления.</p>
      <p><strong>Агент</strong> может разместить <strong>неограниченное</strong> кол-во объявлений.</p>
  </div>


    <div class="i-am-centered">
    <div class="row">
        <div class="col-lg-6 reg">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            
                <?= $form->field($model, 'who')->label(false)->radioList([
                    '1' => 'Собственник',
                    '2' => 'Агент'
                    ],
                   ['class'=>'btn-group form-check-input',

                      "data-toggle"=>"buttons",  

                     'itemOptions'=>
                         ['labelOptions'=>[ 'class'=>'btn btn-default form-check-label'],


                         ],

                       ]
                   );
                ?>

                <?= $form->field($model, 'username')->textInput() ?>

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

    .reg{
        background: #ffffff9c;
        border-radius: 30px;
        padding: 20px 50px;
    }

    .breadcrumb{
        background-color: rgba(255, 255, 255, 0.5882352941176471);
    }
    
    .btn-default:active, .btn-default:focus, .btn-default:focus-within, .btn-default:hover, .btn-default.active, .open > .dropdown-toggle.btn-default {
        color: #828282;
        background-color: #12afc569;
        border-color: rgba(218, 218, 218, 0.4117647058823529);
        
    }
    
    .btn:focus, .btn:active:focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn.active.focus{
        outline: none;
    }
    
    .btn-default:active:hover, .btn-default.active:hover, .open > .dropdown-toggle.btn-default:hover, 
    .btn-default:active:focus, .btn-default.active:focus, .open > .dropdown-toggle.btn-default:focus, 
    .btn-default:active.focus, .btn-default.active.focus, .open > .dropdown-toggle.btn-default.focus{
        
        color: #828282;
        background-color: #12afc569;
        border-color: rgba(218, 218, 218, 0.4117647058823529);
    }
    
    .radio input[type="radio"], .radio-inline input[type="radio"], .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"]{
        display: none;
    }
    
    .radio label, .checkbox label{
        width: 300px;
        padding: 6px 20px;
    }
    
    #signupform-who{
        width: 100%;
        display: flex;
    }
    
    .radio + .radio, .checkbox + .checkbox{
        margin-top: 10px;
    }
    
    .radio, .checkbox {
        text-align: center;
        width: 50%;
    }
    
    @media (max-width: 420px)  {
        
        .radio label, .checkbox label{
            width: 300px;
        }
    
        #signupform-who{
            display: block;
        }
        
        .radio, .checkbox {
           text-align: center;
           width: 100%;
        }
    }
</style>

<?= CityWidget::widget([]) ?>