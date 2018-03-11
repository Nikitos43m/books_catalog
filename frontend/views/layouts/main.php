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
        $menuItems[] = '<li class="font-menu">'.Html::a('<i class="glyphicon glyphicon-user" aria-hidden="true"></i> Регистрация', ['/site/signup'], ['class' => 'btn btn-link']).'</li>
               <li>';
        //$menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
        $menuItems[] = '<li class="font-menu">'.Html::a('<i class="glyphicon glyphicon-log-in" aria-hidden="true"></i> Вход', ['/site/login'], ['class' => 'btn btn-link']).'</li>
               <li>';
    } else {
        $menuItems[] = '<li class="font-menu">'.Html::a('<i class="glyphicon glyphicon-heart-empty" aria-hidden="true"></i> Избранное', ['/site/myappart'], ['class' => 'btn btn-link']).'</li>';

        $menuItems[] = '<li class="font-menu">'.Html::a('<i class="glyphicon glyphicon-home" aria-hidden="true" style=" margin-right: 10px;"></i>Мои объявления', ['/apartament/index'], ['class' => 'btn btn-link']).'</li>
               <li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                '<i class="glyphicon glyphicon-log-out" aria-hidden="true"></i> <span class="font-menu"> Выход </span>(<span class="font-menu">' . Yii::$app->user->identity->username . '</span>)',
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
        <div class="row">
            <div class="col-md-12 col-xs-12 contacts">
                
                <ul>
                    <h3>Контакты</h3>
                    <li><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> г. Ростов-на-Дону, ул. Заводская, 11</li>
                    <li><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> <a href="mailto:info@credit-history24.ru"> info@credit-history24.ru</a></li>
                    <li>
                        <a target="_blank" href="https://vk.com"><div class="icon-button vk"></div></a>
                        <a target="_blank" href="https://instagramm.com"><div class="icon-button inst"></div></a>
                    </li>
                </ul>
            </div>
          </div>
        <br>
        <p class="pull-left">&copy; GNS <?= date('Y') ?></p>

        
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
