<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'GNS',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
       // ['label' => 'Главная', 'url' => ['/site/index']],
      //  ['label' => 'О нас', 'url' => ['/site/about']],
       // ['label' => 'Контакты', 'url' => ['/site/contact']],
       // ['label' => 'Каталог книг', 'url' => ['/authors/index']],
    ];
    if (Yii::$app->user->isGuest) {
       // $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $menuItems[] = '<li>'.Html::a('<i class="glyphicon glyphicon-user" aria-hidden="true"></i> Регистрация', ['/site/signup'], ['class' => 'btn btn-link']).'</li>
               <li>';
        //$menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
        $menuItems[] = '<li>'.Html::a('<i class="glyphicon glyphicon-log-in" aria-hidden="true"></i> Вход', ['/site/login'], ['class' => 'btn btn-link']).'</li>
               <li>';
    } else {
        $menuItems[] = '<li>'.Html::a('<i class="glyphicon glyphicon-star" aria-hidden="true"></i> Избранное', ['/site/myappart'], ['class' => 'btn btn-link']).'</li>';
        
        $menuItems[] = '<li>'.Html::a('<i class="glyphicon glyphicon-home" aria-hidden="true" style=" margin-right: 10px;"></i>Мои объявления', ['/apartament/index'], ['class' => 'btn btn-link']).'</li>
               <li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                '<i class="glyphicon glyphicon-log-out" aria-hidden="true"></i> Выход (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => 'Главная', 'url' => Yii::$app->homeUrl],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
