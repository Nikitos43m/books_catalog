<?php

namespace frontend\controllers;

use Yii;
use app\models\Apartament;
use app\models\ApartamentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\UploadForm;
use yii\web\UploadedFile;
use yii\web\Response;

/**
 * ApartamentController implements the CRUD actions for Apartament model.
 */
class ApartamentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Apartament models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApartamentSearch();


        $user_id = Yii::$app->user->getId();
        $user = Yii::$app->user->identity->username;
        
       // if ($user == 9){
        if ($user == "admin"){
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }else {
            $dataProvider = $searchModel->searchUser(Yii::$app->request->queryParams, $user_id);
            return $this->render('user_index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Apartament model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Apartament model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Apartament();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Apartament model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model2 = new UploadForm();    //    var_dump($model2) ; die();
        $path = $model->image_path;
        
        

        if (($model->load(Yii::$app->request->post()) && $model->save()) || Yii::$app->request->isPost) {
          
              $model2->image = UploadedFile::getInstances($model2, 'image');
              $model2->upload($path);
            
            
            return $this->redirect(['update', 'id' => $model->id]);
        } else {            //var_dump($path);  die();
        
            return $this->render('update', [
                'model' => $model,
                'model2' => $model2,
            ]);
        }
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionUpload_img()
    {
        $model2 = new UploadForm();
        $path = "uploads/p.5/34122";

      //  if (Yii::$app->request->isPost) {
            $model2->image = UploadedFile::getInstances($model2, 'image');
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model2->upload($path)) {
                // file is uploaded successfully
                return;
            }
       // }

        return $this->render('update', ['model2' => $model2]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete_img($path)
    {   var_dump($path); die();
        $model2 = new UploadForm();
        //$path = "uploads/p.5/34122";

            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model2->delete($path)) {
                // file is uploaded successfully
                Yii::$app->session->setFlash('success', "принято!");
            }


        return $this->goHome();
    }



    /**
     * Deletes an existing Apartament model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Apartament model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apartament the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apartament::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
