<?php
namespace frontend\controllers;

use app\models\Apartament;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use app\models\GeobaseCity;
use frontend\models\ApartamentForm;
use common\models\EntryForm;
use yii\web\UploadedFile;
use app\models\ApartamentSearch;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use himiklab\ipgeobase\IpGeoBase;
use frontend\models\CityForm;
use yii\data\Pagination;
/**
 * Site controller
 */
class SiteController extends Controller
{
    
                
    //public $city_layout;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;
        $session->open();

        $city_form = new CityForm();

        // Заполнение/обновление базы
        //Yii::$app->ipgeobase->updateDB();
        
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


            //GeobaseCity::find()->where(['id' => $my_city])->one();
            $geo_city = GeobaseCity::findById($my_city);
            //$session['geo_city'] = $geo_city;
            if($geo_city != NULL){
            /* Название города в шапку */
            //$this->view->params['my_city'] = $geo_city->getName();
           // Yii::$app->params['my_city'] = $geo_city->getName();
             $session['my_city_name'] = $geo_city->getName();
            
            $lat = $geo_city->getLat();
            $lng = $geo_city->getLng();

            $session['lat'] = $lat;
            $session['lng'] = $lng;
            }
            $regions_list = (new \yii\db\Query())
                ->select(['id', 'name'])
                ->from('geobase_region')
                ->orderBy([
                    'name' => SORT_ASC
                ])
                ->all();
            
            //$session['regions_list'] = $regions_list;
            //print_r($regions_list); die();

            $count = null;
            if (!Yii::$app->user->isGuest) {
                /* Количество объявлений пользователя */
                $user_id = Yii::$app->user->getId();
                $model = \common\models\User::findById($user_id);
                $counts = $model->getApartament()->count();
                $count = (int)$counts;
                
                $type_account = $model->getTypeAccount();
                //var_dump($type_account); die();

            }


            $searchModel = new ApartamentSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $session['my_city']);
            $dataProviderTable = $searchModel->searchTable(Yii::$app->request->queryParams, $session['my_city']);
            
            $countQuery = clone  $dataProviderTable;
            $pages = new Pagination(['totalCount' => $countQuery->getTotalCount(), 'pageSize' => 9]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderTable' => $dataProviderTable,
            'count' => $count,
            'pages' => $pages,
            'type_account' => $type_account,
            //'region' => $region,
            //'city' => $city
            'location_arr' => $geo_city,
            'model' => $city_form,
            'regions_list' => $regions_list,
            'lat' => $lat,
            'lng' => $lng
        ]);

    }

    

    
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionRent(){
        $apartament = Apartament::find()
            ->where(['type' => 1])
            ->asArray()
            ->all();
        return $this->render('index', ['apartament' => $apartament]);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionSale(){
        $apartament = Apartament::find()
            ->where(['type' => 0])
            ->asArray()
            ->all();
        return $this->render('index', ['apartament' => $apartament]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {   
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    /**
     * Displays catalog page.
     *
     * @return mixed
     */
    public function actionAuthors()
    {
        return $this->render('/authors/index');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                   // Yii::$app->session->setFlash('success', 'Thank for registration!');
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте ваш email и следуйте инструкциям.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось отправить письмо.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    public function actionEntry()
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // данные в $model удачно проверены

            // делаем что-то полезное с $model ...

            return $this->render('entry-confirm.php', ['model' => $model]);
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->render('entry', ['model' => $model]);
        }
    }

   /* public function actionApartament()
    {   $model = new Apartament();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->render('apartament', ['model' => $model]);
        } {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->render('entry', ['model' => $model]);
        }
    }*/
    
    public function actionComplex()
    {
        return $this->render('complex', []);
    }
    

    public function actionApartament()
    {
        $model = new ApartamentForm();

        if ($model->load(Yii::$app->request->post())) {
           
            if ($model->validate()) {
                $model->save();
                Yii::$app->session->setFlash('success', "Объявление принято!");
                return $this->goHome();
                
            }
        }

        return $this->render('apartament', [
            'model' => $model,
        ]);
    }
    
    public function actionMyappart()
    {  
       $user_id = Yii::$app->user->getId();
       $model = \common\models\User::findById($user_id); 
       
       $saved_str = $model->my_appart;
       $saved_ad = explode(",", $saved_str);
       
       foreach ($saved_ad as $val){
           $arr_int[] = (int)$val;
       }
       $query = Apartament::find()->where(['in','id', $arr_int]);
      
       $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);
       
       return $this->render('/apartament/my_appart', [
         //   'model' => $model,
        //    'saved_ad' => $saved_ad
           'dataProvider' => $dataProvider
        ]); 
    }
    
    public function actionDeletead($id)
    {  
       $user_id = Yii::$app->user->getId();
       $model = \common\models\User::findById($user_id);
       
       /*Преобразование в массив*/
       $saved_str = $model->my_appart;
       $saved_ad = explode(",", $saved_str);
       foreach ($saved_ad as $val){
           $arr_int[] = (int)$val;
       }
       
       /*Удаление в массиве */
       foreach($arr_int as $key => $value) {
         if ($id == $value) {
             unset($arr_int[$key]);
         }
       }
       
        /*Преобразование обратно в строку*/
       $str = implode(",", $arr_int);
       $model->my_appart = $str;
       $model->save();
      // var_dump($arr_int); die();
        //return true;
        Yii::$app->runAction('site/myappart');

         
    }

    


    public function actionApartament_user()
    {
        $session = Yii::$app->session;
        $session->open();
        //var_dump($session['my_city']); die();
        
        $model = new ApartamentForm();

        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', "Зарегистрируйтеь либо войдите");
            return $this->goHome();

            
        }
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                /*Путь к фоткам в базе*/
                //$path = "uploads/p.{$model->user_id}";
                $path = "uploads/p.{$model->user_id}/{$model->area}{$model->floor}{$model->rooms}/";
                $model->image_path = $path;
                $model->count_views = 0;
               
                $model->save();

                /*Загрузка фотографий */
                //$model->image = UploadedFile::getInstances($model, 'image');
                //var_dump($model->image); die();
                if (!file_exists($path)) {
                    mkdir($path, 0775, true);
                }
                //$model->image->saveAs("{$path}/{$model->image->baseName}.{$model->image->extension}");
                
                /*    foreach ($model->image as $file) {
                        $file->saveAs("{$path}/{$file->baseName}.{$file->extension}");
                    }
                */
                
               // $model->upload();
                Yii::$app->session->setFlash('success', "Объявление принято!");
                //return $this->goHome();
                
                //$query = Apartament::find()->where(['in','id', $arr_int]);
                
                return $this->redirect(['apartament/update', 'id' => Yii::$app->db->lastInsertID]);
               

            }
        }

        return $this->render('apartament_user', [
            'model' => $model
        ]);
    }

    public function createDirectory($path) {

            mkdir($path, 0775, true);


    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
