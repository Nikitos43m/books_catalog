<?php
namespace frontend\controllers;
use app\models\GeobaseCity;
use app\models\GeobaseRegion;
use yii\helpers\ArrayHelper;
use \yii\web\Controller;
 
 
class DataController extends Controller
{
 
    public function beforeAction($action)
    {
        # Указываем формат ответа
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
 
        return parent::beforeAction($action);
    }
 
    public function actionRegions($cid = null) {
        $regions = GeobaseRegion::find()->select(['id', 'name'])->where(['country_id' => intval($cid)])->asArray()->all();
        return ArrayHelper::map($regions, 'id', 'name');
    }
 
    public function actionCities($rid = null) {
        $cities = GeobaseCity::find()->select(['id', 'name'])->where(['region_id' => intval($rid)])->asArray()->all();
        return ArrayHelper::map($cities, 'id', 'name');
    }
}
