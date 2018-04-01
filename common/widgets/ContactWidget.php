<?php
namespace common\widgets;

use yii\base;
use Yii;
use frontend\models\ContactForm;

class ContactWidget extends \yii\base\Widget
{

    public function run()
    {

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail('nikitgoncharo@yandex.ru')) {
                $this->view->context->redirect(['site/index']);
                Yii::$app->session->setFlash('success', 'Сообщение отправлено. Спасибо, что связались с нами.');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка отправки сообщения.');
            }
        }
        return $this->render('contactWidget', [
            'model' => $model,
        ]);


    }
}