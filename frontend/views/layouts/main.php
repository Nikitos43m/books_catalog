<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\widgets\CityWidget;
use common\widgets\ContactWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="shortcut icon" href="yr.ico" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <meta name="yandex-verification" content="8bab4085b0d277e3" />
    <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter49522690 = new Ya.Metrika2({
                    id:49522690,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/49522690" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</head>
<body>
<?php $this->beginBody() ?>
<?php $session = Yii::$app->session;
        $session->open();     
        //var_dump($session['my_city_name']); die();  ?>
<div class="wrap">

    <?php
    NavBar::begin([
        'brandLabel' => '<img src="images/logo2.png" width="120px" style="margin-top: 2px; margin-left: 10px">',
        'brandUrl' => Yii::$app->homeUrl,
        'brandOptions' => ['class' => 'brand', 'style'=>''],//options of the brand
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [ //['label' => $this->params['my_city'] ]
       // ['label' => 'Главная', 'url' => ['/site/index']],
      //  ['label' => 'О нас', 'url' => ['/site/about']],
       // ['label' => 'Контакты', 'url' => ['/site/contact']],
       // ['label' => 'Каталог книг', 'url' => ['/authors/index']],
    ];

    //$menuItemsLeft[] =Html::a('<img src="images/logo2.png" width="140px" style="float: left; margin-top: 9px;">', [Yii::$app->homeUrl]);
    $menuItemsLeft[] = '<li  class="font-menu">'.Html::a($session['my_city_name'].' <i class="
glyphicon glyphicon-map-marker" aria-hidden="true" style="top: 2px;"></i>', ['/site/index', 'src' => '', '#' => 'myModal'], ['class' => 'btn btn-link city',  'data-toggle'=>'modal']).'</li>
         <li>';
    
    if (Yii::$app->user->isGuest) {
        
        //$menuItems[]='<a href="#myModal" class="btn btn-primary" data-toggle="modal">'.$this->params['my_city'].'</a>';
        $menuItems[] = '<li class="font-menu"><div class="but_outer">'.Html::a('+ Подать объявление', ['/site/login'], ['class' => 'buy_but inhead']).'</div></li>
               <li>';
        
       // $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $menuItems[] = '<li class="font-menu">'.Html::a('<i class="glyphicon glyphicon-user" aria-hidden="true"></i> Регистрация', ['/site/signup'], ['class' => 'btn btn-link reg_but', 'style'=>'padding: 4px 18px;']).'</li>
               <li>';
        //$menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
        $menuItems[] = '<li class="font-menu">'.Html::a('<i class="glyphicon glyphicon-log-in" aria-hidden="true"></i> Вход', ['/site/login'], ['class' => 'btn btn-link reg_but', 'style'=> 'padding: 4px 16px;']).'</li>
               <li>';
    } else {
        $menuItems[] = '<li class="font-menu"><div class="but_outer">'.Html::a('+ Подать объявление', ['apartament_user'], ['class' => 'buy_but inhead']).'</div></li>
               <li>';
        
        $menuItems[] = '<li class="font-menu">'.Html::a('<i class="glyphicon glyphicon-heart" aria-hidden="true" style="color: rgb(10, 150, 140)"></i> Избранное', ['/site/myappart'], ['class' => 'btn btn-link reg_but', 'style'=>'padding: 4px 18px;']).'</li>';

        $menuItems[] = '<li class="font-menu">'.Html::a('<i class="glyphicon glyphicon-list-alt" aria-hidden="true" style=" margin-right: 10px;"></i>Мои объявления', ['/apartament/index'], ['class' => 'btn btn-link reg_but', 'style'=>'padding: 4px 18px;']).'</li>
               <li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                '<i class="glyphicon glyphicon-log-out" aria-hidden="true"></i> <span class="font-menu"> Выход </span>(<span class="font-menu">' . Yii::$app->user->identity->username . '</span>)',
                ['class' => 'btn btn-link reg_but', 'style' => 'width:100%;', ['data' => ['method' => 'post']] ]
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'items' => [
        [
            'label' => '<div class="menu">
                            <span class="menu-global menu-top"></span>
                            <span class="menu-global menu-middle"></span>
                            <span class="menu-global menu-bottom"></span>
                        </div>',
            'items' => [
                ['label' => 'Наши услуги', 'url' => Yii::$app->homeUrl.'#service', 'linkOptions' => ['id'=>'m1']],
                ['label' => 'Жилые комплексы', 'url' => ['/site/complex']],
                ['label' => 'Контакты', 'url' => Yii::$app->homeUrl.'#contacts', 'linkOptions' => ['id'=>'m2']],
            ],
        ],
    ],

        'encodeLabels' => false,
        'options' => ['class' =>'navbar-nav navbar-left gamb'], // set this to nav-tab to get tab-styled navigation
]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $menuItemsLeft
    ]);
    
    
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
                <div class="col-md-3 cn" id="contacts">
                    <ul>
                        <h3>Контакты</h3>
                        <li><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> г. Ростов-на-Дону</li>
                        <li><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> <a href="mailto:info@credit-history24.ru"> info@yourooms.ru</a></li>
                        <li>
                            <a target="_blank" href="https://vk.com"><div class="icon-button vk"></div></a>
                            <a target="_blank" href="https://instagramm.com"><div class="icon-button inst"></div></a>
                        </li>
                    </ul>
                </div>
                
                <div class="col-md-5 text-center our">
                    <h3>Обращайтесь к нам по вопросам сотрудничества и рекламы</h3>

                        <?=Html::a("<span class='contact-button'>Отправьте нам </span>сообщение", ['/site/index', 'src' => '', '#' => 'modalContact'], ['class' => 'btn contact-modal',  'data-toggle'=>'modal']) ?>
                  
                </div>

                <div class="col-md-4 col-xs-12 text-center sl">
                    <h3> Ищите и продавайте жилье вместе нами!</h3><br> 
                    <div class="about">На нашем сайте Вы можете искать недвижимость при помощи карты и таблицы, а также выгружать полученные данные. </div>
                    <div class="your_rooms">yourooms.ru</div>
                </div>
            </div>

          </div>
        <br>
        <p class="pull-left">&copy; YouRooms <?= date('Y') ?></p>

        
    </div>
</footer>
<?//= CityWidget::widget([]) ?>
<?= ContactWidget::widget([]) ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
