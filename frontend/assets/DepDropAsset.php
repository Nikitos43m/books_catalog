<?php
namespace frontend\assets;


use yii\web\AssetBundle;

class DepDropAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/dep_drop.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
