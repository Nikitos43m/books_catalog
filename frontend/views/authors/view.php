<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Authors */
/* @var $books app\models\Books */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="authors-view">
    <div class="col-xs-6 col-md-4">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>



    <?= Html::a('Добавить книгу', ['addbook', "id"=>$model->id], ['class' => 'btn btn-success']) ?>

    </div>
    <div class="col-xs-6 col-md-4">
    <h3>Список книг</h3>
<?php foreach ($books as $b){echo $b["title"]."<br>";}?>
</div>

</div>
</div>