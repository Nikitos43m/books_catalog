<?php
namespace common\widgets;

use Yii;
use frontend\models\CityForm;
use app\models\GeobaseCity;


/**
 * Description of CityWidget
 *
 * @author Goncharov_n
 */
class CityWidget extends \yii\base\Widget{
   
    public function run()
    {
        $session = Yii::$app->session;
        $session->open();

        $city_form = new CityForm();
        
         if($session['my_city'] == NULL){
            $ip = Yii::$app->request->userIP;
            $ip = '83.221.207.185';
            $location_arr = Yii::$app->ipgeobase->getLocation($ip);
            $my_city = $location_arr['id'];
            $session['my_city'] = $my_city;
         }else{
            $my_city = $session['my_city']; 
         }
        if ($city_form->load(Yii::$app->request->post())){
            $data = Yii::$app->request->post('CityForm');
            $my_city = (int)$data['city'];
            $session['my_city'] = $my_city;
        }
        
        $geo_city = GeobaseCity::findById($my_city);
        Yii::$app->params['my_city'] = $geo_city->getName();
             $session['my_city_name'] = $geo_city->getName();
            
            $lat = $geo_city->getLat();
            $lng = $geo_city->getLng();


            $regions_list = (new \yii\db\Query())
                ->select(['id', 'name'])
                ->from('geobase_region')
                ->orderBy([
                    'name' => SORT_ASC
                ])
                ->all();
        
        
        return $this->render('cityWidget', [
            'location_arr' => $geo_city,
            'model' => $city_form,
            'regions_list' => $regions_list,
            'lat' => $lat,
            'lng' => $lng
        ]);
    }
}
